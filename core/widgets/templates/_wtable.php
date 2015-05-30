<?php
use core\classes\SysWidget;

?>

<table class="table table-striped">
    <thead>
    <tr>
        <?php foreach ($data['items'] as $item): ?>
            <?php foreach ($item as $key => $value): ?>
                <?php if ('id' == $key && $data['show_id']): ?>
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

            <?php if ($data['tools']['buttons']): ?>
                <th>
                    <span></span>
                </th>
            <?php endif; ?>

            <?php break; ?>
        <?php endforeach; ?>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($data['items'] as $item): ?>
        <tr>
            <?php foreach ($item as $key => $itm): ?>
                <?php if ('id' == $key && $data['show_id']): ?>
                    <td>
                        <span><?php echo $itm; ?></span>
                    </td>
                <?php elseif('id' != $key): ?>
                    <td>
                        <span><?php echo $itm; ?></span>
                    </td>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($button = $data['tools']['buttons']): ?>
                <td>
                    <div class="widget-table-buttons-panel">
                        <?php if (isset($button['view'])): ?>
                            <a class="glyphicon glyphicon-eye-open" href="<?php echo $button['view']['link'] . '?id=' . $item->id; ?>"></a>
                        <?php endif; ?>
                        <?php if (isset($button['update'])): ?>
                            <a class="glyphicon glyphicon-pencil" href="<?php echo $button['update']['link'] . '?id=' . $item->id; ?>"></a>
                        <?php endif; ?>
                        <?php if (isset($button['delete'])): ?>
                            <?php
                                echo SysWidget::build('WBtnAsk', $model, [
                                    'link' => $button['delete']['link'] . '?id=' . $item->id,
                                    'value' => '',
                                    'ok_class' => 'btn btn-danger',
                                    'attributes' => [
                                        'class' => 'glyphicon glyphicon-trash',
                                    ],
                                ]);
                            ?>
                        <?php endif; ?>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>