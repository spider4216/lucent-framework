<?php
namespace core\modules\users\controllers;

use core\classes\cauth;
use core\classes\ccontroller;
use core\classes\cmessages;
use core\classes\cpassword;
use core\classes\cdisplay;
use core\classes\cview;
use core\classes\request;
use core\modules\users\models\roles;
use core\modules\users\models\users;
use core\modules\users\models\usersUpdate;

class ControlController extends Ccontroller
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

    public function actionIndex()
    {
        $view = new Cview();

        $view->display('index');
    }

    public function actionUser()
    {
        $display = new Cdisplay();

        if ($id = Request::get('id')) {
            $view = new Cview();
            $user = Users::findByPk($id);

            if (!$user) {
                Cmessages::set('Пользователь не найден', 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->user = $user;

            $view->display('user');
        } else {
            Cmessages::set('Пользователь не найден', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionRegister()
    {
        $view = new Cview();
        $model = new Users();

        $view->model = $model;

        if ($post = Request::post()) {
            $model->username = $post['username'];
            $model->password = Cpassword::hash($post['password']);

            if ($model->is_new_record('username', $model->username)) {
                if ($model->save()) {
                    Cmessages::set('Пользователь был успешно создан', 'success');
                    Cauth::login($model, $post['username'], $post['password']);
                    Request::redirect('/users/control/user?id=' . $model->id);
                }
            } else {
                Cmessages::set('Пользователь "'.$model->username.'" уже существует', 'danger');
            }
        }

        if (Cauth::is_login()) {
            Cmessages::set('Вы уже зарегистрированы', 'info');
        }

        $view->display('register');
    }

    public function actionLogin()
    {
        $view = new Cview();
        $model = new Users();

        if ($post = Request::post()) {
            if ($id = Cauth::login($model, $post['username'], $post['password'])) {
                Cmessages::set('Вы вошли как "' . $post['username'] . '"', 'success');
                Request::redirect('/users/control/user?id=' . $id);
            } else {
                Cmessages::set('Неверный логин или пароль', 'danger');
            }
        }

        if (Cauth::is_login()) {
            Cmessages::set('Вы уже вошли в систему', 'info');
        }

        $view->model = $model;
        $view->display('login');
    }

    public function actionLogout()
    {
        if (Cauth::logout()) {
            Request::redirect('/');
        } else {
            Cmessages::set('Не удается выйти из системы', 'danger');
        }
    }

    public function actionManage()
    {
        $model = new Users();

        $view = new Cview();
        $view->model = $model;

        $view->display('manage');
    }

    public function actionUpdate()
    {
        $roleList = Roles::findAll();

        if ($post = Request::post()) {
            $view = new Cview();
            $model = UsersUpdate::findByPk($post['id']);

            if ($model->username == $post['username']) {

                $model->username = $post['username'];
                $model->role_id = $post['roles'];

                if (!empty($post['password'])) {
                    $model->password = Cpassword::hash($post['password']);
                }

                $model->email = $post['email'];

                if ($model->save()) {
                    Cmessages::set('Пользователь ' . $model->username . ' был успешно обновлен', 'success');

                    if (Cauth::getCurrentUserId() == $model->id) {
                        Cauth::logout();
                        Cmessages::set('Снова войдите в систему для применения изменений', 'info');
                        Request::redirect('/users/control/login');
                    }

                    Request::redirect('/users/control/manage');
                }
            } else {
                if ($model->is_new_record('username', $post['username'])) {

                    $model->username = $post['username'];
                    $model->role_id = $post['roles'];

                    if (!empty($post['password'])) {
                        $model->password = Cpassword::hash($post['password']);
                    }

                    $model->email = $post['email'];

                    if ($model->save()) {
                        Cmessages::set('Пользователь ' . $model->username . ' был успешно обновлен', 'success');

                        if (Cauth::getCurrentUserId() == $model->id) {
                            Cauth::logout();
                            Cmessages::set('Снова войдите в систему для применения изменений', 'info');
                            Request::redirect('/users/control/login');
                        }

                        Request::redirect('/users/control/manage');
                    }
                } else {
                    Cmessages::set('Пользователь ' . $post['username'] . ' уже существует', 'danger');
                }
            }


            $view->model = $model;
            $view->roleList = $roleList;

            $view->display('update');
        }

        if ($id = Request::get('id')) {
            $model = UsersUpdate::findByPk($id);

            $view = new Cview();
            $view->roleList = $roleList;
            $view->model = $model;

            $view->display('update');
        } else {
            $display = new Cdisplay();
            Cmessages::set('Неопознанный пользователь', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = Request::get('id')) {
            $model = UsersUpdate::findByPk($id);

            if (Cauth::getCurrentUserId() != $model->id) {

                if ($model->delete()) {
                    Cmessages::set('Пользователь ' . $model->username . ' был успешно удвлен', 'success');
                } else {
                    Cmessages::set('Ошибка при удалении пользователя', 'danger');
                }

            } else {
                Cmessages::set('Нельзя удалить авторизованного пользователя', 'danger');
                Request::redirect('/users/control/manage');
            }

            Request::redirect('/users/control/manage');

        } else {
            $display = new Cdisplay();
            Cmessages::set('Неопознанный пользователь', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }
}