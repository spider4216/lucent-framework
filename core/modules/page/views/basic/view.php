<?php
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
use core\modules\users\models\Users;
use core\classes\SysAuth;
?>

%system_title%

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' => $item->title,
]);
?>

<p><?= $item->content; ?></p>

<?php if ($item->allow_comments == 1): ?>
    <hr>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <span><?= locale::t("Add comment"); ?></span>
        </div>
        <div class="panel-body">
            <form action="" method="post">
                <label for="comment"><?= locale::t("Add comment"); ?></label>
                <textarea class="form-control" name="comment" id="comment"></textarea>
                <br>
                <input type="button" class="btn btn-primary" value="<?= locale::t("Add comment"); ?>"
                       onclick="SysAjaxSave('/page_comments/general/ajaxaddcomment', '/page/basic/view?id=<?= $item->id; ?>')">
                <input type="hidden" name="page_id" value="<?= $item->id; ?>">
            </form>
        </div>
    </div>

    <?php if (!empty($comments)): ?>
        <br>

        <h2><?= locale::t("Comments"); ?></h2>

        <div class="well comment-list">
            <?php foreach ($comments as $comment): ?>
                <?php $user = Users::findByPk($comment->user_id); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9">
                                <span><?= locale::t("User"); ?>:</span>
                                <span><?= isset($user) ? $user->username : locale::t('Guest'); ?></span>
                            </div>

                            <div class="col-md-3">
                                <span><?= locale::t('Date') ?>:</span>
                                <span><?= $comment->date; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="comment-content">
                            <?= $comment->comment; ?>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <?php if (SysAuth::is_login()): ?>
                            <span class="remove-link" onclick="SysAjaxDelete(
                                '/page_comments/general/ajaxdeletecomment',
                                '/page/basic/view?id=<?= $item->id; ?>',
                                'PageComment', <?= $comment->id; ?>
                                )">
                                <?= locale::t("delete comment"); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>