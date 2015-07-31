<?php
use core\classes\SysWidget;
?>

%system_title%

%system_breadcrumbs%

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-xs-4">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#"><?php echo _("System modules"); ?></a></li>
                <li role="presentation"><a href="#"><?php echo _("User modules"); ?></a></li>
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
                    <h1>Lucent Store <small><?php echo _("modules shop"); ?></small> </h1>
                </div>

                <div class="content">
                    <p><?php echo _("iframe here"); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>