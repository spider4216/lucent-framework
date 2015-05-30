<?php
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2><?php echo $item->title; ?></h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' => $item->title,
]);
?>

<p><?php echo $item->content; ?></p>