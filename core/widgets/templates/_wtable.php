<span>table widget file</span>

<table class="table table-striped">
    <thead>
        <tr>
            <?php foreach ($items as $item): ?>
                <?php foreach ($item as $key => $value): ?>
                    <th>
                        <?php if ($label = $model->getLabel($key)): ?>
                            <span><?php echo $label; ?></span>
                        <?php else: ?>
                            <span><?php echo $key; ?></span>
                        <?php endif; ?>
                    </th>
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
                <?php foreach ($item as $itm): ?>
                    <td>
                        <span><?php echo $itm; ?></span>
                    </td>
                <?php endforeach; ?>

                <?php if ($button = $tools['buttons']): ?>
                    <td>
                        <div class="widget-table-buttons-panel">
                            <?php if ($button['view']): ?>
                                <a class="glyphicon glyphicon-eye-open" href="<?php echo $button['view']['link']; ?>"></a>
                            <?php endif; ?>
                            <?php if ($button['update']): ?>
                                <a class="glyphicon glyphicon-pencil" href="<?php echo $button['update']['link']; ?>"></a>
                            <?php endif; ?>
                            <?php if ($button['update']): ?>
                                <a class="glyphicon glyphicon-trash" href="<?php echo $button['delete']['link']; ?>"></a>
                            <?php endif; ?>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>