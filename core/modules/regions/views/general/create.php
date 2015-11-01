<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="/regions/general/create" method="post">

        <div class="m-row">
            <label for="title"><?= $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="<?= locale::t("name"); ?>"/>
            <small><?= locale::t("Name have to contain: a-z and/or _ symbols"); ?></small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/regions/general/ajaxcreate', '/regions/general/')"
                   value="<?= locale::t("Save"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>