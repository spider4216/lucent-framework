%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="content">
    <form action="" method="post">

        <div class="m-row">
            <label for="title"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" value="<?php echo $model->name; ?>"
                   class="form-control name" placeholder="<?php echo _("Menu name"); ?>"/>
        </div>

        <br>

        <br>

        <div class="m-row">
            <label for="content"><?php echo $model->getLabel('description'); ?></label>
            <br/>

        <textarea name="description" id="description" class="form-control" placeholder="<?php echo _("Description"); ?>"
                  rows="8"><?php echo $model->description ?></textarea>
        </div>

        <br>

        <div class="m-row">
            <input type="submit" class="btn btn-primary" value="<?php echo _("Save"); ?>">
            <?php
            echo \core\classes\SysWidget::build('WBtnAsk', $model, [
                'link' => '/menu/general/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
            <input type="hidden" name="id" value="<?php echo $model->id; ?>">
        </div>

    </form>
</div>