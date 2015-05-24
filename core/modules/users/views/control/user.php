<?php
use core\classes\cmessages;
use core\classes\cwidget;
?>

<div class="page-header">
    <h2>Личный кабинет</h2>
</div>

<?php
echo Cwidget::build('wbreadcrumbs', '', [
    'breadcrumbs' => $breadcrumbs, //Cbreadcrumbs::getAll
    'replacement' =>$user->username,
]);
?>

<?php if ($messages = Cmessages::pretty(Cmessages::getAll())): ?>
    <div class="summary">
        <?php echo $messages; ?>
    </div>
<?php endif; ?>

<div class="user-info">

    <div class="m-row">
        <br/>
        <label for="username"><?php echo $user->getLabel('username'); ?>:</label>
        <span><?php echo $user->username; ?></span>
    </div>

</div>