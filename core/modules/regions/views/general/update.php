<?php
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?php echo $item->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo $item->name; ?>" class="form-control name"
                   placeholder="<?php echo _("name"); ?>"/>
            <small><?php echo _("Name have to contain: a-z and/or _ symbols"); ?></small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" name="id" value="<?php echo $item->id; ?>"/>
            <input type="button" onclick="SysAjaxSave('/regions/general/ajaxupdate', '/regions/general/')"
                   value="<?php echo _("Save"); ?>" class="btn btn-primary"/>
            <?php
            echo SysWidget::build('WBtnAsk', $item, [
                'link' => '/regions/general/delete?id=' . $item->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>