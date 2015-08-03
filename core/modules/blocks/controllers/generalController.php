<?php

namespace core\modules\blocks\controllers;

use core\classes\SysController;
use core\classes\SysDisplay;
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
        $tt = [];
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

        //var_dump($template);
        $view->template = $template;
        //--

        $view->blocks = $blocks;
        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = _("Create block");

        $view = new SysView();
        $model = new Blocks();
        $regions = Regions::findAll();

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];
            $model->content = $post['content'];
            $model->weight = $post['weight'];

            if ('none' != $post['region_id']) {
                $model->region_id = $post['region_id'];
            }

            if ($model->save()) {
                SysMessages::set(_("Block has been created successfully"), 'success');
                SysRequest::redirect('/blocks/general/');
            }
        }

        $view->model = $model;
        $view->regions = $regions;
        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = _("Update block");

        $view = new SysView();
        $display = new SysDisplay();
        $regions = Regions::findAll();

        if ($post = SysRequest::post()) {
            $model = Blocks::findByPk($post['id']);

            if (empty($model)) {
                SysMessages::set(_("Block not found"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $model->name = $post['name'];
            $model->content = $post['content'];
            $model->region_id = $post['region_id'];
            $model->weight = $post['weight'];

            if ($model->save()) {
                SysMessages::set(_("Block has been updated successfully"), 'success');
                SysRequest::redirect('/blocks/general/');
            } else {
                $view->model = $model;
                $view->regions = $regions;
                $view->regionSelected = $model->region_id;

                $view->display('update');
                return true;
            }
        }


        if ($id = SysRequest::get('id')) {
            $model = Blocks::findByPk($id);

            if (empty($model)) {
                SysMessages::set(_("Block not fount"), 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $view->model = $model;
            $view->regions = $regions;
            $view->regionSelected = $model->region_id;

            $view->display('update');
        } else {
            SysMessages::set(_("Block not found"), 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Blocks::findByPk($id);
            if (empty($model)) {
                SysMessages::set(_("Block not found"), 'danger');
                SysRequest::redirect('/blocks/general/');
            }

            $blockName = $model->name;

            if (false !== $model->delete()) {
                SysMessages::set(_("Block has been deleted successfully"), 'success');
            } else {
                SysMessages::set(_("Block can not be deleted"), 'danger');
            }
        }

        SysRequest::redirect('/blocks/general/');
    }
}