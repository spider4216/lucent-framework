<?php
use core\classes\SysLocale as locale;
?>

%system_title%

%system_breadcrumbs%

%system_notifications%

<div class="tool">
    <a href="/menu/general/additem?id=<?php echo $id; ?>"><?= locale::t("Add item"); ?></a>
</div>

<br>

<?php
echo \core\classes\SysWidget::build('WTree', '', [
    'nodes' => $nodes,
    'buttons' => [
        'delete' => [
            'link' => '/menu/general/deleteitem',
            'params' => [
                [
                    'key' => 'menu_id',
                    'value' => $id,
                ],
            ],
        ],
    ],
]);
?>