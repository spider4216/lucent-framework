<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Управление ролями</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //SysBreadcrumbs::getAll
]);
?>

%system_notifications%

<div class="tools">
    <a href="/users/roles/create" class="btn btn-default">Создать роль</a>
</div>

<br/>

<div class="roles-list">
    <div class="widget-table">
        %users_roles%
    </div>
</div>