<?php
use core\classes\SysWidget;
?>

%system_title%

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' => $item->title,
]);
?>

<p><?php echo $item->content; ?></p>