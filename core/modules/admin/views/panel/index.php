<?php
use core\classes\cwidget;
?>

<div class="page-header">
    <h2>Админ панель</h2>
</div>

<?php
    echo Cwidget::build('wbreadcrumbs', '', [
        'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    ]);
?>

<div class="admin-menu-content">
    <ul>
        <li>
            <a href="/page/basic/">Базовые страницы</a>
        </li>

        <li>
            <a href="/users/control/">Система пользователей</a>
        </li>

        <li>
            <a href="/admin/panel/modules">Модули</a>
        </li>
    </ul>
</div>