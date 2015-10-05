<?php
use core\classes\SysWidget;
use core\classes\SysMessages;
use core\extensions\ExtBreadcrumbs;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="tool">
    <br/>
    <a class="btn btn-success" href="/page/basic/create"><?php echo _("Create page"); ?></a>
    <a class="btn btn-default" href="/page/type/"><?php echo _("Types"); ?></a>
    <a class="btn btn-default" href="/page/collection/"><?php echo _("Collections"); ?></a>
</div>

<div class="pages-list">
    <div class="widget-test">
        %page_listAll%
    </div>
</div>