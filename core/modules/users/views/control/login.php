<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<?php if (!SysAuth::is_login()): ?>

<div class="form-group login-form">
    <form action="/users/control/login" method="post">

        <div class="m-row">
            <label for="username"><?php echo $model->getLabel('username'); ?></label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">
                    <i class="glyphicon glyphicon-user"></i>
                </span>
                <input type="text" aria-describedby="basic-addon1"
                       name="username" class="form-control username" placeholder="Имя пользователя"/>
            </div>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('password'); ?></label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">
                    <i class="glyphicon glyphicon-eye-close"></i>
                </span>
                <input type="password" aria-describedby="basic-addon1"
                       name="password" class="form-control password" placeholder="Пароль"/>
            </div>
            <br/>
        </div>

        <div class="m-row">
            <p><a href="/users/control/register"><?php echo _("Registration"); ?></a></p>
        </div>

        <div class="m-row">
            <input type="button" onclick="ajaxLogin()" value="<?php echo _("Sign in"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>

<?php endif; ?>