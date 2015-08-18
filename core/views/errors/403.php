<?php
use core\classes\SysMessages;
?>

<?php header("HTTP/1.0 403 Forbidden"); ?>

<div class="error-page">
    <h2><?php echo _("Error 403"); ?></h2>
    <?php echo SysMessages::pretty(SysMessages::get('danger')); ?>
</div>
