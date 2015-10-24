<?php
use core\classes\SysLocale as locale;
?>

<?php \core\classes\SysAssets::setAssets('guide/js/guide.js', 'modules'); ?>
<?php \core\classes\SysAssets::setAssets('guide/css/guide.css', 'modules'); ?>

<div class="modal fade bs-example-modal-lg" id="guideModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= locale::t("Quick guide"); ?></h4>
            </div>
            <div class="modal-body">


                <div class="modal-content">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="/app/assets/modules/guide/images/slide_1.png" alt="slide 1">
                                <div class="carousel-caption">
                                    <h3><?= locale::t("Create your own page"); ?></h3>
                                    <p><?= locale::t("Lucent let you create page very simply"); ?></p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="/app/assets/modules/guide/images/slide_2.png" alt="slide 2">
                                <div class="carousel-caption">
                                    <h3><?= locale::t("Collection"); ?></h3>
                                    <p><?= locale::t("With this feature you can collect your pages in collection " .
                                            "and put them in region as blocks"); ?></p>
                                </div>
                            </div>

                            <div class="item">
                                <img src="/app/assets/modules/guide/images/slide_3.png" alt="slide 2">
                                <div class="carousel-caption">
                                    <h3><?= locale::t("Menu"); ?></h3>
                                    <p><?= locale::t("Create as many items as you want with Menu Module"); ?></p>
                                </div>
                            </div>

                            <div class="item">
                                <img src="/app/assets/modules/guide/images/slide_4.png" alt="slide 2">
                                <div class="carousel-caption">
                                    <h3><?= locale::t("Blocks and Regions"); ?></h3>
                                    <p><?= locale::t("Put your custom content, collection or menu in regions"); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= locale::t("Cancel"); ?></button>
                <button type="button" onclick="stopGuide('start')"
                        class="btn btn-primary"><?= locale::t("Got it"); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->