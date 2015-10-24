<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_notifications%

<div class="m-row">
    <p><?= locale::t("Congratulation! CMF Lucent has been installed successfully. Are you ready?"); ?></p>
    <a href="/"><?= locale::t("Home page"); ?></a>
</div>