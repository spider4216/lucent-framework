<?php
use core\classes\casset;
use core\classes\cwidget;

Casset::setAssets('css/style.css', 'users');
?>

<h2>Страница Demo</h2>
<div class="text-block">
    <p>Добро пожаловать на станицу Демо</p>
</div>

<div class="widget-test">
    <?php
    echo Cwidget::build('wtable', $model, [
        'columns' => [
            'title',
            'content',
        ]
    ]);
    ?>
</div>