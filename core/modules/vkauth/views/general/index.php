<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<ul>
    <li>
        <a href="<?= $vkAuthUrl; ?>"><?= locale::t("Sign in via VK") ?></a>
    </li>

    <li>
        <a href="/vkauth/general/settings"><?= locale::t("VK settings"); ?></a>
    </li>
</ul>