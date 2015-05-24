<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="/">Главная</a></li>
        <?php foreach ($data['breadcrumbs'] as $breadcrumbs): ?>
            <?php if ($breadcrumbs['link'] == '-'): ?>

                <?php if ('%' == $breadcrumbs['title']): ?>
                    <li class="active"><?php echo $data['replacement'] ?></li>
                <?php else: ?>
                    <li class="active"><?php echo $breadcrumbs['title'] ?></li>
                <?php endif; ?>

            <?php else: ?>
                <li><a href="<?php echo $breadcrumbs['link']; ?>"><?php echo $breadcrumbs['title']; ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</div>