<?php
namespace core\commands;

use core\console\ConsoleCmd;
use core\console\ConsoleMigration;

class CmdMigrate extends ConsoleCmd
{
    public function actionIndex()
    {
        $text = "Доступны следующие действия: \n";
        $text .= "- create [name] \n";
        $text .= "- run [name] \n";
        $text .= "- down [name] \n";

        return $text;
    }

    public function actionCreate()
    {
        if (empty(static::$param)) {
            return "Вы не передали обязательный параметр [name] \n";
        }

        $tpl = $this->migrateTpl();

        $filename = static::$param . '_' . rand(0,999) . time();
        //далее нужно проверить файл на существование
        $config = include __DIR__ . '/../../app/config/main.php';

        $path = __DIR__ . '/../../' . $config['path']['migration_directory'] . '/';
        $fullPath = $path . $filename . '.php';

        if (file_exists($fullPath)) {
            return 'Миграция "' . $filename . '" уже существует' . "\n";
        }

        file_put_contents($fullPath, $tpl);


        return 'Миграция "' . $filename . '" была успешно создана' . " \n";
    }

    public function actionRun()
    {
        if (empty(static::$param)) {
            return "Вы не передали обязательный параметр [name] \n";
        }

        $consoleMigration = new ConsoleMigration();
        $result = $consoleMigration->main(static::$param);

        return 'Результат: ' . $result . "\n";
    }

    public function actionDown()
    {
        if (empty(static::$param)) {
            return "Вы не передали обязательный параметр [name] \n";
        }

        $consoleMigration = new ConsoleMigration();
        $result = $consoleMigration->down(static::$param);

        return 'Результат: ' . $result . "\n";
    }
}