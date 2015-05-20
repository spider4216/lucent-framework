<?php
use core\classes\cmessages;
use core\classes\cwidget;
?>

<div class="page-header">
    <h2>Управление ролями</h2>
</div>

<?php if ($messages = cmessages::pretty(Cmessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>

<div class="tools">
    <a href="/users/roles/create" class="btn btn-default">Создать роль</a>
</div>

<br/>

<div class="roles-list">
    <div class="widget-table">
        <?php
        echo Cwidget::build('wtable', $model, [
            'columns' => [
                'name',
            ],

            'buttons' => [
                'update' => [
                    'link' => '/users/roles/update',
                ],
                'delete' => [
                    'link' => '/users/roles/delete',
                ],
            ],
        ]);
        ?>
    </div>