<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 19.07.2015
 * Time: 12:23
 */

namespace core\modules\regions\tokens;

use core\classes\SysWidget;
use core\modules\regions\models\Regions;

class RegionsTokens {

    public function listAll()
    {
        $model = new Regions();

        $regionsList = SysWidget::build('WTable', $model, [
            'columns' => [
                'name',
            ],

            'buttons' => [
                'update' => [
                    'link' => '/regions/general/update',
                ],
                'delete' => [
                    'link' => '/regions/general/delete',
                ],
            ],
        ]);

        return $regionsList;
    }
}