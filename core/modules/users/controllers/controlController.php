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
use core\modules\users\models\UsersUpdate;
use core\classes\SysBreadcrumbs;

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
                'пользователи' => '-',
            ],

            'user' => [
                'пользователи' => '/users/control/',
                '%' => '-',
            ],

            'register' => [
                'пользователи' => '/users/control/',
                'регистрация' => '-',
            ],

            'login' => [
                'пользователи' => '/users/control/',
                'вход' => '-',
            ],

            'manage' => [
                'пользователи' => '/users/control/',
                'управление пользователями' => '-',
            ],

            'update' => [
                'пользователи' => '/users/control/',
                'управление пользователями' => '/users/control/manage',
                'редактировать пользователя' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        $view = new SysView();
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'index');

        $view->breadcrumbs = $breadcrumbs;
        $view->display('index');
    }

    public function actionUser()
    {
        $display = new SysDisplay();
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'user');

        if ($id = SysRequest::get('id')) {
            $view = new SysView();
            $view->breadcrumbs = $breadcrumbs;
            $user = Users::findByPk($id);

            if (!$user) {
                SysMessages::set('Пользователь не найден', 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->user = $user;

            $view->display('user');
        } else {
            SysMessages::set('Пользователь не найден', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionRegister()
    {
        $view = new SysView();
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'register');
        $model = new Users();

        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        if ($post = SysRequest::post()) {
            $model->username = $post['username'];
            $model->password = SysPassword::hash($post['password']);

            if ($model->is_new_record('username', $model->username)) {
                if ($model->save()) {
                    SysMessages::set('Пользователь был успешно создан', 'success');
                    SysAuth::login($model, $post['username'], $post['password']);
                    SysRequest::redirect('/users/control/user?id=' . $model->id);
                }
            } else {
                SysMessages::set('Пользователь "'.$model->username.'" уже существует', 'danger');
            }
        }

        if (SysAuth::is_login()) {
            SysMessages::set('Вы уже зарегистрированы', 'info');
        }

        $view->display('register');
    }

    public function actionLogin()
    {
        $view = new SysView();
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'login');
        $model = new Users();

        if ($post = SysRequest::post()) {
            if ($id = SysAuth::login($model, $post['username'], $post['password'])) {
                SysMessages::set('Вы вошли как "' . $post['username'] . '"', 'success');
                SysRequest::redirect('/users/control/user?id=' . $id);
            } else {
                SysMessages::set('Неверный логин или пароль', 'danger');
            }
        }

        if (SysAuth::is_login()) {
            SysMessages::set('Вы уже вошли в систему', 'info');
        }

        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;
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
        $model = new Users();

        $view = new SysView();
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'manage');
        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('manage');
    }

    public function actionUpdate()
    {
        $roleList = Roles::findAll();
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'update');

        if ($post = SysRequest::post()) {
            $view = new SysView();
            $model = UsersUpdate::findByPk($post['id']);

            if ($model->username == $post['username']) {

                $model->username = $post['username'];
                $model->role_id = $post['roles'];

                if (!empty($post['password'])) {
                    $model->password = SysPassword::hash($post['password']);
                }

                $model->email = $post['email'];

                if ($model->save()) {
                    SysMessages::set('Пользователь ' . $model->username . ' был успешно обновлен', 'success');

                    if (SysAuth::getCurrentUserId() == $model->id) {
                        SysAuth::logout();
                        SysMessages::set('Снова войдите в систему для применения изменений', 'info');
                        SysRequest::redirect('/users/control/login');
                    }

                    SysRequest::redirect('/users/control/manage');
                }
            } else {
                if ($model->is_new_record('username', $post['username'])) {

                    $model->username = $post['username'];
                    $model->role_id = $post['roles'];

                    if (!empty($post['password'])) {
                        $model->password = SysPassword::hash($post['password']);
                    }

                    $model->email = $post['email'];

                    if ($model->save()) {
                        SysMessages::set('Пользователь ' . $model->username . ' был успешно обновлен', 'success');

                        if (SysAuth::getCurrentUserId() == $model->id) {
                            SysAuth::logout();
                            SysMessages::set('Снова войдите в систему для применения изменений', 'info');
                            SysRequest::redirect('/users/control/login');
                        }

                        SysRequest::redirect('/users/control/manage');
                    }
                } else {
                    SysMessages::set('Пользователь ' . $post['username'] . ' уже существует', 'danger');
                }
            }


            $view->model = $model;
            $view->breadcrumbs = $breadcrumbs;
            $view->roleList = $roleList;

            $view->display('update');
        }

        if ($id = SysRequest::get('id')) {
            $model = UsersUpdate::findByPk($id);

            $view = new SysView();
            $view->roleList = $roleList;
            $view->model = $model;
            $view->breadcrumbs = $breadcrumbs;

            $view->display('update');
        } else {
            $display = new SysDisplay();
            SysMessages::set('Неопознанный пользователь', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = UsersUpdate::findByPk($id);

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
            $display->render('core/views/errors/404',false,true);
        }
    }
}