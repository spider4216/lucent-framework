<?php
use core\classes\SysWidget;
use core\classes\SysMessages;
?>

<div class="page-header">
    <h2>Управление пользователями</h2>
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

<div class="users-list">
    <div class="widget-table">
        <?php
        echo SysWidget::build('WTable', $model, [
            'columns' => [
                'username',
            ],

            'buttons' => [
                'view' => [
                    'link' => '/users/control/user',
                ],
                'update' => [
                    'link' => '/users/control/update',
                ],
                'delete' => [
                    'link' => '/users/control/delete',
                ],
            ],
        ]);
        ?>
    </div>
</div>