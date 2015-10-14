<?php
namespace core\modules\users\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysAuth;
use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysPassword;
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
        static::$title = _("Users system");

        $view = new SysView();

        $view->display('index');
    }

    public function actionUser()
    {
        static::$title = _("Profile");

        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $user = Users::findByPk($id);

        if (empty($user)) {
            throw new E404;
        }

        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'user');
        $view = new SysView();

        $view->breadcrumbs = $breadcrumbs;
        $view->user = $user;

        $view->display('user');
    }

    public function actionRegister()
    {
        static::$title = _("Registration");

        $view = new SysView();
        $model = new Users();
        $model->setScript('create');

        $view->model = $model;

        if (SysAuth::is_login()) {
            SysMessages::set(_("You have already signed up"), 'info');
        }

        $view->display('register');
    }

    public function actionAjaxRegister()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $model = new Users();
        $model->setScript('create');
        $post = SysRequest::post();

        $model->username = $post['username'];
        $model->password = SysPassword::hash($post['password']);
        $model->email = $post['email'];
        $model->role_id = 2;

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        $id = SysAuth::login($model, $post['username'], $post['password']);

        //todo В случае ошибки транзакцию
        if (!$id) {
            SysAjax::json_err(_("cannot signed in"));
        }

        SysAjax::json_ok(_("User has been created successfully"), ['id' => $id]);
    }

    public function actionLogin()
    {
        static::$title = _("Sign in");

        $view = new SysView();
        $model = new Users();
        //$url = V

        if (SysAuth::is_login()) {
            SysMessages::set(_("you have already logged in"), 'info');
        }

        $view->model = $model;
        $view->display('login');
    }

    public function actionAjaxLogin()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $model = new Users();
        $post = SysRequest::post();

        if ($id = SysAuth::login($model, $post['username'], $post['password'])) {
            SysAjax::json_ok(_("You signed in as") . ' "' . $post['username'] . '"', ['id' => $id]);
        }

        SysAjax::json_err(_("username or password is not suitable"));
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
        $view = new SysView();
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Users::findByPk($id);

        if (!$model) {
            throw new E404;
        }

        $view->roleList = $roleList;
        $view->model = $model;
        $view->display('update');
    }

    public function actionAjaxUpdate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = Users::findByPk($post['id']);
        $model->setScript('update');

        $model->username = $post['username'];
        $model->email = $post['email'];
        $model->password = SysPassword::hash($post['password']);
        $model->role_id = $post['roles'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        if ($model->id == SysAuth::getCurrentUserId()) {
            SysAjax::json_ok(_("User has been updated successfully. Sign in system again"), ['login' => 'true']);
            SysAuth::logout();
        }

        SysAjax::json_ok(_("User has been updated successfully"));
    }

    public function actionDelete()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Users::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        if (SysAuth::getCurrentUserId() == $model->id) {
            SysMessages::set(_("authorized user can not be removed"), 'danger');
            SysRequest::redirect('/users/control/manage');
        }

        if ($model->delete()) {
            SysMessages::set(_("User has been deleted successfully"), 'success');
        } else {
            SysMessages::set(_("user can not be removed"), 'danger');
        }

        SysRequest::redirect('/users/control/manage');
    }
}