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
            <label for="title"><?= $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="<?= locale::t("title"); ?>"
                   value="<?= $model->title ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8"
                      placeholder="<?= locale::t("content"); ?>"><?= $model->content ?></textarea>
            <br/>
        </div>

		<div class="m-row">
			<label for="title"><?= $model->getLabel('page_type_id'); ?></label>
			<select class="form-control" name="page_type_id" id="page_type_id">
				<?php if (!empty($pageTypes)): ?>
					<?php foreach ($pageTypes as $type): ?>
						<option <?= $model->page_type_id == $type->id ? 'selected' : '' ?>
                            value="<?= $type->id ?>"><?= $type->title; ?></option>
					<?php endforeach; ?>
				<?php else: ?>
					<option value="-1"><?= locale::t("Not found"); ?></option>
				<?php endif; ?>
			</select>
		</div>

		<br>

        <div class="m-row">
            <label for="allow_comments"><?= $model->getLabel('allow_comments'); ?></label>
            <select class="form-control" name="allow_comments" id="allow_comments">
                <option value="1" <?= $model->allow_comments == 1 ? 'selected' : '' ?>><?= locale::t("Yes") ?></option>
                <option value="0" <?= $model->allow_comments == 0 ? 'selected' : '' ?>><?= locale::t("No") ?></option>
            </select>
        </div>

        <br>

        <div class="m-row">
            <input type="hidden" name="id" value="<?= $model->id; ?>"/>
            <input type="button" onclick="SysAjaxSave('/page/basic/ajaxupdate', '/page/basic/')"
                   value="<?= locale::t("Save"); ?>" class="btn btn-primary"/>
            <?=
            SysWidget::build('WBtnAsk', $model, [
                'link' => '/page/basic/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>