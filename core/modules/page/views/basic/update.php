<?php
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('title'); ?></label>
            <input type="text" name="title" class="form-control title" placeholder="<?php echo _("title"); ?>"
                   value="<?php echo $model->title ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('content'); ?></label>
            <textarea name="content" class="form-control content" rows="8"
                      placeholder="<?php echo _("content"); ?>"><?php echo $model->content ?></textarea>
            <br/>
        </div>

		<div class="m-row">
			<label for="title"><?= $model->getLabel('page_type_id'); ?></label>
			<select class="form-control" name="page_type_id" id="page_type_id">
				<?php if (!empty($pageTypes)): ?>
					<?php foreach ($pageTypes as $type): ?>
						<option <?= $model->page_type_id == $type->id ? 'selected' : '' ?> value="<?= $type->id ?>"><?= $type->title; ?></option>
					<?php endforeach; ?>
				<?php else: ?>
					<option value="-1"><?= _("Not found"); ?></option>
				<?php endif; ?>
			</select>
		</div>

		<br>

        <div class="m-row">
            <input type="hidden" name="id" value="<?php echo $model->id; ?>"/>
            <input type="button" onclick="SysAjaxSave('/page/basic/ajaxupdate', '/page/basic/')"
                   value="<?php echo _("Save"); ?>" class="btn btn-primary"/>
            <?php
                echo SysWidget::build('WBtnAsk', $model, [
                    'link' => '/page/basic/delete?id=' . $model->id,
                    'ok_class' => 'btn btn-danger',
                ]);
            ?>
        </div>

    </form>
</div>