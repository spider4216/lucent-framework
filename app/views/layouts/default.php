<?php

use core\classes\casset;
use core\classes\cauth;

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

            <ul class="nav navbar-nav pull-right">
                <?php if ($username = Cauth::getCurrentUser()): ?>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <span>Пользователь: <?php echo $username; ?></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/users/control/user?id=<?php echo $_COOKIE['user_id']; ?>">Профиль</a>
                                <a href="/users/control/logout">Выйти</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/users/control/login">Войти в систему</a>
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