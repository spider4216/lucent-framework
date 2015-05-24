<?php
use core\classes\cwidget;
use core\classes\cmessages;
use core\classes\cbreadcrumbs;
?>

<div class="page-header">
    <h2>Список страниц</h2>
</div>


<?php
echo Cwidget::build('wbreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
]);
?>

<?php if ($messages = Cmessages::pretty(Cmessages::getAll())): ?>
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
        echo Cwidget::build('wtable', $model, [
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