<?php
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Система пользователей</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<div class="user-system">
    <ul>
        <li>
            <a href="/users/control/manage">Управление пользователями</a>
        </li>

        <li>
            <a href="/users/roles/">Управление ролями</a>
        </li>
    </ul>
</div>