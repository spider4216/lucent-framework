<?php
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Управление пользователями</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //SysBreadcrumbs::getAll
]);
?>

%system_notifications%

<div class="users-list">
    <div class="widget-table">
        %users_sked%
    </div>
</div>