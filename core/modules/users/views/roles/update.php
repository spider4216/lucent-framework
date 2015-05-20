<?php
use core\classes\cmessages;
use core\classes\cauth;
use core\classes\cwidget;
?>

<div class="page-header">
    <h2>Изменить роль</h2>
</div>


<?php if ($messages = Cmessages::pretty(Cmessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>


<div class="form-group">
    <form action="" method="post">

        <div class="m-row">
            <label for="name"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" class="form-control name"
                   placeholder="Наименование роли" value="<?php echo $model->name ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="hidden" value="<?php echo $model->id; ?>" name="id" />
            <input type="submit" value="сохранить" class="btn btn-primary"/>
            <?php
            echo Cwidget::build('wbtnask', $model, [
                'link' => '/users/roles/delete?id=' . $model->id,
                'ok_class' => 'btn btn-danger',
            ]);
            ?>
        </div>

    </form>
</div>