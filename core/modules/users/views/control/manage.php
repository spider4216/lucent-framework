<?php
use core\classes\cwidget;
use core\classes\cmessages;
?>

<div class="page-header">
    <h2>Управление пользователями</h2>
</div>

<?php if ($messages = Cmessages::pretty(Cmessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>

<div class="users-list">
    <div class="widget-table">
        <?php
        echo Cwidget::build('wtable', $model, [
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