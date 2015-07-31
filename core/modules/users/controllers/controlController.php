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
                _("edit user") => '-',
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
                SysMessages::set(_("user not found"), 'danger');
                $display->render('core/views/errors/404', false, true);
            }

            $view->user = $user;

            $view->display('user');
        } else {
            SysMessages::set(_("user not found"), 'danger');
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
            SysMessages::set(_("You have already signed up"), 'info');
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
                SysMessages::set(_("username or password is not suitable"), 'danger');
            }
        }

        if (SysAuth::is_login()) {
            SysMessages::set(_("you have already logged in"), 'info');
        }

        $view->model = $model;
        $view->display('login');
    }

    public function actionLogout()
    {
        if (SysAuth::logout()) {
            SysRequest::redirect('/');
        } else {
            SysMessages::set(_("Exit from system is not possible"), 'danger');
        }
    }

    public function actionManage()
    {
        static::$title = _("Manage users");

        $model = new Users();

        $view = new SysView();
        $view->model = $model;

        $view->display('manage');
    }

    public function actionUpdate()
    {
        static::$title = _("Edit user");

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
                    SysMessages::set(_("User") . ' "' . ' ' . $post['username'] . '" ' . _("has been updated successfully.") .
                        ' ' . _("Sign in system again"), 'success');
                    SysAuth::logout();
                    SysRequest::redirect('/users/control/login');
                }

                SysMessages::set(_("User") . ' "' . $post['username'] . '" ' . _("has been updated successfully"), 'success');
                SysRequest::redirect('/users/control/manage');
            }

            $view->model = $model;

            $view->display('update');
            return true;
        }

        if ($id = SysRequest::get('id')) {
            $model = Users::findByPk($id);

            if (!$model) {
                SysMessages::set(_("user not found"), 'danger');
                $display->render('core/views/errors/404', false, true);
                return true;
            }

            $view->model = $model;
            $view->display('update');
        } else {
            SysMessages::set(_("user not found"), 'danger');
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
                    SysMessages::set(_("User") . ' ' . $model->username . ' ' . _("has been deleted successfully"), 'success');
                } else {
                    //SysMessages::set(_("Ошибка при удалении пользователя"), 'danger');
                    SysMessages::set(_("user can not be removed"), 'danger');
                }
            } else {
                SysMessages::set(_("authorized user can not be removed"), 'danger');
                SysRequest::redirect('/users/control/manage');
            }
            SysRequest::redirect('/users/control/manage');
        } else {
            $display = new SysDisplay();
            SysMessages::set(_("unidentified user"), 'danger');
            $display->render('core/views/errors/404', false, true);
        }
    }
}