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

<div class="page">
    <header>
        <nav class="navbar navbar-inverse">
            <a class="navbar-brand" href="/">
                <span>Lucent Framework</span>
            </a>

            <ul class="nav navbar-nav">
                <li>
                    <a href="#">Возможности</a>
                </li>

                <li>
                    <a href="#">Документация</a>
                </li>

                <li>
                    <a href="#">Планы</a>
                </li>
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
</div>

    <footer>
        <div class="copyright">
            <span>(c) Lucent framework 2015</span>
        </div>
    </footer>
</body>
</html>