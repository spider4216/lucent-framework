<?php

namespace controllers;
use system\CView;

/**
 * Class homeController
 * @package controllers
 * @author farZa
 *
 * Actions: action<Name> (camelCase)
 * Controllers: <Name>Controller (camelCase)
 */
class homeController
{
	public function actionIndex()
	{
		CView::render('index');
	}
}