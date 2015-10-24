<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_notifications%

<div class="progress">
    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0"
         aria-valuemax="100" style="width: 45%">
        <span class="sr-only">45% Complete</span>
        <small><?= locale::t("Please wait"); ?></small>
    </div>
</div>