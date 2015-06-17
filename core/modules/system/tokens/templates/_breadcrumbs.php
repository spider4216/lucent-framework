<?php
use core\classes\SysWidget;

if ($breadcrumbs) {
    echo SysWidget::build('WBreadcrumbs', '', [
        'breadcrumbs' => $breadcrumbs,
    ]);
}

?>