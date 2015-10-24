<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_notifications%

<form action="/install/setup/process" method="post">
    <div class="m-row">
        <label for="projectName"><?= locale::t("Project Name"); ?></label>
        <input type="text" name="projectName" class="form-control" placeholder="<?= locale::t("CMF Lucent"); ?>"/>
    </div>

    <br/>

    <div class="m-row">
        <label for="lang"><?php echo _("Language"); ?></label>
        <select name="lang" id="lang" class="form-control">
            <option value="en" <?php echo (isset($_POST['lang']) && $_POST['lang'] == 'en') ? 'selected' : ''; ?>>
                <?= locale::t("English"); ?>
            </option>

            <option value="ru" <?php echo (isset($_POST['lang']) && $_POST['lang'] == 'ru') ? 'selected' : ''; ?>>
                <?= locale::t("Russian"); ?>
            </option>
        </select>
    </div>

    <div class="m-row">
        <div class="page-header">
            <h1><small><?= locale::t("User"); ?></small></h1>
        </div>

        <label for="username"><?= locale::t("Username"); ?></label>
        <input type="text" name="username" class="form-control" placeholder="<?= locale::t("Username"); ?>"/>

        <br/>

        <label for="email"><?= locale::t("E-mail"); ?></label>
        <input type="email" name="email" class="form-control" placeholder="<?= locale::t("E-mail"); ?>"/>

        <br/>

        <label for="password"><?= locale::t("Password"); ?></label>
        <input type="password" name="password" class="form-control" placeholder="<?= locale::t("Password"); ?>"/>

        <br/>

        <label for="password_again"><?= locale::t("Repeat password"); ?></label>
        <input type="password" name="password_again" class="form-control"
               placeholder="<?= locale::t("Repeat Password"); ?>"/>
    </div>

    <div class="m-row">
        <div class="page-header">
            <h1><small><?= locale::t("Database"); ?></small></h1>
        </div>

        <label for="dbname"><?= locale::t("Name"); ?></label>
        <input type="text" name="dbname" class="form-control" placeholder="<?= locale::t("Name"); ?>"/>

        <br/>

        <label for="dbusername"><?= locale::t("Username"); ?></label>
        <input type="text" name="dbusername" class="form-control" placeholder="<?= locale::t("Username"); ?>"
            value="<?= (isset($_POST['dbusername'])) ? $_POST['dbusername']: ''; ?>"/>

        <br/>

        <label for="dbpassword"><?= locale::t("Password"); ?></label>
        <input type="password" name="dbpassword" class="form-control" placeholder="<?= locale::t("Password"); ?>"/>

        <br/>

        <label for="dbhost"><?= locale::t("Host"); ?></label>
        <input type="text" name="dbhost" class="form-control" placeholder="<?= locale::t("localhost"); ?>"/>
    </div>

    <br/>
    <br/>

    <div class="m-row">
        <input type="button" onclick="SysAjaxSave('/install/setup/process', '/install/setup/finish')"
               class="btn btn-primary pull-right" value="<?= locale::t("Install now"); ?>"/>
    </div>
</form>