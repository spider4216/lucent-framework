<?php if(!empty($data)): ?>
    <div class="list-group wtree-list-group">
        <?php foreach($data['nodes'] as $d): ?>
            <div class="list-group-item"
               style="padding-left: <?php echo ($d->level * 20 == 0) ? 20 : $d->level * 40 ?>px">
                <div class="name" style="display: inline-block; vertical-align: middle"><span><?php echo $d->value; ?></span></div>

                <?php if (isset($data['buttons'])): ?>
                    <div class="tools pull-right" style="min-width:30px; text-align:center; display: inline-block; vertical-align: middle">
                        <?php if (isset($data['buttons']['delete'])): ?>
                            <?php
                            echo \core\classes\SysWidget::build('WBtnAsk', '', [
                                'link' => $data['buttons']['delete']['link'] . '?id=' . $d->id . $data['deleteParams'],
                                'value' => '',
                                'ok_class' => 'btn btn-danger',
                                'attributes' => [
                                    'class' => 'glyphicon glyphicon-trash',
                                ],
                            ]);
                            ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="menu">
        <span><?php echo _("Items not found"); ?></span>
    </div>
<?php endif; ?>
