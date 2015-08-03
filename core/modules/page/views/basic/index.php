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
    <p><a class="btn btn-default" href="/page/basic/create"><?php echo _("Create page"); ?></a></p>
</div>

<div class="pages-list">
    <div class="widget-test">
        %page_listAll%
    </div>
</div>