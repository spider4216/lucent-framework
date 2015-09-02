<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%


<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="username"><?php echo $model->getLabel('username'); ?></label>
            <input type="text" name="username" class="form-control username"
                   placeholder="<?php echo _("Username"); ?>" value="<?php echo $model->username ?>"
                <?php echo ($model->id == SysAuth::getCurrentUserId()) ? 'readonly' : '' ?>/>
            <br/>
        </div>

        <div class="m-row">
            <label for="password"><?php echo $model->getLabel('password'); ?></label>
            <input type="password" name="password" class="form-control password"
                   placeholder="<?php echo _("Password"); ?>" />
            <br/>
        </div>

        <div class="m-row">
            <label for="email"><?php echo $model->getLabel('email'); ?></label>
            <input type="email" name="email" class="form-control email"
                   placeholder="<?php echo _("E-mail"); ?>" value="<?php echo $model->email; ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="roles"><?php echo $model->getLabel('roles'); ?></label>
            <select class="form-control" name="roles" id="roles" >
                <?php foreach ($roleList as $role): ?>
                    <option <?php echo ($role->id == $model->role_id) ? 'selected' : ''; ?> value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                <?php endforeach; ?>
            </select>
            <br/>
        </div>

        <div class="m-row">
            <input type="button" onclick="ajaxUpdate()" value="<?php echo _("Save"); ?>" class="btn btn-primary"/>
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