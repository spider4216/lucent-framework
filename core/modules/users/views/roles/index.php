<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Управление ролями</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<?php if ($messages = SysMessages::pretty(SysMessages::getAll())): ?>
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
        echo SysWidget::build('WTable', $model, [
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