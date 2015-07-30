<?php
namespace core\modules\users\controllers;

use core\classes\SysAuth;
use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysPassword;
use core\classes\SysDisplay;
use core\classes\SysView;
use core\classes\SysRequest;
use core\modules\users\models\Roles;
use core\modules\users\models\Users;
use core\extensions\ExtBreadcrumbs;

class ControlController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
            'manage' => ['user', '-'],
            'update' => ['user', '-'],
            'delete' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                _("users") => '-',
            ],

            'user' => [
                _("users") => '/users/control/',
                '%' => '-',
            ],

            'register' => [
                _("users") => '/users/control/',
                _("registration") => '-',
            ],

            'login' => [
                _("users") => '/users/control/',
                _("sign in") => '-',
            ],

            'manage' => [
                _("users") => '/users/control/',
                _("manage users") => '-',
            ],

            'update' => [
                _("users") => '/users/control/',
                _("manage users") => '/users/control/manage',
                _("edit users") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = 'Система пользователей';

        $view = new SysView();

        $view->display('index');
    }

    public function actionUser()
    {
        $display = new SysDisplay();
        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'user');

        if ($id = SysRequest::get('id')) {
            $view = new SysView();
            $view->breadcrumbs = $breadcrumbs;
            $user = Users::findByPk($id);
            //static::$title = $user->username;
            static::$title = _("Profile");

            if (!$user) {
                SysMessages::set('Пользователь не найден', 'danger');
                $display->render('core/views/errors/404', false, true);
            }

            $view->user = $user;

            $view->display('user');
        } else {
            SysMessages::set('Пользователь не найден', 'danger');
            $display->render('core/views/errors/404', false, true);
        }
    }

    public function actionRegister()
    {
        static::$title = _("Registration");

        $view = new SysView();
        $model = new Users();
        $model->setScript('create');

        $view->model = $model;

        if ($post = SysRequest::post()) {
            $model->username = $post['username'];
            $model->password = SysPassword::hash($post['password']);
            $model->email = $post['email'];
            $model->role_id = 2;

            if ($model->save()) {
                SysMessages::set(_("User has been created successfully"), 'success');
                SysAuth::login($model, $post['username'], $post['password']);
                SysRequest::redirect('/users/control/user?id=' . $model->id);
            }
        }

        if (SysAuth::is_login()) {
            SysMessages::set('Вы уже зарегистрированы', 'info');
        }

        $view->display('register');
    }

    public function actionLogin()
    {
        static::$title = _("Sign in");

        $view = new SysView();
        $model = new Users();

        if ($post = SysRequest::post()) {
            if ($id = SysAuth::login($model, $post['username'], $post['password'])) {
                SysMessages::set(_("You signed in as") . ' "' . $post['username'] . '"', 'success');
                SysRequest::redirect('/users/control/user?id=' . $id);
            } else {
                SysMessages::set('Неверный логин или пароль', 'danger');
            }
        }

        if (SysAuth::is_login()) {
            SysMessages::set('Вы уже вошли в систему', 'info');
        }

        $view->model = $model;
        $view->display('login');
    }

    public function actionLogout()
    {
        if (SysAuth::logout()) {
            SysRequest::redirect('/');
        } else {
            SysMessages::set('Не удается выйти из системы', 'danger');
        }
    }

    public function actionManage()
    {
        static::$title = 'Управление пользователями';

        $model = new Users();

        $view = new SysView();
        $view->model = $model;

        $view->display('manage');
    }

    public function actionUpdate()
    {
        static::$title = 'Редактирование пользователя';

        $roleList = Roles::findAll();
        $display = new SysDisplay();
        $view = new SysView();

        $view->roleList = $roleList;

        if ($post = SysRequest::post()) {
            $model = Users::findByPk($post['id']);
            $model->setScript('update');

            $model->username = $post['username'];
            $model->email = $post['email'];
            $model->password = SysPassword::hash($post['password']);
            $model->role_id = $post['roles'];

            if ($model->save()) {
                if ($model->id == SysAuth::getCurrentUserId()) {
                    SysMessages::set('Пользователь "' . $post['username'] . '" успешно обновлен. ' .
                        'Зайдите в систему сново', 'success');
                    SysAuth::logout();
                    SysRequest::redirect('/users/control/login');
                }

                SysMessages::set('Пользователь "' . $post['username'] . '" успешно обновлен', 'success');
                SysRequest::redirect('/users/control/manage');
            }

            $view->model = $model;

            $view->display('update');
            return true;
        }

        if ($id = SysRequest::get('id')) {
            $model = Users::findByPk($id);

            if (!$model) {
                SysMessages::set('Не удается найти запись для редактирования', 'danger');
                $display->render('core/views/errors/404', false, true);
                return true;
            }

            $view->model = $model;
            $view->display('update');
        } else {
            SysMessages::set('Не удается найти запись для редактирования', 'danger');
            $display->render('core/views/errors/404', false, true);
            return true;
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Users::findByPk($id);
            if (SysAuth::getCurrentUserId() != $model->id) {
                if ($model->delete()) {
                    SysMessages::set('Пользователь ' . $model->username . ' был успешно удвлен', 'success');
                } else {
                    SysMessages::set('Ошибка при удалении пользователя', 'danger');
                }
            } else {
                SysMessages::set('Нельзя удалить авторизованного пользователя', 'danger');
                SysRequest::redirect('/users/control/manage');
            }
            SysRequest::redirect('/users/control/manage');
        } else {
            $display = new SysDisplay();
            SysMessages::set('Неопознанный пользователь', 'danger');
            $display->render('core/views/errors/404', false, true);
        }
    }
}