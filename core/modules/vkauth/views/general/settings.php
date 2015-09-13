%system_title%

%system_breadcrumbs%

%system_notifications%


<form action="" methos="post">
    <div class="content">
        <div class="m-row">
            <label for="client_id"><?php echo $model->getLabel('client_id'); ?></label>
            <input type="text" name="client_id" class="form-control client_id" placeholder="<?php echo _("Client Id"); ?>"
                   value="<?= ($model->client_id) ?: ''; ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="client_secret"><?php echo $model->getLabel('client_secret'); ?></label>
            <input type="text" name="client_secret" class="form-control client_secret"
                   placeholder="<?php echo _("Client Secret"); ?>"
                   value="<?= ($model->client_secret) ?: ''; ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="redirect_uri"><?php echo $model->getLabel('redirect_uri'); ?></label>
            <input type="text" name="redirect_uri" class="form-control redirect_uri"
                   placeholder="<?php echo _("Redirect Uri"); ?>"
                   value="<?= ($model->redirect_uri) ?: ''; ?>"/>
        </div>

        <br>

        <div class="m-row">
            <input type="button" class="btn btn-primary"
                   onclick="SysAjaxSave('/vkauth/general/ajaxsettingssave', '/vkauth/general/')" value="<?= _("Save"); ?>">
        </div>
    </div>
</form>