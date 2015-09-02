<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

<div class="form-group">

    %system_notifications%

    <form action="/page/basic/create" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="<?php echo _("title"); ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8" placeholder="<?php echo _("content"); ?>"></textarea>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/page/basic/ajaxcreate', '/page/basic/')"
                   value="<?php echo _("Save"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>