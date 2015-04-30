<?php

use core\classes\Casset;

/**
 * @var string $content - Содержимое views
 * @todo Настройка имени проекта в title
 */
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Lucent Framework</title>
    <?php echo Casset::getAssets('style'); ?>
    <?php echo Casset::getAssets('script'); ?>
</head>
<body>
    <header>
        <div class="logo">
            <span>Lucent Framework</span>
        </div>
    </header>

    <section>
        <div class="main-content">
            <?php echo $content; ?>
        </div>
    </section>

    <footer>
        <div class="copyright">
            <span>(c) Lucent framework 2015</span>
        </div>
    </footer>
</body>
</html>