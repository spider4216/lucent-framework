<?php
namespace core\modules\install\controllers;

use core\classes\exception\E403;
use core\classes\SysAjax;
use core\classes\SysAuth;
use core\classes\SysCodeGenerate;
use core\classes\SysController;
use core\classes\SysDatabase;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysPassword;
use core\classes\SysPath;
use core\classes\SysRequest;
use core\classes\SysView;
use core\commands\CmdMigrate;
use core\modules\users\models\Users;

class setupController extends SysController
{
    public function actionIndex()
    {
        static::$title = SysLocale::t("Install");
        static::$layout = SysPath::directory('core') . '/views/layouts/install.php';

        $directory = SysPath::directory('app') . '/config/';
        $filename = 'database.json';
        $path = $directory . $filename;

        if (file_exists($path)) {
            SysRequest::redirect('/');
        }

        $directoryConfig = SysPath::directory('app') . '/config/';
        $filenameConfig = 'main.json';
        $pathConfig = $directoryConfig . $filenameConfig;

        if (file_exists($pathConfig)) {
            SysRequest::redirect('/');
        }

        $view = new SysView();
        $view->display('index');
    }

    public function actionProcess()
    {
        if (!SysAjax::isAjax()) {
            throw new E403(SysLocale::t("Forbidden"));
        }

        $post = $_POST;

         foreach ($post as $key => $p) {
            if (empty($p)) {
                if ($key !== 'dbpassword') {
                    SysAjax::json_err(SysLocale::t("All fields have to be filled"));
                }
            }
        }

        if (false === SysDatabase::checkDatabaseConnectionByData($post['dbname'], $post['dbhost'], $post['dbusername'],
                $post['dbpassword'])) {
            SysAjax::json_err(SysLocale::t("Problem with database connection"));
        }

        //--
        $directory = SysPath::directory('app') . '/config/';
        $filename = 'database.json';
        $path = $directory . $filename;

        if (file_exists($path)) {
            SysAjax::json_err(SysLocale::t("file with database information has already exist. Delete file and try it again"));
        }

        $databaseContent = SysCodeGenerate::dbFile($post['dbname'], $post['dbusername'], $post['dbpassword'],
            $post['dbhost']);

        if (!is_writable($directory)) {
            SysAjax::json_err(SysLocale::t("directory \"app/config\" is not writable"));
        }

        $directoryConfig = SysPath::directory('app') . '/config/';
        $filenameConfig = 'main.json';
        $pathConfig = $directoryConfig . $filenameConfig;

        if (file_exists($pathConfig)) {
            SysAjax::json_err(SysLocale::t("main config has already exist. Delete file and try it again"));
        }

        $configData = [
            'domain' => $_SERVER['HTTP_HOST'],
            'projectName' => $post['projectName'],
            'lang' => $post['lang'],
        ];
        $configContent = SysCodeGenerate::configMain($configData);

        if (!is_writable($directoryConfig)) {
            SysAjax::json_err(SysLocale::t("directory \"app/config\" is not writable"));
        }

        file_put_contents($path, $databaseContent);
        file_put_contents($pathConfig, $configContent);

        //migration
        $migrate = new CmdMigrate();
        $migrate::$param = 'init_9181433517326';


        $result = $migrate->actionRun();

        $user = new Users();
        $user->setScript('create');

        $user->username = $post['username'];
        $user->email = $post['email'];
        $user->password = SysPassword::hash($post['password']);
        $user->role_id = 1;

        //rollback
        if (!$user->save()) {
            $result = $migrate->actionDown();

            if (!file_exists($path)) {
                SysAjax::json_err(SysLocale::t("Database file for delete not found"));
            }

            if (!file_exists($pathConfig)) {
                SysAjax::json_err(SysLocale::t("Config file for delete not found"));
            }

            if (!unlink($path)) {
                SysAjax::json_err(SysLocale::t("Database file cannot be deleted. Rollback has been done successfully"));
            }

            if (!unlink($pathConfig)) {
                SysAjax::json_err(SysLocale::t("Config file cannot be deleted. Rollback has been done successfully"));
            }

            //get validator errors
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($user->getErrors()));
        }

        if (!SysAuth::login($user, $post['username'], $post['password'])) {
            $result = $migrate->actionDown();
            SysAjax::json_err(SysLocale::t("Cannot auth for some reasons"));
        }

        SysMessages::set(SysLocale::t("All configuration files were created"), 'success');
        SysAjax::json_ok(SysLocale::t("All configuration files were created, please wait..."));

    }

    public function actionFinish()
    {
        static::$title = SysLocale::t("Finish");

        $view = new SysView();
        $view->display('finish');
    }
}