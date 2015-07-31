%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="tools">
    <p>
        <a href="/blocks/general/create"><?php echo _("Create block"); ?></a>
    </p>
</div>

<div class="content">
    <div class="col-md-9">
        <h4><?php echo _("Available regions"); ?></h4>

        <div class="regions-list">
            <?php if (!empty($template)): ?>
                <?php foreach ($template as $tpl): ?>
                    <div class="list-group">
                        <a href="#" class="list-group-item disabled">
                            <?php echo $tpl['regionName']; ?>
                        </a>

                        <?php if (isset($tpl['blocks']) && !empty($tpl['blocks'])): ?>
                            <?php foreach ($tpl['blocks'] as $block): ?>
                                <a href="#" class="list-group-item">
                                    <?php echo $block; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-3">
        <h4><?php echo _("Available blocks"); ?></h4>

        <div class="blocks-list">
            <ul class="list-group">
                <?php if (!empty($blocks)): ?>
                    <?php foreach($blocks as $block): ?>
                        <li class="list-group-item">
                            <span><?php echo $block->name; ?></span>
                            <a href="/blocks/general/update/?id=<?php echo $block->id; ?>">
                                <i class="pull-right glyphicon glyphicon-pencil"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>