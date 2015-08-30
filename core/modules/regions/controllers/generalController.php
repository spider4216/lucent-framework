<?php
namespace core\modules\regions\controllers;

use core\classes\exception\E400;
use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
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

        $view->display('create');
    }

    public function actionAjaxCreate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();
        $model = new Regions();
        $model->setScript('create');

            $model->name = $post['name'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Region has been created successfully"));
    }

    public function actionUpdate()
    {
        static::$title = _("Update region");

        $view = new SysView();
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Regions::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        $view->item = $model;
        $view->display('update');
    }

    public function actionAjaxUpdate()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = $_POST;

        $model = Regions::findByPk((int)$post['id']);

        if (empty($model)) {
            throw new E400;
        }

        $model->setScript('update');
        $model->name = $post['name'];


        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Region has been updated successfully"));
    }

    public function actionDelete()
    {
        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404;
        }

        $model = Regions::findByPk($id);

        if (empty($model)) {
            throw new E404;
        }

        if ($model->delete()) {
            SysMessages::set(_("Region has been deleted successfully"), 'success');
        } else {
            SysMessages::set(_("Region can not be deleted"), 'danger');
        }

        SysRequest::redirect('/regions/general/');
    }
}