<?php

namespace core\modules\guide\controllers;

use core\classes\exception\E403;
use core\classes\SysAjax;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysRequest;
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

        if (!$post = SysRequest::post()) {
            SysAjax::json_err(SysLocale::t("expected type but did not pass"));
        }

        $model = Guide::findByColumn('machine_name', $post['type']);

        if (empty($model)) {
            SysAjax::json_err(SysLocale::t("guide with type \"{:type}\" was not found", [
                '{:type}' => $post['type'],
            ]));
        }

        $model->switch = 0;

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Guide has been finished successfully. Thank you"));
    }
}