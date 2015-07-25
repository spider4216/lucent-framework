<div class="region-<?php echo $data['regionName']; ?>">
    <?php foreach ($data['items'] as $block): ?>
        <div class="block block-<?php echo $block->id; ?> thumbnail">
            <?php if ('admin' == \core\classes\SysAuth::getCurrentRole()): ?>
                <div class="edit pull-right">
                    <a href="/blocks/general/update/?id=<?php echo $block->id; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                </div>
            <?php endif; ?>
            <div class="caption">
                <div class="title">
                    <h3><?php echo $block->name; ?></h3>
                </div>

                <div class="content">
                    <?php echo $block->content; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>