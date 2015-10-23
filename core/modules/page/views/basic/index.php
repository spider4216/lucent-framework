<?php
use core\classes\SysWidget;
use core\classes\SysMessages;
use core\extensions\ExtBreadcrumbs;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="tool">
    <br/>
    <a class="btn btn-success" href="/page/basic/create"><?= locale::t("Create page"); ?></a>
    <a class="btn btn-default" href="/page/type/"><?= locale::t("Types"); ?></a>
    <a class="btn btn-default" href="/page/collection/"><?= locale::t("Collections"); ?></a>
</div>

<div class="pages-list">
    <div class="widget-test">
        %page_listAll%
    </div>
</div>