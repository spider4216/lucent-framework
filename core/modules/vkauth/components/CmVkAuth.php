<?php

namespace core\modules\vkauth\components;

use core\classes\SysPassword;
use core\modules\users\models\Users;
use core\modules\vkauth\models\Vkauth;

class CmVkAuth
{
    private static $password = 'vkAuth_';
    public static $newUser;

    public static function getUrl()
    {
        $url = 'http://oauth.vk.com/authorize';
        $vkSettings = Vkauth::findAll();

        if (empty($vkSettings)) {
            return false;
        } else {
            $vkSettings = $vkSettings[0];
        }

        $params = [
            'client_id' => $vkSettings->client_id,
            'redirect_uri' => $vkSettings->redirect_uri,
            'response_type' => 'code'
        ];

        $link = $url . '?' . urldecode(http_build_query($params));

        return $link;
    }

    public static function registerVkUser($data)
    {
        $user = new Users();
        $user->setScript('vkAuth');

        $user->username = $data['screen_name'];
        $user->email = 'vkAuth@lucent.com';
        $user->password = SysPassword::hash(self::$password . time());
        $user->role_id = 2;

        if (!$user->save()) {
            return false;
        }

        self::$newUser = $user;

        return true;
    }

    public static function login($model, $username)
    {
        if (static::check($model, $username)) {
            $user = $model->findByColumn('username', $username);

            $user->setScript('signin');

            $user->hash = md5(time());

            if (!$user->save()) {
                return false;
            }

            setcookie('users', $username, 0, '/');
            setcookie('user_id', $user->id, 0, '/');
            setcookie('user_hash', $user->hash, 0, '/');

            return $user->id;
        }

        return false;
    }

    public static function check($model, $username)
    {
        $user_data = $model->findByColumn('username', $username);

        if (is_object($user_data)) {
            return true;
        }

        return false;
    }
}