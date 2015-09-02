<?php
namespace core\modules\users\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysView;
use core\classes\SysRequest;
use core\modules\users\models\Roles;
use core\classes\SysDisplay;
use core\extensions\ExtBreadcrumbs;

class RolesController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
            'create' => ['user', '-'],
            'update' => ['user', '-'],
            'delete' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                _("users") => '/users/control/',
                _("manage roles") => '-',
            ],

            'create' => [
                _("users") => '/users/control/',
                _("manage roles") => '/users/roles/',
                _("create role") => '-',
            ],

            'update' => [
                _("users") => '/users/control/',
                _("manage roles") => '/users/roles/',
                _("edit role") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = _("Manage roles");

        $model = new Roles();
        $view = new SysView();

        $view->model = $model;

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = _("Create role");

        $model = new Roles();
        $view = new SysView();

        $view->model = $model;
        $view->display('create');
    }

    public function actionAjaxCreate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = new Roles();

        $model->name = $post['name'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Role has been created successfully"));
    }

    public function actionUpdate()
    {
        static::$title = _("Edit role");

        $view = new SysView();
        $display = new SysDisplay();
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Roles::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        $view->model = $model;
        $view->display('update');
    }

    public function actionAjaxUpdate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = Roles::findByPk($post['id']);

        if (empty($model)) {
            SysAjax::json_err(_("Role not found"));
        }

        $model->name = $post['name'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Role has been updated successfully"));
    }

    public function actionDelete()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Roles::findByPk($id);

        if ($model->id == '1' || $model->id == '2') {
            SysMessages::set(_("System role can not be deleted"), 'danger');
            SysRequest::redirect('/users/roles/');
        }

        if ($model->delete()) {
            SysMessages::set(_("Role has been deleted successfully"), 'success');
            SysRequest::redirect('/users/roles/');
        }
    }
}