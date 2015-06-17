<?php
namespace core\modules\page\controllers;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysView;
use core\modules\page\models\Page;
use core\classes\SysRequest;
use core\classes\SysMessages;
use core\extensions\ExtBreadcrumbs;

class basicController extends SysController{

    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
            'create' => ['user', '-'],
            'update' => ['user', '-'],
            'delete' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                'страницы' => '-',
            ],

            'create' => [
                'страницы' => '/page/basic/',
                'создание страницы' => '-',
            ],

            'update' => [
                'страницы' => '/page/basic/',
                'редактирование страницы' => '-',
            ],

            'view' => [
                'страницы' => '/page/basic/',
                '%' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = 'Страницы';

        $model = new Page();

        $view = new SysView();
        $view->model = $model;

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = 'Создание страницы';

        $view = new SysView();
        $model = new Page();
        $view->model = $model;

        if ($post = SysRequest::post()) {
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                SysMessages::set('Страница "'. $model->title .'" была успешна создана', 'success');
                SysRequest::redirect('/page/basic/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = 'Редактирование страницы';

        $model = new Page();
        $view = new SysView();
        $display = new SysDisplay();

        if ($post = SysRequest::post()) {
            $model = $model->findByPk($post['id']);
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                SysMessages::set('Страница "'. $model->title .'" была успешна обновлена', 'success');
                SysRequest::redirect('/page/basic/');
            }
        }

        if ($id = SysRequest::get('id')) {
            $view->model = $model;
            $item = $model->findByPk($id);

            if (!$item) {
                SysMessages::set('Страница с идентификатором "'.$id.'" не найдена', 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->item = $model->findByPk($id);

            $view->display('update');
        } else {
            $display = new SysDisplay();
            SysMessages::set('Страница не найдена', 'danger');
            $display->render('core/views/errors/404',false,true);
        }

    }

    public function actionView()
    {
        $display = new SysDisplay();
        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'view');

        if ($id = SysRequest::get('id')) {
            $model = new Page();
            $view = new SysView();
            $view->breadcrumbs = $breadcrumbs;

            $view->model = $model;
            $item = $model->findByPk($id);

            static::$title = $item->title;

            if (!$item) {
                SysMessages::set('Страница с идентификатором "'.$id.'" не найдена', 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->item = $item;

            $view->display('view');
        } else {
            SysMessages::set('Страница не найдена', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = new Page();
            $item = $model->findByPk($id);

            if ($item->delete()) {
                SysMessages::set('Страница "'. $item->title .'" была успешна удалена', 'success');
                SysRequest::redirect('/page/basic/');
            }

        } else {
            SysRequest::redirect('/page/basic/');
        }
    }
}