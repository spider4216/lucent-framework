<?php
namespace core\modules\regions\controllers;

use core\classes\exception\E400;
use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\modules\blocks\models\Blocks;
use core\modules\menu\models\Menu;
use core\modules\page\models\PageCollections;
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
                SysLocale::t("regions") => '-',
            ],

            'create' => [
                SysLocale::t("regions") => '/regions/general/',
                SysLocale::t("create") => '-',
            ],

            'update' => [
                SysLocale::t("regions") => '/regions/general/',
                SysLocale::t("update") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("Regions");

        $view = new SysView();
        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = SysLocale::t("Create region");
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

        SysAjax::json_ok(SysLocale::t("Region \"{:name}\" has been created successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionUpdate()
    {
        static::$title = SysLocale::t("Update region");

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

        SysAjax::json_ok(SysLocale::t("Region \"{:name}\" has been updated successfully", [
            '{:name}' => $post['name'],
        ]));
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

        $name = $model->name;

        if ($model->delete()) {
            SysMessages::set(SysLocale::t("Region \"{:name}\" has been deleted successfully", [
                '{:name}' => $name,
            ]), 'success');
        } else {
            SysMessages::set(SysLocale::t("Region \"{:name}\" can not be deleted", [
                '{:name}' => $name,
            ]), 'danger');
        }

        SysRequest::redirect('/regions/general/');
    }

    public function actionAjaxBlockSort()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $model = null;

        foreach ($_POST as $data) {
            switch ($data['type']) {
                case 'menu_block' :
                    $model = new Menu();
                    break;
                case 'content_block' :
                    $model = new Blocks();
                    break;
                case 'collection_block' :
                    $model = new PageCollections();
                    break;
            }

            $d = $model->findByPk($data['id']);
            $d->weight = $data['weight'];

            if (!$d->save()) {
                throw new \Exception(SysLocale::t('save error in ajax'));
            }
        }

        SysAjax::json_ok(SysLocale::t('Blocks was successfully sorted'));
    }
}