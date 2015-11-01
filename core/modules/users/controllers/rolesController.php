<?php
namespace core\modules\users\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysView;
use core\classes\SysRequest;
use core\modules\users\models\Roles;
use core\classes\SysDisplay;

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
                SysLocale::t("users") => '/users/control/',
                _("manage roles") => '-',
            ],

            'create' => [
                SysLocale::t("users") => '/users/control/',
                SysLocale::t("manage roles") => '/users/roles/',
                SysLocale::t("create role") => '-',
            ],

            'update' => [
                SysLocale::t("users") => '/users/control/',
                SysLocale::t("manage roles") => '/users/roles/',
                SysLocale::t("edit role") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("Manage roles");

        $model = new Roles();
        $view = new SysView();

        $view->model = $model;

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = SysLocale::t("Create role");

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

        SysAjax::json_ok(SysLocale::t("Role \"{:name}\" has been created successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionUpdate()
    {
        static::$title = SysLocale::t("Edit role");

        $view = new SysView();
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
            SysAjax::json_err(SysLocale::t("Role with id \"{:id}\" not found", [
                '{:id}' => $post['id'],
            ]));
        }

        $model->name = $post['name'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Role \"{:name}\" has been updated successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionDelete()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Roles::findByPk($id);

        if (empty($model)) {
            SysAjax::json_err(SysLocale::t("Role with id \"{:id}\" cannot be found", [
                '{:id}' => $id,
            ]));
        }

        $name = $model->name;

        if ($model->id == '1' || $model->id == '2') {
            SysMessages::set(SysLocale::t("System role can not be deleted"), 'danger');
            SysRequest::redirect('/users/roles/');
        }

        if ($model->delete()) {
            SysMessages::set(SysLocale::t("Role \"{:name}\" has been deleted successfully", [
                '{:name}' => $name,
            ]), 'success');

            SysRequest::redirect('/users/roles/');
        }
    }
}