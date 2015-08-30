<?php

namespace core\modules\blocks\controllers;

use core\classes\exception\E400;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\modules\blocks\models\Blocks;
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
                _("blocks") => '-',
            ],

            'create' => [
                _("blocks") => '/blocks/general/',
                _("create block") => '-',
            ],

            'update' => [
                _("blocks") => '/blocks/general/',
                _("update block") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = _("Blocks");
        $view = new SysView();
        $blocks = Blocks::findAll();

        //--
        $template = [];

        $regions = Regions::findAll();
        $i = 0;

        foreach ($regions as $region) {
            $template[$i]['regionName'] = $region->name;

            $blocksRegion = Blocks::findAll(['region_id = :r_id',
                [':r_id' => $region->id]], [], ['weight' => 'ASC']);

            if (empty($blocksRegion)) {
                continue;
            }

            foreach ($blocksRegion as $block) {
                $template[$i]['blocks'][] = $block->name;
            }

            $i++;
        }

        $view->template = $template;

        $view->blocks = $blocks;
        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = _("Create block");

        $view = new SysView();
        $model = new Blocks();
        $regions = Regions::findAll();

        $view->model = $model;
        $view->regions = $regions;
        $view->display('create');
    }

    public function actionAjaxCreate()
    {
        if (!SysAjax::isAjax()) {
            throw new E400(_("Bad Request"));
        }

        $post = $_POST;

        $model = new Blocks();
        $model->name = $post['name'];
        $model->content = $post['content'];
        $model->weight = $post['weight'];

        if ('none' != $post['region_id']) {
            $model->region_id = $post['region_id'];
        }

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Block has been created successfully"));
    }

    public function actionUpdate()
    {
        static::$title = _("Update block");

        $view = new SysView();
        $regions = Regions::findAll();

        $id = SysRequest::get('id');

        if (empty($id)) {
            throw new E404(_("Block not found"));
        }

        $model = Blocks::findByPk($id);

        if (empty($model)) {
            throw new E404(_("Block not fount"));
        }

        $view->model = $model;
        $view->regions = $regions;
        $view->regionSelected = $model->region_id;

        $view->display('update');


    }

    public function actionAjaxUpdate()
    {
        $post = $_POST;

        $model = Blocks::findByPk($post['id']);

        if (empty($model)) {
            throw new E404(_("Block not found"));
        }

        $model->name = $post['name'];
        $model->content = $post['content'];
        $model->region_id = $post['region_id'];
        $model->weight = $post['weight'];

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Block has been updated successfully"));
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Blocks::findByPk($id);
            if (empty($model)) {
                SysMessages::set(_("Block not found"), 'danger');
                SysRequest::redirect('/blocks/general/');
            }

            if (false !== $model->delete()) {
                SysMessages::set(_("Block has been deleted successfully"), 'success');
            } else {
                SysMessages::set(_("Block can not be deleted"), 'danger');
            }
        }

        SysRequest::redirect('/blocks/general/');
    }
}