<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Редактирование пользователя</h2>
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


<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="username"><?php echo $model->getLabel('username'); ?></label>
            <input type="text" name="username" class="form-control username"
                   placeholder="Имя пользователя" value="<?php echo $model->username ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="password"><?php echo $model->getLabel('password'); ?></label>
            <input type="password" name="password" class="form-control password"
                   placeholder="Пароль" />
            <br/>
        </div>

        <div class="m-row">
            <label for="email"><?php echo $model->getLabel('email'); ?></label>
            <input type="email" name="email" class="form-control email"
                   placeholder="E-mail" value="<?php echo $model->email; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="roles"><?php echo $model->getLabel('roles'); ?></label>
            <select class="form-control" name="roles" id="roles">
                <?php foreach ($roleList as $role): ?>
                    <option <?php echo ($role->id == $model->role_id) ? 'selected' : ''; ?> value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                <?php endforeach; ?>
            </select>
            <br/>
        </div>

        <div class="m-row">
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
            <?php
                echo SysWidget::build('WBtnAsk', $model, [
                    'link' => '/users/control/delete?id=' . $model->id,
                    'ok_class' => 'btn btn-danger',
                ]);
            ?>
            <input type="hidden" name="id" value="<?php echo $model->id; ?>"/>
        </div>

    </form>
</div>