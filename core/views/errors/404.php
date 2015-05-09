<?php
use core\classes\cmessages;
?>

<?php header("HTTP/1.0 404 Not Found"); ?>

<div class="error-page">
    <h2>Ошибка 404</h2>
    <?php echo Cmessages::pretty(Cmessages::get('info')); ?>
</div>
