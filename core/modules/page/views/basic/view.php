<?php
use core\classes\cwidget;
?>

<div class="page-header">
    <h2><?php echo $item->title; ?></h2>
</div>

<?php
echo Cwidget::build('wbreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' => $item->title,
]);
?>

<p><?php echo $item->content; ?></p>