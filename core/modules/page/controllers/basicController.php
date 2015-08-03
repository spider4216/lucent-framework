<?php
namespace core\modules\page\controllers;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysView;
use core\modules\page\models\Page;
use core\classes\SysRequest;
use core\classes\SysMessages;
use core\extensions\ExtBreadcrumbs;

class basicController extends SysController{

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
                _("pages") => '-',
            ],

            'create' => [
                _("pages") => '/page/basic/',
                _("create page") => '-',
            ],

            'update' => [
                _("pages") => '/page/basic/',
                _("edit page") => '-',
            ],

            'view' => [
                _("pages") => '/page/basic/',
                '%' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = ("Pages");

        $model = new Page();

        $view = new SysView();
        $view->model = $model;

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = _("Create page");

        $view = new SysView();
        $model = new Page();
        $view->model = $model;

        if ($post = SysRequest::post()) {
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                SysMessages::set(_("Page has been created successfully"), 'success');
                SysRequest::redirect('/page/basic/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = _("Edit page");

        $view = new SysView();
        $display = new SysDisplay();

        if ($post = SysRequest::post()) {
            $model = Page::findByPk($post['id']);

            if (empty($model)) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $model->title = $post['title'];
            $model->content = $post['content'];

            $view->model = $model;

            if ($model->save()) {
                SysMessages::set(_("Page has been updated successfully"), 'success');
                SysRequest::redirect('/page/basic/');
            }

            $view->display('update');
            return true;
        }

        if ($id = SysRequest::get('id')) {
            $model = Page::findByPk($id);

            if (empty($model)) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->model = $model;
            $view->display('update');
            return true;
        }

        SysMessages::set(_("Page not found"), 'danger');
        $display->render('core/views/errors/404',false,true);

    }

    public function actionView()
    {
        $display = new SysDisplay();
        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'view');

        if ($id = SysRequest::get('id')) {
            $model = new Page();
            $view = new SysView();
            $view->breadcrumbs = $breadcrumbs;

            $view->model = $model;
            $item = $model->findByPk($id);

            if (!empty($item)) {
                static::$title = $item->title;
            }

            if (!$item) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->item = $item;

            $view->display('view');
        } else {
            SysMessages::set(_("Page not found"), 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = new Page();
            $item = $model->findByPk($id);

            if ($item->delete()) {
                SysMessages::set(_("Page has been deleted successfully"), 'success');
                SysRequest::redirect('/page/basic/');
            }

        } else {
            SysRequest::redirect('/page/basic/');
        }
    }
}