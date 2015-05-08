<table class="table table-striped">
    <thead>
    <tr>
        <?php foreach ($items as $item): ?>
            <?php foreach ($item as $key => $value): ?>
                <?php if ('id' == $key && $show_id): ?>
                    <?php if ($label = $model->getLabel($key)): ?>
                        <th>
                            <span><?php echo $label; ?></span>
                        </th>
                    <?php else: ?>
                    <th>
                        <span><?php echo $key; ?></span>
                    </th>
                    <?php endif; ?>
                <?php elseif('id' != $key): ?>
                    <?php if ($label = $model->getLabel($key)): ?>
                        <th>
                            <span><?php echo $label; ?></span>
                        </th>
                    <?php else: ?>
                        <th>
                            <span><?php echo $key; ?></span>
                        </th>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($tools['buttons']): ?>
                <th>
                    <span></span>
                </th>
            <?php endif; ?>

            <?php break; ?>
        <?php endforeach; ?>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <?php foreach ($item as $key => $itm): ?>
                <?php if ('id' == $key && $show_id): ?>
                    <td>
                        <span><?php echo $itm; ?></span>
                    </td>
                <?php elseif('id' != $key): ?>
                    <td>
                        <span><?php echo $itm; ?></span>
                    </td>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($button = $tools['buttons']): ?>
                <td>
                    <div class="widget-table-buttons-panel">
                        <?php if ($button['view']): ?>
                            <a class="glyphicon glyphicon-eye-open" href="<?php echo $button['view']['link'] . '?id=' . $item->id; ?>"></a>
                        <?php endif; ?>
                        <?php if ($button['update']): ?>
                            <a class="glyphicon glyphicon-pencil" href="<?php echo $button['update']['link'] . '?id=' . $item->id; ?>"></a>
                        <?php endif; ?>
                        <?php if ($button['delete']): ?>
                            <a class="glyphicon glyphicon-trash" href="<?php echo $button['delete']['link'] . '?id=' . $item->id; ?>"></a>
                        <?php endif; ?>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>