<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<?php if (!SysAuth::is_login()): ?>

<div class="form-group">
    <form action="/users/control/register" method="post">

        <div class="m-row">
            <label for="username"><?= $model->getLabel('username'); ?></label>
            <input type="text" name="username" class="form-control username"
                   placeholder="<?= locale::t("Username"); ?>"
                   value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="password"><?= $model->getLabel('password'); ?></label>
            <input type="password" name="password" class="form-control password"
                   placeholder="<?= locale::t("Password"); ?>" />
            <br/>
        </div>

        <div class="m-row">
            <label for="password_again"><?= $model->getLabel('password_again'); ?></label>
            <input type="password" name="password_again" class="form-control password_again"
                   placeholder="<?= locale::t("Repeat password again"); ?>" />
            <br/>
        </div>

        <div class="m-row">
            <label for="email"><?= $model->getLabel('email'); ?></label>
            <input type="email" name="email" class="form-control email"
                   placeholder="<?= locale::t("E-mail"); ?>"
                   value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="ajaxRegister()" value="<?= locale::t("Registration"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>

<?php endif; ?>