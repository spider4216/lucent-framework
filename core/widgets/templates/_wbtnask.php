<?php
use core\classes\chtml;
?>

<a <?php echo Chtml::getAttributesFromArray($tools['attributes']); ?>
    data-href="<?php echo $tools['link']; ?>"
    data-title="<?php echo $tools['message']; ?>"
    data-btnOkClass="<?php echo $tools['ok_class']; ?>"
    data-btnOkLabel="<?php echo $tools['ok_label']; ?>"
    data-btnCancelLabel="<?php echo $tools['cancel_label']; ?>"
>
    <?php echo $tools['value']; ?>
</a>