<?php
namespace core\modules\page\controllers;

use core\classes\ccontroller;
use core\classes\cview;
use core\modules\page\models\page;
use core\classes\request;
use core\classes\cmessages;

class basicController extends Ccontroller{

    public function actionIndex()
    {
        $model = new Page();

        $view = new Cview();
        $view->model = $model;

        $view->display('index');
    }

    public function actionCreate()
    {
        $view = new Cview();
        $model = new Page();
        $view->model = $model;

        if ($post = Request::post()) {
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                Cmessages::set('Страница была успешна создана', 'success');
                Request::redirect('/page/basic/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        $model = new Page();
        $view = new Cview();

        if ($post = Request::post()) {
            $model = $model->findByPk($post['id']);
            $model->title = $post['title'];
            $model->content = $post['content'];

            if ($model->save()) {
                Request::redirect('/page/basic/');
            }
        }

        if ($id = Request::get('id')) {
            $view->model = $model;
            $view->item = $model->findByPk($id);

            $view->display('update');
        } else {
            Request::redirect('/page/basic/');
        }

    }

    public function actionView()
    {
        if ($id = Request::get('id')) {
            $model = new Page();
            $view = new Cview();

            $view->model = $model;
            $view->item = $model->findByPk($id);

            $view->display('view');
        } else {
            Request::redirect('/page/basic/');
        }
    }

    public function actionDelete()
    {
        if ($id = Request::get('id')) {
            $model = new Page();
            $item = $model->findByPk($id);

            if ($item->delete()) {
                Request::redirect('/page/basic/');
            }

        } else {
            Request::redirect('/page/basic/');
        }
    }
}