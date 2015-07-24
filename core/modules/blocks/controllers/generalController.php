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
                'Блоки' => '-',
            ],

            'create' => [
                'Блоки' => '/blocks/general/',
                'Создать блок' => '-',
            ],

            'update' => [
                'Блоки' => '/blocks/general/',
                'Обновить блок' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = 'Блоки';
        $view = new SysView();
        $blocks = Blocks::findAll();

        //--
        $template = [];

        $regions = Regions::findAll();
        $i = 0;
        $tt = [];
        foreach ($regions as $region) {
            $template[$i]['regionName'] = $region->name;

            $blocksRegion = Blocks::findAll(['region_id = :r_id', [':r_id' => $region->id]]);

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
        static::$title = 'Создать блок';

        $view = new SysView();
        $model = new Blocks();
        $regions = Regions::findAll();

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];
            $model->content = $post['content'];

            if ('none' != $post['region_id']) {
                $model->region_id = $post['region_id'];
            }

            if ($model->save()) {
                SysMessages::set('Блок "'. $model->name .'" был успешно создан', 'success');
                SysRequest::redirect('/blocks/general/');
            }
        }

        $view->model = $model;
        $view->regions = $regions;
        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = 'Обновить блок';

        $view = new SysView();
        $display = new SysDisplay();
        $regions = Regions::findAll();

        if ($post = SysRequest::post()) {
            $model = Blocks::findByPk($post['id']);

            if (empty($model)) {
                SysMessages::set('Блок c id "'. $post['id'] .'" не найден', 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $model->name = $post['name'];
            $model->content = $post['content'];
            $model->region_id = $post['region_id'];

            if ($model->save()) {
                SysMessages::set('Блок "'. $model->name .'" был успешно обновлен', 'success');
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
                SysMessages::set('Блок c id "'. $id .'" не найден', 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $view->model = $model;
            $view->regions = $regions;
            $view->regionSelected = $model->region_id;

            $view->display('update');
        } else {
            SysMessages::set('Блок не найден', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Blocks::findByPk($id);
            if (empty($model)) {
                SysMessages::set('Блок не найден', 'danger');
                SysRequest::redirect('/blocks/general/');
            }

            $blockName = $model->name;

            if (false !== $model->delete()) {
                SysMessages::set('Блок "'. $blockName .'" был успешно удален', 'success');
            } else {
                SysMessages::set('Блок "'. $blockName .'" не был удален', 'danger');
            }
        }

        SysRequest::redirect('/blocks/general/');
    }
}