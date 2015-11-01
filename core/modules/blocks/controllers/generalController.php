<?php

namespace core\modules\blocks\controllers;

use core\classes\exception\E400;
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
                SysLocale::t("blocks") => '-',
            ],

            'create' => [
                SysLocale::t("blocks") => '/blocks/general/',
                SysLocale::t("create block") => '-',
            ],

            'update' => [
                SysLocale::t("blocks") => '/blocks/general/',
                SysLocale::t("update block") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("Blocks");
        $view = new SysView();
        $blocks = Blocks::findAll();
		$menu = Menu::findAll();
		$collections = PageCollections::findAll();

        //--
        $template = [];

        $regions = Regions::findAll();
        $i = 0;

        foreach ($regions as $region) {
            $template[$i]['regionName'] = $region->name;

            $blocksRegion = Blocks::findAll(['region_id = :r_id',
                [':r_id' => $region->id]], [], ['weight' => 'ASC']);

            foreach ($blocksRegion as $block) {
                $template[$i]['blocks'][] = $block->name;
            }

            $menuRegion = Menu::findAll(['region_id = :r_id',
                [':r_id' => $region->id]], [], ['weight' => 'ASC']);

            foreach ($menuRegion as $m) {
                $template[$i]['blocks'][] = $m->name;
            }

			$collectionRegion = PageCollections::findAll(['region_id = :r_id',
				[':r_id' => $region->id]]);

			foreach ($collectionRegion as $collection) {
				$template[$i]['blocks'][] = $collection->name;
			}

            $i++;
        }

        $view->template = $template;

        $view->blocks = $blocks;
        $view->menu = $menu;
        $view->collections = $collections;
        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = SysLocale::t("Create block");

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
            throw new E400(SysLocale::t("Bad Request"));
        }

        $post = $_POST;

        $model = new Blocks();
        $model->load($post);

        if ('none' != $post['region_id']) {
            $model->region_id = $post['region_id'];
        }

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Block \"{:name}\" has been created successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionUpdate()
    {
        static::$title = SysLocale::t("Update block");

        $view = new SysView();
        $regions = Regions::findAll();

        $id = (int)SysRequest::get('id');

        if (empty($id)) {
            throw new E404(SysLocale::t("Block with id \"{:id}\" not found", [
                '{:id)' => $id,
            ]));
        }

        $model = Blocks::findByPk($id);

        if (empty($model)) {
            throw new E404(SysLocale::t("Block with id \"{:id}\" not found", [
                '{:id)' => $id,
            ]));
        }

        $view->model = $model;
        $view->regions = $regions;
        $view->regionSelected = $model->region_id;
        $view->machine_name = $model->machine_name;

        $view->display('update');
    }

    public function actionAjaxUpdate()
    {
        $post = $_POST;

        $model = Blocks::findByPk((int)$post['id']);

        if (empty($model)) {
            throw new E404(SysLocale::t("Block with id \"{:id}\" not found", [
                '{:id}' => $post['id'],
            ]));
        }

        $model->load($post);

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Block \"{:name}\" has been updated successfully", [
            '{:name}' => $post['name'],
        ]));
    }

    public function actionDelete()
    {
        if ($id = (int)SysRequest::get('id')) {
            $model = Blocks::findByPk($id);

            if (empty($model)) {
                SysMessages::set(SysLocale::t("Block with id \"{:id}\" not found", [
                    '{:id}' => $id,
                ]), 'danger');
                SysRequest::redirect('/blocks/general/');
            }

            if (false !== $model->delete()) {
                SysMessages::set(SysLocale::t("Block \"{:name}\" has been deleted successfully", [
                    '{:name}' => $model->name,
                ]), 'success');
            } else {
                SysMessages::set(SysLocale::t("Block \"{:name}\" can not be deleted", [
                    '{:name}' => $model->name,
                ]), 'danger');
            }
        }

        SysRequest::redirect('/blocks/general/');
    }
}