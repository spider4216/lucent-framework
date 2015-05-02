<?php
namespace core\modules\page\models;

use core\classes\cmodel;

class Page extends Cmodel
{
    //@todo Сделать инициализацию таблиц в БД
    protected static $table = 'pages';
}