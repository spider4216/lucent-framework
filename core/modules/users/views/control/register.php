<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Регистрация</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<?php if ($messages = SysMessages::pretty(SysMessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>

<?php if (!SysAuth::is_login()): ?>

<div class="form-group">
    <form action="/users/control/register" method="post">

        <div class="m-row">
            <label for="username"><?php echo $model->getLabel('username'); ?></label>
            <input type="text" name="username" class="form-control username"
                   placeholder="Имя пользователя"
                   value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="password"><?php echo $model->getLabel('password'); ?></label>
            <input type="password" name="password" class="form-control password"
                   placeholder="Пароль" />
            <br/>
        </div>

        <div class="m-row">
            <label for="password_again"><?php echo $model->getLabel('password_again'); ?></label>
            <input type="password" name="password_again" class="form-control password_again"
                   placeholder="Повторить пароль" />
            <br/>
        </div>

        <div class="m-row">
            <label for="email"><?php echo $model->getLabel('email'); ?></label>
            <input type="email" name="email" class="form-control email"
                   placeholder="E-mail"
                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="submit" value="Регистрация" class="btn btn-primary"/>
        </div>

    </form>
</div>

<?php endif; ?>