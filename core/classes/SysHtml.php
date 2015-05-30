<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 17.05.2015
 * Time: 13:36
 */

namespace core\classes;


class SysHtml {
    public static function getAttributesFromArray($attributesArr)
    {
        $str_attributes = '';
        foreach ($attributesArr as $name => $value) {
            $str_attributes .= $name . '="' . $value . '" ';
        }

        return $str_attributes;

    }
}