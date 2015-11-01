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
    <form action="/users/roles/create" method="post">

        <div class="m-row">
            <label for="name"><?= $model->getLabel('name'); ?></label>
            <input type="text" name="name" class="form-control name"
                   placeholder="<?= locale::t("Role name"); ?>" value="<?= $model->name ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/users/roles/ajaxcreate', '/users/roles/')"
                   value="<?= locale::t("Create"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>