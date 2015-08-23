%system_title%

%system_breadcrumbs%

%system_notifications%

<form action="" method="post">

    <div class="m-row">
        <label for="value"><?php echo $model->getLabel('name'); ?></label>
        <input type="text" class="form-control" name="value" placeholder="<?php echo _("Name"); ?>">
    </div>

    <br>

    <div class="m-row">
        <label for="items"><?php echo _("Parent"); ?></label>
        <select class="form-control" name="items" id="items">
            <option value="-1"><?php echo _("root"); ?></option>
            <?php if (!empty($options)): ?>
                <?php foreach ($options as $option): ?>
                    <option value="<?php echo $option->id ?>"><?php echo str_repeat('-', $option->level) . $option->value; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <br>

    <div class="m-row">
        <input type="submit" class="btn btn-primary" value="<?php echo _("Save"); ?>">
        <input type="hidden" name="id" value="<?php echo $model->id; ?>">
    </div>

</form>