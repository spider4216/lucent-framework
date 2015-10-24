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
				SysLocale::t("pages") => '/page/basic/',
				SysLocale::t("pages types") => '-',
			],

			'create' => [
				SysLocale::t("pages") => '/page/basic/',
				SysLocale::t("pages types") => '/page/type/',
				SysLocale::t("create page's type") => '-',
			],

			'update' => [
				SysLocale::t("pages") => '/page/basic/',
				SysLocale::t("pages types") => '/page/type/',
				SysLocale::t("update page's type") => '-',
			],
		];
	}

	public function actionIndex()
	{
		static::$title = SysLocale::t("Page types");

		$view = new SysView();
		$view->display('index');
	}

	public function actionCreate()
	{
		static::$title = SysLocale::t("Create page type");

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

		SysAjax::json_ok(SysLocale::t("Page \"{:title}\" type has been created successfully", [
			'{:title}' => $post['title'],
		]));
	}

	public function actionUpdate()
	{
		static::$title = SysLocale::t("Update page type");

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

		SysAjax::json_ok(SysLocale::t("Page \"{:title}\" type has been updated successfully", [
			'{:title}' => $post['title'],
		]));
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

		$title = $item->title;

		if (!$item->delete()) {
			SysMessages::set(SysLocale::t("Page \"{:title}\" type cannot be deleted", [
				'{:title}' => $title,
			]), 'danger');
			SysRequest::redirect('/page/type/');
		}

		SysMessages::set(SysLocale::t("Page \"{:title}\" type has been deleted successfully", [
			'{:title}' => $item->title,
		]), 'success');
		SysRequest::redirect('/page/type/');
	}
}