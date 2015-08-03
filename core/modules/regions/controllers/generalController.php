<?php
namespace core\modules\regions\controllers;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\extensions\ExtBreadcrumbs;
use core\modules\regions\models\Regions;

class generalController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                _("regions") => '-',
            ],

            'create' => [
                _("regions") => '/regions/general/',
                _("create") => '-',
            ],

            'update' => [
                _("regions") => '/regions/general/',
                _("update") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = _("Regions");

        $view = new SysView();
        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = _("Create region");
        $model = new Regions();
        $model->setScript('create');

        $view = new SysView();
        $view->model = $model;

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];

            if ($model->save()) {
                SysMessages::set(_("Region has been created successfully"), 'success');
                SysRequest::redirect('/regions/general/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = _("Update region");

        $view = new SysView();
        $display = new SysDisplay();

        $id = SysRequest::get('id');
        $post = SysRequest::post();

        if (!empty($post)) {
            $model = Regions::findByPk($post['id']);
            if (empty($model)) {
                SysMessages::set(_("Region not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
            }
            $model->setScript('update');
            $model->name = $post['name'];

//            var_dump($model->isUniqueExceptRecord('name', $model->name));
//            return true;

            if ($model->save()) {
                SysMessages::set(_("Region has been updated successfully"), 'success');
                SysRequest::redirect('/regions/general/');
            } else {
                $view->item = $model;
                $view->display('update');
                return true;
            }
        }

        if (!empty($id)) {
            $model = Regions::findByPk($id);
            if (empty($model)) {
                SysMessages::set(_("Region not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $view->item = $model;
        } else {
            SysMessages::set(_("Region not found"), 'danger');
            $display->render('core/views/errors/404',false,true);
            return true;
        }


        $view->display('update');
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Regions::findByPk($id);
            if (empty($model)) {
                SysMessages::set(_("Region not found"), 'danger');
                SysRequest::redirect('/regions/general/');
            }

            $regionName = $model->name;

            if (false !== $model->delete()) {
                SysMessages::set(_("Region has been deleted successfully"), 'success');
            } else {
                SysMessages::set(_("Region can not be deleted"), 'danger');
            }
        }

        SysRequest::redirect('/regions/general/');
    }
}