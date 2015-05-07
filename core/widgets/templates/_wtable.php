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
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>