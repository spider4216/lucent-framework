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
        %page_listAll%
    </div>
</div>