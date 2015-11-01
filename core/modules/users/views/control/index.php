<?php
use core\classes\SysWidget;
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

<div class="user-system">
    <ul>
        <li>
            <a href="/users/control/manage"><?= locale::t("Manage users"); ?></a>
        </li>

        <li>
            <a href="/users/roles/"><?= locale::t("Manage roles"); ?></a>
        </li>

        <li>
            <a href="/vkauth/general/"><?= locale::t("VK Auth"); ?></a>
        </li>
    </ul>
</div>