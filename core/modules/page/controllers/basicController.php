<?php
namespace core\modules\page\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysView;
use core\modules\page\models\Page;
use core\classes\SysRequest;
use core\classes\SysMessages;
use core\extensions\ExtBreadcrumbs;
use core\modules\page\models\PageType;

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
                SysLocale::t("pages") => '-',
            ],

            'create' => [
                SysLocale::t("pages") => '/page/basic/',
                SysLocale::t("create page") => '-',
            ],

            'update' => [
                SysLocale::t("pages") => '/page/basic/',
                SysLocale::t("edit page") => '-',
            ],

            'view' => [
                SysLocale::t("pages") => '/page/basic/',
                '%' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("Pages");

        $model = new Page();

        $view = new SysView();
        $view->model = $model;

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = SysLocale::t("Create page");

        $view = new SysView();
        $model = new Page();
		$pageTypes = PageType::findAll();

        $view->model = $model;
        $view->pageTypes = $pageTypes;

        $view->display('create');
    }

    public function actionAjaxCreate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = new Page();

        $model->load($post);

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Page \"{:title}\" has been created successfully", ['{:title}' => $post['title']]));
    }

    public function actionUpdate()
    {
        static::$title = SysLocale::t("Edit page");

        $view = new SysView();
        $id = (int)SysRequest::get('id');
		$pageTypes = PageType::findAll();

        if (empty($id)) {
            throw new E404;
        }

        $model = Page::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        $view->model = $model;
		$view->pageTypes = $pageTypes;

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

        $model->load($post);

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Page \"{:title}\" has been updated successfully", [
            '{:title}' => $post['title'],
        ]));
    }

    public function actionView()
    {
        $id = (int)SysRequest::get('id');

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
        $id = (int)SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = new Page();
        $item = $model->findByPk($id);

        if (empty($item)) {
            throw new E404;
        }

        $title = $item->title;

        if (!$item->delete()) {
            SysMessages::set(SysLocale::t("Page \"{:title}\" cannot be deleted", [
                '{:title}' => $title,
            ]), 'danger');
            SysRequest::redirect('/page/basic/');
        }

        SysMessages::set(SysLocale::t("Page \"{:title}\" has been deleted successfully", [
            '{:title}' => $title,
        ]), 'success');
        SysRequest::redirect('/page/basic/');
    }
}