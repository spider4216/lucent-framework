<?php
use core\classes\cwidget;
?>

<div class="page-header">
    <h2>Система пользователей</h2>
</div>

<?php
echo Cwidget::build('wbreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' => $item->title,
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