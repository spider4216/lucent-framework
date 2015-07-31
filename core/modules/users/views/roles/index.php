<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="tools">
    <a href="/users/roles/create" class="btn btn-default"><?php echo _("Create role"); ?></a>
</div>

<br/>

<div class="roles-list">
    <div class="widget-table">
        %users_roles%
    </div>
</div>