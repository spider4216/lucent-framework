<?php
namespace core\modules\menu\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
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
                _("menu") => '-',
            ],

            'create' => [
                _("menu") => '/menu/general/',
                _("create menu") => '-',
            ],

            'update' => [
                _("menu") => '/menu/general/',
                _("update menu") => '-',
            ],

            'manage' => [
                _("menu") => '/menu/general/',
                _("manage menu") => '-',
            ],

            'additem' => [
                _("menu") => '/menu/general/',
                _("manage menu") => '-',
                _("add link") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = _("Menu");

        $view = new SysView();

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = _("Create menu");

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
            throw new E403(_("Forbidden"));
        }

        $post = $_POST;
        $model = new Menu();
        $model->setScript('create');

        $model->name = $post['name'];
        $model->machine_name = $post['machine_name'];
        $model->description = $post['description'];
        $model->weight = $post['weight'];
        $model->region_id = $post['region_id'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Menu has been created successfully"));
    }

    public function actionUpdate()
    {
        static::$title = _("Create menu");
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

        $model->name = $post['name'];
        $model->description = $post['description'];
        $model->weight = $post['weight'];
        $model->region_id = $post['region_id'];


        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Menu has been updated successfully"));
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

        if (!$item->delete()) {
            SysMessages::set(_("Menu cannot be deleted for some reasons"), 'danger');
            SysRequest::redirect('/menu/general/');
        }

        SysMessages::set(_("Menu has been deleted successfully"), 'success');
        SysRequest::redirect('/menu/general/');
    }

    public function actionManage()
    {
        static::$title = _("Manage menu");

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
        static::$title = _("Add item");

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
            SysAjax::json_err(_("Bad Request"));
        }

        $nestedSet = new ExtNestedset($model->machine_name);

        if (empty($post['value']) || empty ($post['link'])) {
            SysAjax::json_err(_("Name and link cannot be empty"));
        }

        if ($post['items'] == '-1') {
            //todo check true false
            $nestedSet->createRoot($post['value'], ['link' => $post['link']]);
            SysAjax::json_ok(_("Menu item has been created successfully"));
        }

        //todo check true false
        $nestedSet->appendChild($post['items'], $post['value'], ['link' => $post['link']]);
        SysAjax::json_ok(_("Menu item has been created successfully"));
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
            SysMessages::set(_("Menu item cannot be deleted"), 'danger');
        } else {
            SysMessages::set(_("Menu item has been deleted successfully"), 'success');
        }

        SysRequest::redirect('/menu/general/manage?id=' . $menuId);
    }
}