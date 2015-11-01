<?php
namespace core\modules\menu\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\extensions\ExtNestedset;
use core\modules\menu\models\Menu;
use core\modules\regions\models\Regions;

class generalController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
            'create' => ['user', '-'],
            'update' => ['user', '-'],
            'manage' => ['user', '-'],
            'additem' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                SysLocale::t("menu") => '-',
            ],

            'create' => [
                SysLocale::t("menu") => '/menu/general/',
                SysLocale::t("create menu") => '-',
            ],

            'update' => [
                SysLocale::t("menu") => '/menu/general/',
                SysLocale::t("update menu") => '-',
            ],

            'manage' => [
                SysLocale::t("menu") => '/menu/general/',
                SysLocale::t("manage menu") => '-',
            ],

            'additem' => [
                SysLocale::t("menu") => '/menu/general/',
                SysLocale::t("manage menu") => '-',
                SysLocale::t("add link") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("Menu");

        $view = new SysView();

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = SysLocale::t("Create menu");

        $model = new Menu();
        $model->setScript('create');
        $view = new SysView();
		$regions = Regions::findAll();

        $view->model = $model;
        $view->regions = $regions;
        $view->display('create');
    }

    public function actionAjaxCreate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403(SysLocale::t("Forbidden"));
        }

        $post = $_POST;
        $model = new Menu();
        $model->setScript('create');
        $model->load($post);

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Menu \"{:name}\" has been created successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionUpdate()
    {
        static::$title = SysLocale::t("Create menu");
        $view = new SysView();

        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }


        $model = Menu::findByPk($id);
		$regions = Regions::findAll();

        if (empty($model)) {
            throw new E404;
        }

        $view->model = $model;
        $view->regions = $regions;
		$view->regionSelected = $model->region_id;
        $view->display('update');
    }

    public function actionAjaxUpdate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403();
        }

        $post = $_POST;
        $id = $post['id'];

        if (empty($id)) {
            throw new E404();
        }

        $model = Menu::findByPk($id);

        if (empty($model)) {
            throw new E404();
        }

        $model->setScript('update');
        $model->load($post);


        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Menu \"{:name}\" has been updated successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionDelete()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = new Menu();
        $item = $model->findByPk($id);

        if (empty($item)) {
            throw new E404;
        }

        $name = $item->name;

        if (!$item->delete()) {
            SysMessages::set(SysLocale::t("Menu wit id \"{:id}\" cannot be deleted for some reasons", [
                '{:id}' => $id,
            ]), 'danger');
            SysRequest::redirect('/menu/general/');
        }

        SysMessages::set(SysLocale::t("Menu \"{:name}\" has been deleted successfully", [
            '{:name}' => $name,
        ]), 'success');
        SysRequest::redirect('/menu/general/');
    }

    public function actionManage()
    {
        static::$title = SysLocale::t("Manage menu");

        $view = new SysView();
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Menu::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        $nestedSet = new ExtNestedset($model->machine_name);

        $data = $nestedSet->findAllNodes();

        $view->nodes = $data;
        $view->id = $id;
        $view->display('manage');
    }

    public function actionAdditem()
    {
        static::$title = SysLocale::t("Add item");

        $view = new SysView();
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Menu::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        $nestedSet = new ExtNestedset($model->machine_name);
        $options = $nestedSet->findAllNodes();


        $view->model = $model;
        $view->options = $options;
        $view->display('additem');
    }

    public function actionAjaxAddItem()
    {
        if (!SysAjax::isAjax()) {
            throw new E403();
        }

        $post = $_POST;
        $id = $post['id'];

        $model = Menu::findByPk($id);

        if (empty($model)) {
            SysAjax::json_err(SysLocale::t("Bad Request"));
        }

        $nestedSet = new ExtNestedset($model->machine_name);

        if (empty($post['value']) || empty ($post['link'])) {
            SysAjax::json_err(SysLocale::t("Name and link cannot be empty"));
        }

        if ($post['items'] == '-1') {
            //todo check true false
            $nestedSet->createRoot($post['value'], ['link' => $post['link']]);
            SysAjax::json_ok(SysLocale::t("Menu item has been created successfully"));
        }

        //todo check true false
        $nestedSet->appendChild($post['items'], $post['value'], ['link' => $post['link']]);
        SysAjax::json_ok(SysLocale::t("Menu item has been created successfully"));
    }

    public function actionDeleteitem()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $menuId = SysRequest::get('menu_id');

        $model = Menu::findByPk($menuId);

        if (empty($model)) {
            throw new E404;
        }

        $nestedSet = new ExtNestedset($model->machine_name);

        if (!$nestedSet->deleteNode($id)) {
            SysMessages::set(SysLocale::t("Menu item cannot be deleted"), 'danger');
        } else {
            SysMessages::set(SysLocale::t("Menu item has been deleted successfully"), 'success');
        }

        SysRequest::redirect('/menu/general/manage?id=' . $menuId);
    }
}