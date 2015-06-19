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
                'редактирование пользователя' => '-',
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
            static::$title = 'Личный кабинет';

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
        static::$title = 'Регистрация';

        $view = new SysView();
        $model = new Users();

        $view->model = $model;

        if ($post = SysRequest::post()) {
            $model->username = $post['username'];
            $model->password = SysPassword::hash($post['password']);
            $model->email = $post['email'];

            if ($model->save()) {
                SysMessages::set('Пользователь был успешно создан', 'success');
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
        static::$title = 'Войти';

        $view = new SysView();
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

        $model = new UsersUpdate();

        $view = new SysView();
        $view->model = $model;

        $view->display('manage');
    }

    public function actionUpdate()
    {
        static::$title = 'Редактирование пользователя';

        $roleList = Roles::findAll();
        $model = false;
        $display = new SysDisplay();
        $currentUsername = SysAuth::getCurrentUser();

        $view = new SysView();
        $view->roleList = $roleList;
        $attrExist = false;
        $allow = true;

        if ($post = SysRequest::post()) {
            $model = UsersUpdate::findByPk($post['id']);

            $oldUsername = $post['username'];
            $oldEmail = $post['email'];
            $oldRoleId = $post['roles'];

            if ($oldUsername != $model->username) {
                if (!$model->is_new_record('username', $oldUsername)) {
                    SysMessages::set('Пользователь "' . $oldUsername . '" уже существует', 'danger');
                    $attrExist = true;
                }

                if ($model->username == $currentUsername) {
                    SysMessages::set('Редактирование имени этого пользователя запрещено', 'danger');
                    $allow = false;
                }
            }

            if ($oldRoleId != $model->role_id) {
                if ($model->username == $currentUsername) {
                    SysMessages::set('Редактирование роли этого пользователя запрещено', 'danger');
                    $allow = false;
                }
            }

            if ($oldEmail != $model->email) {
                if (!$model->is_new_record('email', $oldEmail)) {
                    SysMessages::set('Email "' . $oldEmail . '" уже существует', 'danger');
                    $attrExist = true;
                }
            }

            if ($attrExist || !$allow) {
                $view->model = $model;
                $view->display('update');
                return false;
            }

            $model->username = $oldUsername;
            $model->email = $oldEmail;
            $model->password = SysPassword::hash($post['password']);
            $model->role_id = $post['roles'];

            if ($model->save()) {
                SysMessages::set('Пользователь "' . $oldUsername . '" успешно обновлен', 'success');
                SysRequest::redirect('/users/control/manage');
            }

            SysMessages::set('Ошибка при обновлении пользователя "' . $oldUsername . '"', 'danger');

        }

        if ($id = SysRequest::get('id')) {
            $model = UsersUpdate::findByPk($id);
        }

        if (!$model) {
            SysMessages::set('Не удается найти запись для редактирования', 'danger');
            $display->render('core/views/errors/404', false, true);
        }

        $view->model = $model;
        $view->display('update');
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
            $display->render('core/views/errors/404', false, true);
        }
    }
}