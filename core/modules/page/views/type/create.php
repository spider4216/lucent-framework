%system_title%

%system_breadcrumbs%

%system_notifications%

<form action="" method="post">
	<div class="m-row">
		<label for="title"><?= $model->getLabel('title'); ?></label>
		<input type="text" name="title" class="form-control title" placeholder="<?php echo _("title"); ?>"/>
		<br/>
	</div>

	<div class="m-row">
		<label for="content"><?= $model->getLabel('description'); ?></label>
		<textarea name="description" class="form-control content" rows="8" placeholder="<?php echo _("description"); ?>"></textarea>
		<br/>
	</div>

	<div class="m-row">
		<input type="button" onclick="SysAjaxSave('/page/type/ajaxcreate', '/page/type/')"
			   value="<?= _("Save"); ?>" class="btn btn-primary"/>
	</div>
</form>