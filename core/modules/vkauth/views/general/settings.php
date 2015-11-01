<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%


<form action="" methos="post">
    <div class="content">
        <div class="m-row">
            <label for="client_id"><?= $model->getLabel('client_id'); ?></label>
            <input type="text" name="client_id" class="form-control client_id" placeholder="<?= locale::t("Client Id"); ?>"
                   value="<?= ($model->client_id) ?: ''; ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="client_secret"><?= $model->getLabel('client_secret'); ?></label>
            <input type="text" name="client_secret" class="form-control client_secret"
                   placeholder="<?= locale::t("Client Secret"); ?>"
                   value="<?= ($model->client_secret) ?: ''; ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="redirect_uri"><?= $model->getLabel('redirect_uri'); ?></label>
            <input type="text" name="redirect_uri" class="form-control redirect_uri"
                   placeholder="<?= locale::t("Redirect Uri"); ?>"
                   value="<?= ($model->redirect_uri) ?: ''; ?>"/>
        </div>

        <br>

        <div class="m-row">
            <input type="button" class="btn btn-primary"
                   onclick="SysAjaxSave('/vkauth/general/ajaxsettingssave', '/vkauth/general/')"
                   value="<?= locale::t("Save"); ?>">
        </div>
    </div>
</form>