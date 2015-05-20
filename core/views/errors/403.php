<?php
use core\classes\cmessages;
?>

<?php header("HTTP/1.0 403 Forbidden"); ?>

<div class="error-page">
    <h2>Ошибка 403</h2>
    <?php echo Cmessages::pretty(Cmessages::get('danger')); ?>
</div>
