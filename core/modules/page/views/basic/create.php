<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

<div class="form-group">

    %system_notifications%

    <form action="/page/basic/create" method="post">

        <div class="m-row">
            <label for="title"><?= $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="<?= _("title"); ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8" placeholder="<?= _("content"); ?>"></textarea>
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
					<option value="-1"><?= _("Not found"); ?></option>
				<?php endif; ?>
			</select>
		</div>

		<br>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/page/basic/ajaxcreate', '/page/basic/')"
                   value="<?= _("Save"); ?>" class="btn btn-primary"/>
        </div>

    </form>
</div>