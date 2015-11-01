<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%


<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="username"><?= $model->getLabel('username'); ?></label>
            <input type="text" name="username" class="form-control username"
                   placeholder="<?= locale::t("Username"); ?>" value="<?= $model->username ?>"
                <?php echo ($model->id == SysAuth::getCurrentUserId()) ? 'readonly' : '' ?>/>
            <br/>
        </div>

        <div class="m-row">
            <label for="password"><?= $model->getLabel('password'); ?></label>
            <input type="password" name="password" class="form-control password"
                   placeholder="<?= locale::t("Password"); ?>" />
            <br/>
        </div>

        <div class="m-row">
            <label for="email"><?= $model->getLabel('email'); ?></label>
            <input type="email" name="email" class="form-control email"
                   placeholder="<?= locale::t("E-mail"); ?>" value="<?= $model->email; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="roles"><?= $model->getLabel('roles'); ?></label>
            <select class="form-control" name="roles" id="roles" >
                <?php foreach ($roleList as $role): ?>
                    <option <?= ($role->id == $model->role_id) ? 'selected' : ''; ?> value="<?= $role->id; ?>"><?= $role->name; ?></option>
                <?php endforeach; ?>
            </select>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="ajaxUpdate()" value="<?= locale::t("Save"); ?>" class="btn btn-primary"/>
            <?php
                echo SysWidget::build('WBtnAsk', $model, [
                    'link' => '/users/control/delete?id=' . $model->id,
                    'ok_class' => 'btn btn-danger',
                ]);
            ?>
            <input type="hidden" name="id" value="<?= $model->id; ?>"/>
        </div>

    </form>
</div>