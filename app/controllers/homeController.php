<?php

namespace app\controllers;

/**
 * Class homeController
 * @package app\controllers
 * Контроллер по умолчанию. Для того, чтобы изменить контроллер по умолчанию
 * необходимо внести езменения в главном конфигурационном файле приложения
 * /app/config/main.php
 */
class homeController {

    public function actionIndex()
    {
        echo 'Default action';
    }
}