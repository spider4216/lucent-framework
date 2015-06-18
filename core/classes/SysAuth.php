<?php
namespace core\classes;

use core\system\app;

class SysAuth {

    public static function login($model, $username, $password)
    {
        if (static::check($model, $username, $password)) {
            $user_data = $model->findByColumn('username', $username);
            setcookie('users', $username, 0, '/');
            setcookie('user_id', $user_data->id, 0, '/');

            return $user_data->id;
        }

        return false;
    }

    public static function check($model, $username, $password)
    {
        $user_data = $model->findByColumn('username', $username);

        if (is_object($user_data)) {
            if ($user_data->username == $username && $user_data->password == SysPassword::hash($password)) {
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

    public static function getCurrentUserId()
    {
        if (static::is_login()) {
            return $_COOKIE['user_id'];
        }

        return false;
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
        $db = SysDatabase::getObj();
        $sql = 'SELECT * FROM ' . App::$config['system_tables']['users'] . ' WHERE id=:user_id';
        $result = $db->query($sql, [':user_id' => static::getCurrentUserId()]);

        if (!$result) {
            return false;
        }

        $result = $result[0];

        $user_role_id = $result->role_id;

        $sql = 'SELECT * FROM ' . App::$config['system_tables']['roles'] . ' WHERE id=:role_id';
        $result = $db->query($sql, [':role_id' => $user_role_id])[0];

        return $result->name;
    }
}