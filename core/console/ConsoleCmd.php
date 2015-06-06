<?php
namespace core\console;

class ConsoleCmd
{
    static $param = '';

    public function migrateTpl()
    {
        return file_get_contents(__DIR__ . '/../console/cgen/migration.cgen');
    }
}