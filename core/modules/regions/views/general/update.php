<?php
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?= $item->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?= $item->name; ?>" class="form-control name"
                   placeholder="<?= locale::t("name"); ?>"/>
            <small><?= locale::t("Name have to contain: a-z and/or _ symbols"); ?></small>
            <br/>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" name="id" value="<?= $item->id; ?>"/>
            <input type="button" onclick="SysAjaxSave('/regions/general/ajaxupdate', '/regions/general/')"
                   value="<?= locale::t("Save"); ?>" class="btn btn-primary"/>
            <?php
            echo SysWidget::build('WBtnAsk', $item, [
                'link' => '/regions/general/delete?id=' . $item->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>