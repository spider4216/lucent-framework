%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="/regions/general/create" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="<?php echo _("name"); ?>"/>
            <small><?php echo _("Name have to contain: a-z and/or _ symbols"); ?></small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/regions/general/ajaxcreate', '/regions/general/')"
                   value="<?php echo _("Save"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>