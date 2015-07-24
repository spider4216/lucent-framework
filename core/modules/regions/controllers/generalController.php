<?php
namespace core\modules\regions\controllers;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\classes\SysView;
use core\extensions\ExtBreadcrumbs;
use core\modules\regions\models\Regions;

class generalController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        //% - замещение. Например Хочу передать виджету никий заголовок для принта
        return [
            'index' => [
                'Регионы' => '-',
            ],

            'create' => [
                'Регионы' => '/regions/general/',
                'Создать' => '-',
            ],

            'update' => [
                'Регионы' => '/regions/general/',
                'Обновить' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = 'Регионы';

        $view = new SysView();
        $view->display('index');
    }

    public function actionCreate()
    {
        static::$title = 'Создание региона';
        $model = new Regions();
        $model->setScript('create');

        $view = new SysView();
        $view->model = $model;

        if ($post = SysRequest::post()) {
            $model->name = $post['name'];

            if ($model->save()) {
                SysMessages::set('Регион "'. $model->name .'" был успешно создан', 'success');
                SysRequest::redirect('/regions/general/');
            }
        }

        $view->display('create');
    }

    public function actionUpdate()
    {
        static::$title = 'Обновление региона';

        $view = new SysView();
        $display = new SysDisplay();

        $id = SysRequest::get('id');
        $post = SysRequest::post();

        if (!empty($post)) {
            $model = Regions::findByPk($post['id']);
            if (empty($model)) {
                SysMessages::set('Регион с id "'.$post['id'].'" не найден', 'danger');
                $display->render('core/views/errors/404',false,true);
            }
            $model->setScript('update');
            $model->name = $post['name'];

//            var_dump($model->isUniqueExceptRecord('name', $model->name));
//            return true;

            if ($model->save()) {
                SysMessages::set('Регион "'. $model->name .'" был успешно обновлен', 'success');
                SysRequest::redirect('/regions/general/');
            } else {
                $view->item = $model;
                $view->display('update');
                return true;
            }
        }

        if (!empty($id)) {
            $model = Regions::findByPk($id);
            if (empty($model)) {
                SysMessages::set('Регион с id "'.$id.'" не найден', 'danger');
                $display->render('core/views/errors/404',false,true);
                return true;
            }

            $view->item = $model;
        } else {
            SysMessages::set('Регион не найден', 'danger');
            $display->render('core/views/errors/404',false,true);
            return true;
        }


        $view->display('update');
    }

    public function actionDelete()
    {
        if ($id = SysRequest::get('id')) {
            $model = Regions::findByPk($id);
            if (empty($model)) {
                SysMessages::set('Регион не найден', 'danger');
                SysRequest::redirect('/regions/general/');
            }

            $regionName = $model->name;

            if (false !== $model->delete()) {
                SysMessages::set('Регион "'. $regionName .'" был успешно удален', 'success');
            } else {
                SysMessages::set('Регион "'. $regionName .'" не был удален', 'danger');
            }
        }

        SysRequest::redirect('/regions/general/');
    }
}