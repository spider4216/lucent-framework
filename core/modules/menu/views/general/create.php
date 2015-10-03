%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="content">
    <form action="/menu/general/create" method="post">

        <div class="m-row">
            <label for="title"><?= $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="<?= _("Menu name"); ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="title"><?= $model->getLabel('machine_name'); ?></label>
            <input type="text" name="machine_name" value="<?= isset($_POST['machine_name']) ? $_POST['machine_name'] : ''; ?>"
                   class="form-control machine-name" placeholder="<?= _("Machine name"); ?>"/>
            <small><?= _("Machine name have to contain: a-z and/or _"); ?></small>
        </div>

        <br>

        <div class="m-row">
            <label for="content"><?= $model->getLabel('description'); ?></label>
            <br/>

        <textarea name="description" id="description" class="form-control" placeholder="<?= _("Description"); ?>"
                  rows="8"></textarea>
        </div>

        <br>

		<div class="m-row">
			<label for="weight"><?= $model->getLabel('weight'); ?></label>
			<br/>
			<input type="number" class="form-control" name="weight" placeholder="<?= _("Weight"); ?>" min="0" max="99"
				   maxlength="99" value="0" />
		</div>

		<br>
		<hr>

		<?php if (!empty($regions)): ?>
			<div class="m-row">
				<label for="region_id"><?php echo $model->getLabel('region_id'); ?></label>
				<br/>
				<select name="region_id" id="region" class="form-control">
					<option value="none"><?php echo _("not selected"); ?></option>
					<?php foreach($regions as $region): ?>
						<option value="<?php echo $region->id; ?>"><?php echo $region->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<br/>
		<?php endif; ?>

		<br>

        <div class="m-row">
            <input type="button" onclick="SysAjaxSave('/menu/general/ajaxcreate', '/menu/general/')"
                   class="btn btn-primary" value="<?= _("Save"); ?>">
        </div>

    </form>
</div>