<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

<div class="form-group">

    %system_notifications%

    <form action="/page/basic/create" method="post">

        <div class="m-row">
            <label for="title"><?= $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="<?= locale::t("title"); ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8"
                      placeholder="<?= locale::t("content"); ?>"></textarea>
            <br/>
        </div>

		<div class="m-row">
			<label for="title"><?= $model->getLabel('page_type_id'); ?></label>
			<select class="form-control" name="page_type_id" id="page_type_id">
				<?php if (!empty($pageTypes)): ?>
					<?php foreach ($pageTypes as $type): ?>
						<option value="<?= $type->id ?>"><?= $type->title; ?></option>
					<?php endforeach; ?>
				<?php else: ?>
					<option value="-1"><?= locale::t("Not found"); ?></option>
				<?php endif; ?>
			</select>

            <br>
		</div>

        <div class="m-row">
            <label for="allow_comments"><?= $model->getLabel('allow_comments'); ?></label>
            <select class="form-control" name="allow_comments" id="allow_comments">
                <option value="1"><?= locale::t("Yes") ?></option>
                <option value="0"><?= locale::t("No") ?></option>
            </select>
        </div>

		<br>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/page/basic/ajaxcreate', '/page/basic/')"
                   value="<?= locale::t("Save"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>