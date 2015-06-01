<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

<div class="page-header">
    <h2>Личный кабинет</h2>
</div>

<?php
echo SysWidget::build('WBreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' =>$user->username,
]);
?>

%system_notifications%

<div class="user-info">

    <div class="m-row">
        <br/>
        <label for="username"><?php echo $user->getLabel('username'); ?>:</label>
        <span><?php echo $user->username; ?></span>
    </div>

</div>