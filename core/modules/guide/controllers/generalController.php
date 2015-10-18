<?php

namespace core\modules\guide\controllers;

use core\classes\exception\E403;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysMessages;
use core\modules\guide\models\Guide;

class generalController extends SysController
{
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'finish' => ['user', '-'],
        ];
    }

    public function actionFinish()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        if (!$post = $_POST) {
            SysAjax::json_err(_("expected type but did not pass"));
        }

        $model = Guide::findByColumn('machine_name', $post['type']);

        if (empty($model)) {
            SysAjax::json_err(_("guide was not found"));
        }

        $model->switch = 0;

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(_("Guide has been finished successfully. Thank you"));
    }
}