<?php
use core\classes\SysMessages;
use core\classes\SysAuth;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Создать роль</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

%system_notifications%


<div class="form-group">
    <form action="/users/roles/create" method="post">

        <div class="m-row">
            <label for="name"><?php echo $model->getLabel('name'); ?></label>
            <input type="text" name="name" class="form-control name"
                   placeholder="Наименование роли" value="<?php echo $model->name ?>"/>
            <br/>
        </div>

        <div class="m-row">
            <input type="submit" value="Создать" class="btn btn-primary"/>
        </div>

    </form>
</div>