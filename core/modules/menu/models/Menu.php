<?php
namespace core\modules\menu\models;

use core\classes\SysModel;
use core\classes\SysView;
use core\extensions\ExtNestedset;

class Menu extends SysModel
{
    protected static $table = 'menu';

    protected static function labels()
    {
        return [
            'name' => _("Name"),
            'machine_name' => _("Machine name"),
            'description' => _("Description"),
            'weight' => _("Weight"),
            'region_id' => _("Region"),
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required', 'script' => ['create']]],
            ['machine_name' => ['required', 'machine_name', 'script' => ['create']]],

            ['name' => ['required', 'script' => ['update']]],
        ];
    }

    public function afterValidate()
    {
        if ('create' == $this->getScript()) {
            $this->machine_name = 'menu_' . $this->machine_name;
        }

        return true;
    }

    public function beforeSave()
    {
        if ('create' == $this->getScript()) {
            $nestedSet = new ExtNestedset($this->machine_name);
            return $nestedSet->createDummy(['link text NOT NULL']);
        }

        return true;
    }

    public function beforeDelete()
    {
        $nestedSet = new ExtNestedset($this->machine_name);
        return $nestedSet->deleteDummy();
    }

}