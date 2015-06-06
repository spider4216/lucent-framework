<?php
namespace app\commands;

use core\classes\SysCmd;

class CmdTest extends SysCmd
{

    public function actionIndex()
    {
        return 'Доступны следующие действия: ...';
    }

    public function actionRun()
    {
        return 'test run';
    }
}