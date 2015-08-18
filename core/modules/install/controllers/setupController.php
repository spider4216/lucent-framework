<?php
namespace core\modules\install\controllers;

use core\classes\SysAuth;
use core\classes\SysCodeGenerate;
use core\classes\SysController;
use core\classes\SysDatabase;
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
        static::$title = _("Install");
        static::$layout = SysPath::directory('core') . '/views/layouts/install.php';

        $directory = SysPath::directory('app') . '/config/';
        $filename = 'database.php';
        $path = $directory . $filename;

        if (file_exists($path)) {
            SysRequest::redirect('/');
        }

        $directoryConfig = SysPath::directory('app') . '/config/';
        $filenameConfig = 'main.php';
        $pathConfig = $directoryConfig . $filenameConfig;

        if (file_exists($pathConfig)) {
            SysRequest::redirect('/');
        }

        $view = new SysView();
        $view->display('index');
    }

    public function actionProcess()
    {
        if ($post = $_POST) {
            static::$title = _("Install");
            static::$layout = SysPath::directory('core') . '/views/layouts/install.php';

            foreach ($post as $key => $p) {
                if (empty($p)) {
                    if ($key !== 'dbpassword') {
                        SysMessages::set(_("All fields have to be filled"), 'danger');
                        SysRequest::redirect('/install/setup/');
                    }
                }
            }

            try {
                SysDatabase::checkDatabaseConnection($post['dbname'], $post['dbhost'], $post['dbusername'],
                    $post['dbpassword']);
            } catch (\PDOException $e) {
                SysMessages::set(_("Problem with database connection"), 'danger');
                SysMessages::set($e->getMessage(), 'danger');
                SysRequest::redirect('/install/setup/');
            }

            //--
            $directory = SysPath::directory('app') . '/config/';
            $filename = 'database.php';
            $path = $directory . $filename;

            if (file_exists($path)) {
                SysMessages::set(_("file with database information has already exist. Delete file and try it again"),
                    'danger');
                SysRequest::redirect('/install/setup/');
            }

            $databaseContent = SysCodeGenerate::dbFile($post['dbname'], $post['dbusername'], $post['dbpassword'],
                $post['dbhost']);

            if (!is_writable($directory)) {
                SysMessages::set(_("directory") . ' "app/config" ' . _("is not writable"), 'danger');
                SysRequest::redirect('/install/setup/');
            }

            $directoryConfig = SysPath::directory('app') . '/config/';
            $filenameConfig = 'main.php';
            $pathConfig = $directoryConfig . $filenameConfig;

            if (file_exists($pathConfig)) {
                SysMessages::set(_("main config has already exist. Delete file and try it again"), 'danger');
                SysRequest::redirect('/install/setup/');
            }

            $configContent = SysCodeGenerate::configMain($post['projectName'], $post['lang']);

            if (!is_writable($directoryConfig)) {
                SysMessages::set(_("directory") . ' "app/config" ' . _("is not writable"), 'danger');
                SysRequest::redirect('/install/setup/');
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
                    SysMessages::set(_("Database file not found"), 'danger');
                    SysRequest::redirect('/install/setup/');
                }

                if (!file_exists($pathConfig)) {
                    SysMessages::set(_("Config file not found"), 'danger');
                    SysRequest::redirect('/install/setup/');
                }

                if (!unlink($path)) {
                    SysMessages::set(_("Database file cannot be deleted"), 'danger');
                    SysRequest::redirect('/install/setup/');
                }

                if (!unlink($pathConfig)) {
                    SysMessages::set(_("Config file cannot be deleted"), 'danger');
                    SysRequest::redirect('/install/setup/');
                }

                SysMessages::set(_("Rollback has been done successfully"), 'success');
                SysRequest::redirect('/install/setup/');
            }


            SysMessages::set(_("All configuration files were created."), 'success');
            SysRequest::redirect('/install/setup/finish');

        } else {
            SysRequest::redirect('/');
        }
    }

    public function actionFinish()
    {
        static::$title = _("Finish");

        $view = new SysView();
        $view->display('finish');
    }
}