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
        <span>(c) CMF Lucent 2015</span>
    </div>
</footer>
</body>
</html>