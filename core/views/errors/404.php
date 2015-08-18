<?php
use core\classes\SysMessages;
?>

<?php header("HTTP/1.0 404 Not Found"); ?>

<div class="error-page">
    <h2><?php echo _("Error 404"); ?></h2>
    <?php echo SysMessages::pretty(SysMessages::get('danger')); ?>
</div>
