<?php
use core\classes\SysAssets;
use core\classes\SysWidget;

SysAssets::setAssets('css/style.css', 'users');
?>

<h2>Страница Demo</h2>
<div class="text-block">
    <p>Добро пожаловать на станицу Демо</p>
</div>

<div class="widget-test">
    <?php
    echo SysWidget::build('WTable', $model, [
        'columns' => [
            'title',
            'content',
        ],

        'buttons' => [
            'view' => [
                'link' => '/view',
            ],
            'update' => [
                'link' => '/update',
            ],
            'delete' => [
                'link' => '/delete',
            ],
        ],
    ]);
    ?>
</div>