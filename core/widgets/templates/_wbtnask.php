<?php
use core\classes\chtml;
?>

<a <?php echo Chtml::getAttributesFromArray($data['attributes']); ?>
    data-href="<?php echo $data['link']; ?>"
    data-title="<?php echo $data['message']; ?>"
    data-btnOkClass="<?php echo $data['ok_class']; ?>"
    data-btnOkLabel="<?php echo $data['ok_label']; ?>"
    data-btnCancelLabel="<?php echo $data['cancel_label']; ?>"
>
    <?php echo $data['value']; ?>
</a>