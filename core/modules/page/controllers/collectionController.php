<?php
namespace core\modules\page\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
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
				_("pages") => '/page/basic/',
				_("collections") => '-',
			],

			'create' => [
				_("pages") => '/page/basic/',
				_("collections") => '/page/collection/',
				_("create collection") => '-',
			],

			'update' => [
				_("pages") => '/page/basic/',
				_("collections") => '/page/collection/',
				_("update collection") => '-',
			],

		];
	}

	public function actionIndex()
	{
		static::$title = ("Page collections");

		$view = new SysView();
		$view->display('index');
	}

	public function actionCreate()
	{
		static::$title = ("Create collections");

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

		SysAjax::json_ok(_("Collection has been created successfully"));
	}

	public function actionUpdate()
	{
		static::$title = ("Update collection");

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
			SysAjax::json_err(_("Bad Request"));
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

		SysAjax::json_ok(_("Collection has been updated successfully"));
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

		if (!$item->delete()) {
			SysMessages::set(_("Collection cannot be deleted"), 'danger');
			SysRequest::redirect('/page/collection/');
		}

		SysMessages::set(_("Collection has been deleted successfully"), 'success');
		SysRequest::redirect('/page/collection/');
	}
}