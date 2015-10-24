<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="content">
    <form action="/menu/general/create" method="post">

        <div class="m-row">
            <label for="title"><?= $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="<?= locale::t("Menu name"); ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="title"><?= $model->getLabel('machine_name'); ?></label>
            <input type="text" name="machine_name" value="<?= isset($_POST['machine_name']) ? $_POST['machine_name'] : ''; ?>"
                   class="form-control machine-name" placeholder="<?= locale::t("Machine name"); ?>"/>
            <small><?= locale::t("Machine name have to contain: a-z and/or _"); ?></small>
        </div>

        <br>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('description'); ?></label>
            <br/>

        <textarea name="description" id="description" class="form-control" placeholder="<?= locale::t("Description"); ?>"
                  rows="8"></textarea>
        </div>

        <br>

		<div class="m-row">
			<label for="weight"><?= $model->getLabel('weight'); ?></label>
			<br/>
			<input type="number" class="form-control" name="weight" placeholder="<?= locale::t("Weight"); ?>"
                   min="0" max="99" maxlength="99" value="0" />
		</div>

		<br>
		<hr>

		<?php if (!empty($regions)): ?>
			<div class="m-row">
				<label for="region_id"><?= $model->getLabel('region_id'); ?></label>
				<br/>
				<select name="region_id" id="region" class="form-control">
					<option value="none"><?= locale::t("not selected"); ?></option>
					<?php foreach($regions as $region): ?>
						<option value="<?= $region->id; ?>"><?= $region->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<br/>
		<?php endif; ?>

		<br>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/menu/general/ajaxcreate', '/menu/general/')"
                   class="btn btn-primary" value="<?= locale::t("Save"); ?>">
        </div>

    </form>
</div>