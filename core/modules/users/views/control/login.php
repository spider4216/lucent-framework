<?php
use core\classes\cmessages;
use core\classes\cauth;
?>

<h2>Авторизация</h2>

<?php if ($messages = Cmessages::pretty(Cmessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>

<?php if (!Cauth::is_login()): ?>

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