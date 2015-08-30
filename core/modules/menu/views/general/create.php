%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="content">
    <form action="/menu/general/create" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"
                   class="form-control name" placeholder="<?php echo _("Menu name"); ?>"/>
        </div>

        <br>

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('machine_name'); ?></label>
            <input type="text" name="machine_name" value="<?php echo isset($_POST['machine_name']) ? $_POST['machine_name'] : ''; ?>"
                   class="form-control machine-name" placeholder="<?php echo _("Machine name"); ?>"/>
            <small><?php echo _("Machine name have to contain: a-z and/or _"); ?></small>
        </div>

        <br>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('description'); ?></label>
            <br/>

        <textarea name="description" id="description" class="form-control" placeholder="<?php echo _("Description"); ?>"
                  rows="8"></textarea>
        </div>

        <br>

        <div class="m-row">
            <input type="button" onclick="ajaxCreate()" class="btn btn-primary" value="<?php echo _("Save"); ?>">
        </div>

    </form>
</div>