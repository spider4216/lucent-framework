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

<div class="form-group login-form">
    <form action="/users/control/login" method="post">

        <div class="m-row">
            <label for="username"><?= $model->getLabel('username'); ?></label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">
                    <i class="glyphicon glyphicon-user"></i>
                </span>
                <input type="text" aria-describedby="basic-addon1"
                       name="username" class="form-control username" placeholder="<?= locale::t("Username") ?>"/>
            </div>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('password'); ?></label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">
                    <i class="glyphicon glyphicon-eye-close"></i>
                </span>
                <input type="password" aria-describedby="basic-addon1"
                       name="password" class="form-control password" placeholder="<?= locale::t("Password") ?>"/>
            </div>
            <br/>
        </div>

        <div class="m-row">
            <?php if (false !== \core\modules\vkauth\components\CmVkAuth::getUrl()): ?>
                <a href="<?= \core\modules\vkauth\components\CmVkAuth::getUrl(); ?>"><?= locale::t("Sign in via VK"); ?></a>
            <?php endif; ?>
            <p><a href="/users/control/register"><?= locale::t("Registration"); ?></a></p>
        </div>

        <div class="m-row">
            <input type="button" onclick="ajaxLogin()" value="<?= locale::t("Sign in"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>

<?php endif; ?>