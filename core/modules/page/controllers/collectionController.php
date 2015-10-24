<?php
namespace core\modules\page\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\modules\page\models\PageCollections;
use core\modules\page\models\PageType;
use core\modules\regions\models\Regions;

class collectionController extends SysController
{
	public static function permission()
	{
		// "-" - неавторизованный пользователь
		return [
			'index' => ['user', '-'],
			'create' => ['user', '-'],
			'update' => ['user', '-'],
		];
	}

	public function breadcrumbs()
	{
		//% - замещение. Например Хочу передать виджету никий заголовок для принта
		return [
			'index' => [
				SysLocale::t("pages") => '/page/basic/',
				SysLocale::t("collections") => '-',
			],

			'create' => [
				SysLocale::t("pages") => '/page/basic/',
				SysLocale::t("collections") => '/page/collection/',
				SysLocale::t("create collection") => '-',
			],

			'update' => [
				SysLocale::t("pages") => '/page/basic/',
				SysLocale::t("collections") => '/page/collection/',
				SysLocale::t("update collection") => '-',
			],

		];
	}

	public function actionIndex()
	{
		static::$title = SysLocale::t("Page collections");

		$view = new SysView();
		$view->display('index');
	}

	public function actionCreate()
	{
		static::$title = SysLocale::t("Create collections");

		$model = new PageCollections();
		$regions = Regions::findAll();
		$pageType = PageType::findAll();

		$view = new SysView();
		$view->regions = $regions;
		$view->pageTypes = $pageType;
		$view->model = $model;

		$view->display('create');
	}

	public function actionAjaxCreate()
	{
		if (!SysAjax::isAjax()) {
			throw new E403;
		}

		$post = SysRequest::post();
		$model = new PageCollections();

		$model->name = $post['name'];
		$model->description = $post['description'];
		$model->page_type_id = $post['page_type_id'];
		$model->pagination = $post['pagination'];
		$model->region_id = $post['region_id'];
		$model->links = $post['links'];
		$model->weight = $post['weight'];

		if (!$model->save()) {
			SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
		}

		SysAjax::json_ok(SysLocale::t("Collection \"{:title}\" has been created successfully", [
			'{:title}' => $post['name'],
		]));
	}

	public function actionUpdate()
	{
		static::$title = SysLocale::t("Update collection");

		$id = SysRequest::get('id');

		if (empty($id)) {
			throw new E404;
		}

		$model = PageCollections::findByPk($id);

		if (empty($model)) {
			throw new E404;
		}

		$regions = Regions::findAll();
		$pageType = PageType::findAll();


		$view = new SysView();
		$view->regions = $regions;
		$view->pageTypes = $pageType;
		$view->model = $model;

		$view->display('update');
	}

	public function actionAjaxUpdate()
	{
		if (!SysAjax::isAjax()) {
			throw new E403;
		}

		$post = SysRequest::post();

		$model = PageCollections::findByPk((int)$post['id']);

		if (empty($model)) {
			SysAjax::json_err(SysLocale::t("Bad Request"));
		}

		$model->name = $post['name'];
		$model->description = $post['description'];
		$model->page_type_id = $post['page_type_id'];
		$model->pagination = $post['pagination'];
		$model->region_id = $post['region_id'];
		$model->links = $post['links'];
		$model->weight = $post['weight'];

		if (!$model->save()) {
			SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
		}

		SysAjax::json_ok(SysLocale::t("Collection \"{:title}\" has been updated successfully", [
			'{:title}' => $post['name'],
		]));
	}

	public function actionDelete()
	{
		$id = SysRequest::get('id');

		if (empty($id)) {
			throw new E404;
		}

		$item = PageCollections::findByPk($id);

		if (empty($item)) {
			throw new E404;
		}

		$name = $item->name;

		if (!$item->delete()) {
			SysMessages::set(SysLocale::t("Collection \"{:title}\" cannot be deleted", [
				'{:title}' => $name,
				]), 'danger');
			SysRequest::redirect('/page/collection/');
		}

		SysMessages::set(SysLocale::t("Collection \"{:title}\" has been deleted successfully", [
			'{:title}' => $name,
		]), 'success');
		SysRequest::redirect('/page/collection/');
	}
}