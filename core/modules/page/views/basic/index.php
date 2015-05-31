<?php
use core\classes\SysWidget;
use core\classes\SysMessages;
use core\extensions\ExtBreadcrumbs;
?>

<div class="page-header">
    <h2>Список страниц</h2>
</div>


<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<?php if ($messages = SysMessages::pretty(SysMessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>

<div class="tool">
    <br/>
    <p><a class="btn btn-default" href="/page/basic/create">Создать страницу</a></p>
</div>

<div class="pages-list">
    <div class="widget-test">
        <?php
        echo SysWidget::build('WTable', $model, [
            'columns' => [
                'title',
            ],

            'buttons' => [
                'view' => [
                    'link' => '/page/basic/view',
                ],
                'update' => [
                    'link' => '/page/basic/update',
                ],
                'delete' => [
                    'link' => '/page/basic/delete',
                ],
            ],
        ]);
        ?>
    </div>
</div>