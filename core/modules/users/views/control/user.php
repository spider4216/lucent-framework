<?php
use core\classes\cmessages;
?>

<h2>Личный кабинет</h2>

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