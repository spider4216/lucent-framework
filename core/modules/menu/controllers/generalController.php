<?php
namespace core\modules\menu\controllers;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\extensions\ExtNestedset;
use core\modules\menu\models\Menu;

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

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];
            $model->machine_name = $post['machine_name'];
            $model->description = $post['description'];

            if ($model->save()) {
                SysMessages::set(_("Menu has been created successfully"), 'success');
                SysRequest::redirect('/menu/general/');
            }
        }

        $view->model = $model;
        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = _("Create menu");
        $display = new SysDisplay();
        $view = new SysView();

        if ($post = SysRequest::post()) {
            if (empty($post['id'])) {
                $display->render('core/views/errors/400',false,true);
                return false;
            }

            $model = Menu::findByPk($post['id']);

            if (empty($model)) {
                SysMessages::set(_("Menu does not exist"), 'danger');
                SysRequest::redirect('/menu/general/');
            }

            $model->setScript('update');

            $model->name = $post['name'];
            $model->description = $post['description'];


            if ($model->save()) {
                SysMessages::set(_("Menu has been updated successfully"), 'success');
                SysRequest::redirect('/menu/general/');
            }

            $view->model = $model;
            $view->display('update');
            return false;
        }

        if ($id = SysRequest::get('id')) {
            $model = Menu::findByPk($id);

            if (empty($model)) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return false;
            }

            $view->model = $model;
            $view->display('update');
            return false;
        }

        SysMessages::set(_("Page not found"), 'danger');
        $display->render('core/views/errors/404',false,true);
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = new Menu();
            $item = $model->findByPk($id);

            if ($item->delete()) {
                SysMessages::set(_("Menu has been deleted successfully"), 'success');
                SysRequest::redirect('/menu/general/');
            }

        } else {
            SysRequest::redirect('/menu/general/');
        }
    }

    public function actionManage()
    {
        static::$title = _("Manage menu");

        $view = new SysView();
        $display = new SysDisplay();

        if ($id = SysRequest::get('id')) {
            $model = Menu::findByPk($id);

            if (empty($model)) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return false;
            }

            $nestedSet = new ExtNestedset($model->machine_name);

            $data = $nestedSet->findAllNodes();

            $view->nodes = $data;
            $view->id = $id;
            $view->display('manage');
            return false;
        }

        SysMessages::set(_("Page not found"), 'danger');
        $display->render('core/views/errors/404',false,true);
    }

    public function actionAdditem()
    {
        static::$title = _("Add item");

        $view = new SysView();
        $display = new SysDisplay();

        if ($post = SysRequest::post()) {

            $model = Menu::findByPk($post['id']);

            if (empty($model)) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return false;
            }

            $nestedSet = new ExtNestedset($model->machine_name);

            if (empty($post['value']) || empty ($post['link'])) {
                $options = $nestedSet->findAllNodes();

                SysMessages::set(_("Name and link cannot be empty"), 'danger');
                $view->model = $model;
                $view->options = $options;
                $view->display('additem');
                return false;
            }

            if ($post['items'] == '-1') {
                //todo check tru false
                $nestedSet->createRoot($post['value'], ['link' => $post['link']]);

                SysMessages::set(_("Menu item has been created successfully"), 'success');
                SysRequest::redirect('/menu/general/manage?id=' . $post['id']);
                //SysRequest::redirect('/menu/general/');
            }

            //todo check true false
            $nestedSet->appendChild($post['items'], $post['value'], ['link' => $post['link']]);
            SysMessages::set(_("Menu item has been created successfully"), 'success');

            SysRequest::redirect('/menu/general/manage?id=' . $post['id']);

        }

        if ($id = SysRequest::get('id')) {
            $model = Menu::findByPk($id);

            if (empty($model)) {
                SysMessages::set(_("Page not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return false;
            }

            $nestedSet = new ExtNestedset($model->machine_name);
            $options = $nestedSet->findAllNodes();


            $view->model = $model;
            $view->options = $options;
            $view->display('additem');
            return false;
        }

        SysMessages::set(_("Page not found"), 'danger');
        $display->render('core/views/errors/404',false,true);
    }

    public function actionDeleteitem()
    {
        if ($id = SysRequest::get('id')) {

            $menuId = SysRequest::get('menu_id');

            $model = Menu::findByPk($menuId);

            if (empty($model)) {
                SysMessages::set(_("Menu is not correct"), 'danger');
                SysRequest::redirect('/menu/general/');
            }

            $nestedSet = new ExtNestedset($model->machine_name);

            //todo check true false
            $nestedSet->deleteNode($id);

            SysMessages::set(_("Menu item has been deleted successfully"), 'success');
            SysRequest::redirect('/menu/general/manage?id=' . $menuId);

        } else {
            SysRequest::redirect('/menu/general/');
        }
    }

    public function actionDemo()
    {
        //$nestedSet = new ExtNestedset('menu_main_menu');

        //$nestedSet->createRoot('cars');
        //$nestedSet->appendChild('mercedes', 'auto');

        //$nestedSet->deleteNode('mercedes');
    }
}