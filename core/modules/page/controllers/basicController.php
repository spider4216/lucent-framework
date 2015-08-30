<?php
namespace core\modules\page\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
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

        $view->display('create');
    }

    public function actionAjaxCreate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = new Page();

        $model->title = $post['title'];
        $model->content = $post['content'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Page has been created successfully"));
    }

    public function actionUpdate()
    {
        static::$title = _("Edit page");

        $view = new SysView();
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Page::findByPk($id);

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

        $model = Page::findByPk((int)$post['id']);

        if (empty($model)) {
            SysAjax::json_err(_("Bad Request"));
        }

        $model->title = $post['title'];
        $model->content = $post['content'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Page has been updated successfully"));
    }

    public function actionView()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'view');
        $model = new Page();
        $view = new SysView();

        $view->model = $model;
        $item = $model->findByPk($id);

        if (empty($item)) {
            throw new E404;
        }

        static::$title = $item->title;

        $view->item = $item;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('view');
    }

    public function actionDelete()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = new Page();
        $item = $model->findByPk($id);

        if (empty($item)) {
            throw new E404;
        }

        if (!$item->delete()) {
            SysMessages::set(_("Page cannot be deleted"), 'danger');
            SysRequest::redirect('/page/basic/');
        }

        SysMessages::set(_("Page has been deleted successfully"), 'success');
        SysRequest::redirect('/page/basic/');
    }
}