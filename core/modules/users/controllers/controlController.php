<?php
namespace core\modules\users\controllers;

use core\classes\cauth;
use core\classes\ccontroller;
use core\classes\cmessages;
use core\classes\cpassword;
use core\classes\cdisplay;
use core\classes\cview;
use core\classes\request;
use core\modules\users\models\users;

class ControlController extends Ccontroller
{
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
}