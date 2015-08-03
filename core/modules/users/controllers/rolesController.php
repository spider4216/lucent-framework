<?php
namespace core\modules\users\controllers;

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

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];

            if ($model->save()) {
                SysMessages::set(_("Role has been created successfully"), 'success');
                SysRequest::redirect('/users/roles/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = _("Edit role");

        $view = new SysView();
        $display = new SysDisplay();

        if($post = SysRequest::post()) {
            $model = Roles::findByPk($post['id']);

            if (empty($model)) {
                SysMessages::set(_("Role not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $model->name = $post['name'];

            if ($model->save()) {
                SysMessages::set(_("Role has been updated successfully"), 'success');
                SysRequest::redirect('/users/roles/');
            } else {
                $model = Roles::findByPk($post['id']);
                $view->model = $model;
                $view->display('update');
            }
        }

        if ($id = SysRequest::get('id')) {
            $model = Roles::findByPk($id);

            if (empty($model)) {
                SysMessages::set(_("Role not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $view->model = $model;
            $view->display('update');
        } else {
            SysMessages::set(_("Role not found"), 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Roles::findByPk($id);

            if ($model->id == '1' || $model->id == '2') {
                SysMessages::set(_("System role can not be deleted"), 'danger');
                SysRequest::redirect('/users/roles/');
            }

            if ($model->delete()) {
                SysMessages::set(_("Role has been deleted successfully"), 'success');
                SysRequest::redirect('/users/roles/');
            }
        } else {
            SysMessages::set(_("Role can not be deleted"), 'danger');
            SysRequest::redirect('/users/roles/');
        }
    }
}