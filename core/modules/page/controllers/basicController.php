<?php
namespace core\modules\page\controllers;

use core\classes\ccontroller;
use core\classes\Cdisplay;
use core\classes\cview;
use core\modules\page\models\page;
use core\classes\request;
use core\classes\cmessages;
use core\classes\cbreadcrumbs;

class basicController extends Ccontroller{

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
        $model = new Page();
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'index');

        $view = new Cview();
        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('index');
    }

    public function actionCreate()
    {
        $view = new Cview();
        $model = new Page();
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'create');
        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        if ($post = Request::post()) {
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                Cmessages::set('Страница "'. $model->title .'" была успешна создана', 'success');
                Request::redirect('/page/basic/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        $model = new Page();
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'update');
        $view = new Cview();
        $view->breadcrumbs = $breadcrumbs;
        $display = new Cdisplay();

        if ($post = Request::post()) {
            $model = $model->findByPk($post['id']);
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                Cmessages::set('Страница "'. $model->title .'" была успешна обновлена', 'success');
                Request::redirect('/page/basic/');
            }
        }

        if ($id = Request::get('id')) {
            $view->model = $model;
            $item = $model->findByPk($id);

            if (!$item) {
                Cmessages::set('Страница с идентификатором "'.$id.'" не найдена', 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->item = $model->findByPk($id);

            $view->display('update');
        } else {
            $display = new Cdisplay();
            Cmessages::set('Страница не найдена', 'danger');
            $display->render('core/views/errors/404',false,true);
        }

    }

    public function actionView()
    {
        $display = new Cdisplay();
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'view');

        if ($id = Request::get('id')) {
            $model = new Page();
            $view = new Cview();
            $view->breadcrumbs = $breadcrumbs;

            $view->model = $model;
            $item = $model->findByPk($id);

            if (!$item) {
                Cmessages::set('Страница с идентификатором "'.$id.'" не найдена', 'danger');
                $display->render('core/views/errors/404',false,true);
            }

            $view->item = $item;

            $view->display('view');
        } else {
            Cmessages::set('Страница не найдена', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = Request::get('id')) {
            $model = new Page();
            $item = $model->findByPk($id);

            if ($item->delete()) {
                Cmessages::set('Страница "'. $item->title .'" была успешна удалена', 'success');
                Request::redirect('/page/basic/');
            }

        } else {
            Request::redirect('/page/basic/');
        }
    }
}