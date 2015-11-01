<?php

namespace core\modules\vkauth\controllers;

use core\classes\exception\E403;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\modules\users\models\Users;
use core\modules\vkauth\components\CmVkAuth;
use core\modules\vkauth\models\Vkauth;

class generalController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'settings' => ['user', '-'],
            'index' => ['user', '-'],
            'ajaxsettingssave' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                SysLocale::t("VK Auth") => '-',
            ],

            'settings' => [
                SysLocale::t("VK Auth") => '-',
                SysLocale::t("settings") => '-',
            ],

            'status' => [
                SysLocale::t("sign in") => '/users/control/login',
                SysLocale::t("VK Auth") => '-',
                SysLocale::t("settings") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("VK Auth");

        $view = new SysView();
        $url = CmVkAuth::getUrl();

        $view->vkAuthUrl = $url;
        $view->display('index');
    }

    public function actionSettings()
    {
        static::$title = SysLocale::t("VK Auth settings");

        $model = Vkauth::findAll();
        if (empty($model)) {
            $model = new Vkauth();
        } else {
            $model = $model[0];
        }

        $view = new SysView();

        $view->model = $model;
        $view->display('settings');

    }

    public function actionAjaxSettingsSave()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = Vkauth::findAll();

        if (empty($model)) {
            $model = new Vkauth();
        } else {
            $model = $model[0];
        }

        $model->client_id = $post['client_id'];
        $model->client_secret = $post['client_secret'];
        $model->redirect_uri = $post['redirect_uri'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Page has been created successfully"));
    }

    public function actionLogin()
    {
        $code = SysRequest::get('code');

        if (!$code) {
            SysMessages::set(SysLocale::t("code does not exist"), 'error');
            SysRequest::redirect('/vkauth/general/status');
        }

        $vkSettings = Vkauth::findAll();
        $url = 'https://oauth.vk.com/access_token';

        if (empty($vkSettings)) {
            SysMessages::set(SysLocale::t("Settings are empty now. Did you fill them?"), 'error');
            SysRequest::redirect('/vkauth/general/status');
        } else {
            $vkSettings = $vkSettings[0];
        }

        $params = [
            'client_id' => $vkSettings->client_id,
            'client_secret' => $vkSettings->client_secret,
            'code' => $code,
            'redirect_uri' => $vkSettings->redirect_uri
        ];

        $token = json_decode(file_get_contents($url . '?' . urldecode(http_build_query($params))), true);

        if (!isset($token['access_token'])) {
            SysMessages::set(SysLocale::t("Problem with access token"), 'error');
            SysRequest::redirect('/vkauth/general/status');
        }

        $params = [
            'uids' => $token['user_id'],
            'fields' => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $token['access_token'],
        ];

        $urlGet = 'https://api.vk.com/method/users.get';

        $userInfo = json_decode(file_get_contents($urlGet . '?' . urldecode(http_build_query($params))), true);

        if (empty($userInfo)) {
            SysMessages::set(SysLocale::t("problem with getting data from vk using api"), 'error');
            SysRequest::redirect('/vkauth/general/status');
        }
        $response = $userInfo['response'][0];

        $user = Users::findByColumn('username', $response['screen_name']);

        if (empty($user)) {

            if (!CmVkAuth::registerVkUser($response)) {
                SysMessages::set(SysLocale::t("Registration is not performed"), 'error');
                SysRequest::redirect('/vkauth/general/status');
            }

            if (!CmVkAuth::login(CmVkAuth::$newUser, CmVkAuth::$newUser->username)) {
                SysMessages::set(SysLocale::t("cannot signed in right now"), 'error');
                SysRequest::redirect('/vkauth/general/');
            }

            SysRequest::redirect('/');
        }

        if (!CmVkAuth::login($user, $user->username)) {
            SysMessages::set(SysLocale::t("cannot signed in right now"), 'error');
            SysRequest::redirect('/vkauth/general/status');
        }


        SysRequest::redirect('/');

    }

    public function actionStatus()
    {
        static::$title = SysLocale::t("VK Auth status");

        $view = new SysView();
        $view->display('status');
    }
}