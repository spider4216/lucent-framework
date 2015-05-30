<?php
namespace core\modules\page\models;

use core\classes\SysModel;

class Page extends SysModel
{
    //@todo Сделать инициализацию таблиц в БД
    protected static $table = 'pages';

    //@todo Сделать функцию перевода
    protected static function labels()
    {
        return [
            'title' => 'Заголовок',
            'content' => 'Содержимое',
        ];
    }

    public static function rules()
    {
        return [
            'title' => ['required'],
            'content' => ['required'],
        ];
    }

}