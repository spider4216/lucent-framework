<?php

use core\classes\SysAssets;
use core\classes\SysAuth;

/**
 * @var string $content - Содержимое views
 * @var string $title - Заголовок страницы
 */
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>%system_headTitle%</title>
    <?php echo SysAssets::getAssets('style'); ?>
    <?php echo SysAssets::getAssets('script'); ?>
</head>
<body>

<div class="page">
    <header>
        <nav class="navbar navbar-inverse">
            <a class="navbar-brand" href="/">
                <span>CMF Lucent</span>
            </a>

            <ul class="nav navbar-nav">
                <li>
                    <a href="#"><?php echo _("Features"); ?></a>
                </li>

                <li>
                    <a href="#"><?php echo _("Documentation"); ?></a>
                </li>

                <li>
                    <a href="#"><?php echo _("Plans"); ?></a>
                </li>
            </ul>

            <ul class="nav navbar-nav pull-right">
                <?php if ($username = SysAuth::getCurrentUser()): ?>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <span><?php echo _("User") . ': ' .  $username; ?></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <?php if (SysAuth::getCurrentRole() == 'admin'): ?>
                                    <a href="/admin/panel/"><?php echo _("Admin panel"); ?></a>
                                <?php endif; ?>
                                <a href="/users/control/user?id=<?php echo $_COOKIE['user_id']; ?>"><?php echo _("Profile"); ?></a>
                                <a href="/users/control/logout"><?php echo _("Logout"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/users/control/login"><?php echo _("Sign in"); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section>
        <div class="container">
            <div class="main-content">
                <?php echo $content; ?>
            </div>
        </div>
    </section>

    <div class="push"></div>
</div>

    <footer>
        <div class="copyright">
            <span>(c) Lucent framework 2015</span>
        </div>
    </footer>
</body>
</html>