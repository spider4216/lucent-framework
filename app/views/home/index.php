<div class="content">
    <div class="jumbotron">
        <h1><?php echo $title; ?></h1>
        <p></p>
        <p>
            <?php echo _("Lucent - Content Management Framework (CMF). With this system you can create ".
                "web sites, information systems or web applications very quickly and easily"); ?>
        </p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button"><?php echo _("Read more"); ?></a></p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="left-sidebar">
                <?php
                echo \core\classes\SysWidget::build('WRegionContent', '', [
                    'regionName' => 'left',
                ]);
                ?>
            </div>
        </div>

        <div class="col-md-8">
            <div class="main-sidebar">
                <?php
                echo \core\classes\SysWidget::build('WRegionContent', '', [
                    'regionName' => 'content',
                ]);
                ?>
            </div>
        </div>
    </div>
</div>