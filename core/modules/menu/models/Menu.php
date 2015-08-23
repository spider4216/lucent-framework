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
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required', 'script' => ['create']]],
            //todo need only latin symbols and _ validator
            ['machine_name' => ['required', 'script' => ['create']]],

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
            return $nestedSet->createDummy();
        }

        return true;
    }

    public function beforeDelete()
    {
        $nestedSet = new ExtNestedset($this->machine_name);
        return $nestedSet->deleteDummy();
    }

}