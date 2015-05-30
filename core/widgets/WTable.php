<?php
namespace core\widgets;


use core\classes\SysWidget;
use core\classes\SysPath;

class WTable extends SysWidget
{

    public function stick($name, $model, $data)
    {
        $show_id = false;
        $conditional = isset($data['conditional']) ? $data['conditional'] : '';

        $columns = '';
        if ($data['columns']) {
            $columns = $data['columns'];

            if (!in_array('id', $columns)) {
                $columns[] = 'id';
            } else {
                $show_id = true;
            }
        }

        $tools = [
            'buttons' => $data['buttons'],
        ];

        $items = $model->findAll($conditional, $columns);

        return $this->render($name, $model, [
            'items' => $items,
            'tools' => $tools,
            'show_id' => $show_id,
        ]);
    }
}