<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="content">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?= $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?= $model->name; ?>"
                   class="form-control name" placeholder="<?= locale::t("Menu name"); ?>"/>
        </div>

        <br>

        <br>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('description'); ?></label>
            <br/>

        <textarea name="description" id="description" class="form-control" placeholder="<?= locale::t("Description"); ?>"
                  rows="8"><?= $model->description ?></textarea>
        </div>

        <br>

		<div class="m-row">
			<label for="weight"><?= $model->getLabel('weight'); ?></label>
			<br/>
			<input type="number" class="form-control" name="weight" placeholder="<?= locale::t("Weight"); ?>"
                   min="0" max="99" maxlength="99" value="<?= $model->weight; ?>" />
		</div>

		<br>
		<hr>

		<?php if (!empty($regions)): ?>
			<div class="m-row">
				<label for="region_id"><?php echo $model->getLabel('region_id'); ?></label>
				<br/>
				<select name="region_id" id="region" class="form-control">
					<option value="none"><?= locale::t("not selected"); ?></option>
					<?php foreach($regions as $region): ?>
						<option value="<?= $region->id; ?>" <?= ($region->id == $regionSelected) ?
							'selected' : '' ?>><?= $region->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<br/>
		<?php endif; ?>

		<br>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/menu/general/ajaxupdate', '/menu/general/')"
                   class="btn btn-primary" value="<?= locale::t("Save"); ?>">
            <?php
            echo \core\classes\SysWidget::build('WBtnAsk', $model, [
                'link' => '/menu/general/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
            <input type="hidden" name="id" value="<?= $model->id; ?>">
        </div>

    </form>
</div>