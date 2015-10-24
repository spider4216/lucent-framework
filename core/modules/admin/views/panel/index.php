<?php
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

<div class="admin-menu-content">
    <ul>
        <li>
            <a href="/page/basic/"><?= locale::t("Basic page"); ?></a>
        </li>

        <li>
            <a href="/menu/general/"><?= locale::t("Menu"); ?></a>
        </li>

        <li>
            <a href="/users/control/"><?= locale::t("Users system"); ?></a>
        </li>

        <li>
            <a href="/regions/general/"><?= locale::t("Regions"); ?></a>
        </li>

        <li>
            <a href="/blocks/general/"><?= locale::t("Blocks"); ?></a>
        </li>

        <li>
            <a href="/admin/panel/modules"><?= locale::t("Modules"); ?></a>
        </li>
    </ul>
</div>