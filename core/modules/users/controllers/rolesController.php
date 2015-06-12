<?php
namespace core\modules\users\controllers;

use core\classes\SysController;
use core\classes\SysMessages;
use core\classes\SysView;
use core\classes\SysRequest;
use core\modules\users\models\Roles;
use core\classes\SysDisplay;
use core\extensions\ExtBreadcrumbs;

class RolesController extends SysController
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
                'Изменение роли' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = 'Управление ролями';

        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'index');
        $model = new Roles();
        $view = new SysView();

        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = 'Создать роль';

        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'create');
        $model = new Roles();
        $view = new SysView();

        $view->model = $model;
        $view->breadcrumbs = $breadcrumbs;

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];

            if ($model->is_new_record('name', $model->name)) {
                if ($model->save()) {
                    SysMessages::set('Роль "' . $model->name . '" была успешно создана', 'success');
                    SysRequest::redirect('/users/roles/');
                }
            } else {
                SysMessages::set('Роль "' . $model->name . '" уже существует', 'danger');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = 'Изменение роли';

        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'update');
        $view = new SysView();
        $view->breadcrumbs = $breadcrumbs;

        if($post = SysRequest::post()) {
            $model = Roles::findByPk($post['id']);

            if ($post['name'] == $model->name) {
                SysMessages::set('Роль "' . $model->name . '" осталась без изменений', 'info');
                SysRequest::redirect('/users/roles/');
            }

            if ($post['name'] != $model->name && $model->is_new_record('name', $post['name'])) {
                $model->name = $post['name'];

                if ($model->save()) {
                    SysMessages::set('Роль "' . $post['name'] . '" была успешно обновлена', 'success');
                    SysRequest::redirect('/users/roles/');
                } else {
                    $model = Roles::findByPk($post['id']);
                    $view->model = $model;
                    $view->display('update');
                }
            } else {
                $model = Roles::findByPk($post['id']);
                $model->name = $post['name'];
                $view->model = $model;
                SysMessages::set('Роль "' . $post['name'] . '" уже существует', 'danger');
                $view->display('update');

            }
        }

        if ($id = SysRequest::get('id')) {
            $model = Roles::findByPk($id);

            $view->model = $model;
            $view->display('update');
        } else {
            $display = new SysDisplay();
            SysMessages::set('Роль не найдена', 'danger');
            $display->render('core/views/errors/404',false,true);
        }
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Roles::findByPk($id);

            if ($model->id == '1' || $model->id == '2') {
                SysMessages::set('Системная роль "' . $model->name . '" не может быть удалена', 'danger');
                SysRequest::redirect('/users/roles/');
            }

            if ($model->delete()) {
                SysMessages::set('Роль "' . $model->name . '" была успешно удалена', 'success');
                SysRequest::redirect('/users/roles/');
            }
        } else {
            SysMessages::set('Роль не была удалена', 'danger');
            SysRequest::redirect('/users/roles/');
        }
    }
}