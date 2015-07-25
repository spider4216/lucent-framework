<div class="content">
    <div class="jumbotron">
        <h1><?php echo $title; ?></h1>
        <p></p>
        <p>
            Вас привествует чрезвычайно простой, удобный и яркий фраемворк LUCENT, который готов помочь вам вооплатить
            все ваши идеи в реальность.
        </p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Узнать больше</a></p>
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