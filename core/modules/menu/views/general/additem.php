<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<form action="" method="post">

    <div class="m-row">
        <label for="value"><?= $model->getLabel('name'); ?></label>
        <input type="text" class="form-control" name="value" placeholder="<?= locale::t("Name"); ?>"
               value="<?= (!empty($_POST['value'])) ? $_POST['value'] : ''; ?>">
    </div>

    <br>

    <div class="m-row">
        <label for="value"><?= locale::t("Link"); ?></label>
        <input type="text" class="form-control" name="link" placeholder="<?= locale::t("Link"); ?>"
               value="<?= (!empty($_POST['link'])) ? $_POST['link'] : ''; ?>">
    </div>

    <br>

    <div class="m-row">
        <label for="items"><?= locale::t("Parent"); ?></label>
        <select class="form-control" name="items" id="items">
            <option value="-1"><?= locale::t("root"); ?></option>
            <?php if (!empty($options)): ?>
                <?php foreach ($options as $option): ?>
                    <option value="<?= $option->id ?>"><?= str_repeat('-', $option->level) . $option->value; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <br>

    <div class="m-row">
        <input type="button"
               onclick="SysAjaxSave('/menu/general/ajaxadditem', '/menu/general/manage?id=<?= $model->id; ?>')"
               class="btn btn-primary" value="<?= locale::t("Save"); ?>">
        <input type="hidden" name="id" value="<?= $model->id; ?>">
    </div>

</form>