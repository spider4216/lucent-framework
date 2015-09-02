<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%


<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="name"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" class="form-control name"
                   <?php echo ($model->id == '1' || $model->id == '2') ? 'disabled' : ''; ?>
                   placeholder="<?php echo _("Role name"); ?>" value="<?php echo $model->name ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" value="<?php echo $model->id; ?>" name="id" />
            <input type="button" onclick="SysAjaxSave('/users/roles/ajaxupdate', '/users/roles/')"
                   value="<?php echo _("Save"); ?>" class="btn btn-primary"/>
            <?php
            echo SysWidget::build('WBtnAsk', $model, [
                'link' => '/users/roles/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>