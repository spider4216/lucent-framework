<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%


<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="name"><?= $model->getLabel('name'); ?></label>
            <input type="text" name="name" class="form-control name"
                   <?= ($model->id == '1' || $model->id == '2') ? 'disabled' : ''; ?>
                   placeholder="<?= locale::t("Role name"); ?>" value="<?= $model->name ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" value="<?= $model->id; ?>" name="id" />
            <input type="button" onclick="SysAjaxSave('/users/roles/ajaxupdate', '/users/roles/')"
                   value="<?= locale::t("Save"); ?>" class="btn btn-primary"/>
            <?php
            echo SysWidget::build('WBtnAsk', $model, [
                'link' => '/users/roles/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>