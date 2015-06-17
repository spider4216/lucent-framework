<?php
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Список модулей</h2>
</div>

%system_breadcrumbs%

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-xs-4">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#">Системные</a></li>
                <li role="presentation"><a href="#">Пользовательские</a></li>
            </ul>

            <div class="system-list">
                <div class="list-group">
                    <?php foreach ($modules as $module): ?>
                        <a href="#" class="list-group-item disabled">
                            <h4 class="list-group-item-heading"><?php echo $module['name']; ?></h4>
                            <p class="list-group-item-text"><?php echo $module['description']; ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="users-list"></div>
        </div>

        <div class="col-xs-8">
            <div class="description">
                <div class="page-header">
                    <h1>Lucent Store <small>магазин модулей</small> </h1>
                </div>

                <div class="content">
                    <p>Здесь будет iframe магазина</p>
                </div>
            </div>
        </div>
    </div>
</div>