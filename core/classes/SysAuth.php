<?php
namespace core\classes;

use core\modules\users\models\Roles;
use core\modules\users\models\Users;
use core\system\app;

class SysAuth {

    /**
     * @param $model - Users
     * @param $username - username
     * @param $password - password
     * @return bool|string
     * Авторизует пользователя
     */
    public static function login($model, $username, $password)
    {
        if (static::check($model, $username, $password)) {
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

    /**
     * @param $model - Users
     * @param $username
     * @param $password
     * @return bool
     * Аутентификация
     */
    public static function check($model, $username, $password)
    {
        $user_data = $model->findByColumn('username', $username);

        if (is_object($user_data)) {
            if ($user_data->username == $username && SysPassword::verify($password, SysPassword::hash($user_data->password))) {
                return true;
            }
        }

        return false;
    }


    public static function is_login()
    {
        return isset($_COOKIE['users']);
    }

    public static function getCurrentUser()
    {
        if (static::is_login()) {
            return $_COOKIE['users'];
        }

        return false;
    }

    /**
     * @return bool|string
     * Получить id текущего пользователя по его хэш полученного при авторизации
     */
    public static function getCurrentUserId()
    {
        if (!static::is_login()) {
            return false;
        }

        $userHash = $_COOKIE['user_hash'];

        $user = Users::findByColumn('hash', $userHash);

        if (!$user) {
            return false;
        }

        return $user->id;
    }

    public static function logout()
    {
        if (static::is_login()) {
            unset($_COOKIE['users']);
            unset($_COOKIE['user_id']);
            setcookie('users', null, -1, '/');
            setcookie('user_id', null, -1, '/');
            return true;
        }

        return false;
    }

    public static function getCurrentRole()
    {
        $userId = static::getCurrentUserId();

        if (false === $userId) {
            return false;
        }

        $user = Users::findByPk((int)$userId);

        if (empty($user)) {
            return false;
        }

        $userRoleId = $user->role_id;


        $role = Roles::findByPk($userRoleId);

        if (empty($role)) {
            return false;
        }

        return $role->name;
    }
}