<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Авторизация</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

%system_notifications%

<?php if (!SysAuth::is_login()): ?>

<div class="form-group">
    <form action="/users/control/login" method="post">

        <div class="m-row">
            <label for="username"><?php echo $model->getLabel('username'); ?></label>
            <input type="text" name="username" class="form-control username" placeholder="Имя пользователя"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('password'); ?></label>
            <input type="password" name="password" class="form-control password" placeholder="Пароль"/>
            <br/>
        </div>

        <div class="m-row">
            <p><a href="/users/control/register">Регистрация</a></p>
        </div>

        <div class="m-row">
            <input type="submit" value="Войти" class="btn btn-primary"/>
        </div>

    </form>
</div>

<?php endif; ?>