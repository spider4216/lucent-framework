<?php

namespace core\widgets;

use core\classes\SysWidget;
use core\modules\regions\models\Regions;

/**
 * Class WRegionContent
 * @package core\widgets
 * в data обязательно должно быть имя региона
 */
class WRegionContent extends SysWidget
{
    public function stick($name, $model, $data) {

        if (!isset($data['regionName'])) {
            return '';
        }

        $items = Regions::getBlocks($data['regionName']);

        if (empty($items)) {
            return '';
        }

		//var_dump($items);

        return $this->render($name, $model, [
            'items' => $items,
            'regionName' => $data['regionName'],
        ]);
    }


}