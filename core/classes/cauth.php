<?php
namespace core\classes;


class Cauth {

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

        if ($user_data->username == $username && $user_data->password == Cpassword::hash($password)) {
            return true;
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
}