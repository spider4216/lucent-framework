<?php

namespace core\modules\page_comments\controllers;

use core\classes\exception\E403;
use core\classes\SysAjax;
use core\classes\SysAuth;
use core\classes\SysController;
use core\classes\SysLocale;
use core\classes\SysMessages;
use core\classes\SysRequest;
use core\modules\page_comments\models\PageComments;

/**
 * @author farZa
 * Class generalController
 * @package core\modules\page_comments\controllers
 * Main controller for page comments module
 */
class generalController extends SysController
{
    /**
     * @author farZa
     * @throws E403
     */
    public function actionAjaxAddComment()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();

        $model = new PageComments();

        $model->load($post);
        $model->user_id = SysAuth::getCurrentUserId() ?: 0;

        if (!$model->save()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($model->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Comment has been added successfully"));
    }

    /**
     * @author farZa
     * @throws E403
     */
    public function actionAjaxDeleteComment()
    {
        if (!SysAjax::isAjax()) {
            throw new E403;
        }

        $post = SysRequest::post();

        $comment = PageComments::findByPk($post['id']);

        if (!$comment->delete()) {
            SysAjax::json_err(SysMessages::getPrettyValidatorMessages($comment->getErrors()));
        }

        SysAjax::json_ok(SysLocale::t("Comment has been deleted successfully"));
    }
}