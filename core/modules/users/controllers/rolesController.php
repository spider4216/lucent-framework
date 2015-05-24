<?php
namespace core\modules\users\controllers;

use core\classes\ccontroller;
use core\classes\cmessages;
use core\classes\cview;
use core\classes\request;
use core\modules\users\models\roles;
use core\classes\cdisplay;
use core\classes\cbreadcrumbs;

class RolesController extends Ccontroller
{
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
                'пользователи' => '/users/control/',
                'управление ролями' => '-',
            ],

            'create' => [
                'пользователи' => '/users/control/',
                'управление ролями' => '/users/roles/',
                'создать роль' => '-',
            ],

            'update' => [
                'пользователи' => '/users/control/',
                'управление ролями' => '/users/roles/',
                'редактировать роль' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'index');
        $model = new Roles();
        $view = new Cview();

        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('index');
    }

    public function actionCreate()
    {
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'create');
        $model = new Roles();
        $view = new Cview();

        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        if ($post = Request::post()) {
            $model->name = $post['name'];

            if ($model->is_new_record('name', $model->name)) {
                if ($model->save()) {
                    Cmessages::set('Роль "' . $model->name . '" была успешно создана', 'success');
                    Request::redirect('/users/roles/');
                }
            } else {
                Cmessages::set('Роль "' . $model->name . '" уже существует', 'danger');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'update');
        $view = new Cview();
        $view->breadcrumbs = $breadcrumbs;

        if($post = Request::post()) {
            $model = Roles::findByPk($post['id']);

            if ($post['name'] == $model->name) {
                Cmessages::set('Роль "' . $model->name . '" осталась без изменений', 'info');
                Request::redirect('/users/roles/');
            }

            if ($post['name'] != $model->name && $model->is_new_record('name', $post['name'])) {
                $model->name = $post['name'];

                if ($model->save()) {
                    Cmessages::set('Роль "' . $post['name'] . '" была успешно обновлена', 'success');
                    Request::redirect('/users/roles/');
                } else {
                    $model = Roles::findByPk($post['id']);
                    $view->model = $model;
                    $view->display('update');
                }
            } else {
                $model = Roles::findByPk($post['id']);
                $model->name = $post['name'];
                $view->model = $model;
                Cmessages::set('Роль "' . $post['name'] . '" уже существует', 'danger');
                $view->display('update');

            }
        }

        if ($id = Request::get('id')) {
            $model = Roles::findByPk($id);

            $view->model = $model;
            $view->display('update');
        } else {
            $display = new Cdisplay();
            Cmessages::set('Роль не найдена', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = Request::get('id')) {
            $model = Roles::findByPk($id);

            if ($model->delete()) {
                Cmessages::set('Роль "' . $model->name . '" была успешно удалена', 'success');
                Request::redirect('/users/roles/');
            }
        } else {
            Cmessages::set('Роль не была удалена', 'danger');
            Request::redirect('/users/roles/');
        }
    }
}