<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="tools">
    <a href="/users/roles/create" class="btn btn-default"><?= locale::t("Create role"); ?></a>
</div>

<br/>

<div class="roles-list">
    <div class="widget-table">
        %users_roles%
    </div>
</div>