<?php
use core\classes\SysMessages;
use core\classes\SysWidget;
?>

%system_title%

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
        <label for="username"><?= $user->getLabel('username'); ?>:</label>
        <span><?= $user->username; ?></span>
    </div>

</div>