<?php

namespace core\modules\page\controllers;

use core\classes\exception\E403;
use core\classes\exception\E404;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\extensions\ExtBreadcrumbs;
use core\modules\page\models\PageType;

class typeController extends SysController
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
				_("pages types") => '-',
			],

			'create' => [
				_("pages") => '/page/basic/',
				_("pages types") => '/page/type/',
				_("create page's type") => '-',
			],

			'update' => [
				_("pages") => '/page/basic/',
				_("pages types") => '/page/type/',
				_("update page's type") => '-',
			],
		];
	}

	public function actionIndex()
	{
		static::$title = ("Page types");

		$view = new SysView();
		$view->display('index');
	}

	public function actionCreate()
	{
		static::$title = ("Create page type");

		$view = new SysView();
		$model = new PageType();

		$view->model = $model;
		$view->display('create');
	}

	public function actionAjaxCreate()
	{
		if (!SysAjax::isAjax()) {
			throw new E403;
		}

		$post = SysRequest::post();
		$model = new PageType();

		$model->title = $post['title'];
		$model->description = $post['description'];

		if (!$model->save()) {
			SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
		}

		SysAjax::json_ok(_("Page type has been created successfully"));
	}

	public function actionUpdate()
	{
		static::$title = ("Update page type");

		$id = SysRequest::get('id');

		if (empty($id)) {
			throw new E404;
		}

		$model = PageType::findByPk($id);

		if (empty($model)) {
			throw new E404;
		}

		$view = new SysView();

		$view->model = $model;
		$view->display('update');
	}

	public function actionAjaxUpdate()
	{
		if (!SysAjax::isAjax()) {
			throw new E403;
		}

		$post = SysRequest::post();

		$model = PageType::findByPk((int)$post['id']);

		if (empty($model)) {
			SysAjax::json_err(_("Bad Request"));
		}

		$model->title = $post['title'];
		$model->description = $post['description'];

		if (!$model->save()) {
			SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
		}

		SysAjax::json_ok(_("Page type has been updated successfully"));
	}

	public function actionDelete()
	{
		$id = SysRequest::get('id');

		if (empty($id)) {
			throw new E404;
		}

		$item = PageType::findByPk($id);

		if (empty($item)) {
			throw new E404;
		}

		if (!$item->delete()) {
			SysMessages::set(_("Page type cannot be deleted"), 'danger');
			SysRequest::redirect('/page/type/');
		}

		SysMessages::set(_("Page type has been deleted successfully"), 'success');
		SysRequest::redirect('/page/type/');
	}
}