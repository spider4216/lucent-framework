%system_title%

%system_notifications%

<form action="/install/setup/process" method="post">
    <div class="m-row">
        <label for="projectName"><?php echo _("Project Name"); ?></label>
        <input type="text" name="projectName" class="form-control" placeholder="<?php echo _("CMF Lucent"); ?>"/>
    </div>

    <br/>

    <div class="m-row">
        <label for="lang"><?php echo _("Language"); ?></label>
        <select name="lang" id="lang" class="form-control">
            <option value="en" <?php echo (isset($_POST['lang']) && $_POST['lang'] == 'en') ? 'selected' : ''; ?>>
                <?php echo _("English"); ?>
            </option>

            <option value="ru" <?php echo (isset($_POST['lang']) && $_POST['lang'] == 'ru') ? 'selected' : ''; ?>>
                <?php echo _("Russian"); ?>
            </option>
        </select>
    </div>

    <div class="m-row">
        <div class="page-header">
            <h1><small><?php echo _("User"); ?></small></h1>
        </div>

        <label for="username"><?php echo _("Username"); ?></label>
        <input type="text" name="username" class="form-control" placeholder="<?php echo _("Username"); ?>"/>

        <br/>

        <label for="email"><?php echo _("E-mail"); ?></label>
        <input type="email" name="email" class="form-control" placeholder="<?php echo _("E-mail"); ?>"/>

        <br/>

        <label for="password"><?php echo _("Password"); ?></label>
        <input type="password" name="password" class="form-control" placeholder="<?php echo _("Password"); ?>"/>

        <br/>

        <label for="password_again"><?php echo _("Repeat password"); ?></label>
        <input type="password" name="password_again" class="form-control" placeholder="<?php echo _("Repeat Password"); ?>"/>
    </div>

    <div class="m-row">
        <div class="page-header">
            <h1><small><?php echo _("Database"); ?></small></h1>
        </div>

        <label for="dbname"><?php echo _("Name"); ?></label>
        <input type="text" name="dbname" class="form-control" placeholder="<?php echo _("Name"); ?>"/>

        <br/>

        <label for="dbusername"><?php echo _("Username"); ?></label>
        <input type="text" name="dbusername" class="form-control" placeholder="<?php echo _("Username"); ?>"
            value="<?php echo (isset($_POST['dbusername'])) ? $_POST['dbusername']: ''; ?>"/>

        <br/>

        <label for="dbpassword"><?php echo _("Password"); ?></label>
        <input type="password" name="dbpassword" class="form-control" placeholder="<?php echo _("Password"); ?>"/>

        <br/>

        <label for="dbhost"><?php echo _("Host"); ?></label>
        <input type="text" name="dbhost" class="form-control" placeholder="<?php echo _("localhost"); ?>"/>
    </div>

    <br/>
    <br/>

    <div class="m-row">
        <input type="button" onclick="SysAjaxSave('/install/setup/process', '/install/setup/finish')"
               class="btn btn-primary pull-right" value="<?php echo _("Install now"); ?>"/>
    </div>
</form>