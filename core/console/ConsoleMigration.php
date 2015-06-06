<?php

namespace core\console;


class ConsoleMigration {

    private $config = [];

    private $pdo;

    public function main($migrationName)
    {
        $this->config = include __DIR__ . '/../../app/config/main.php';
        $path =  __DIR__ . '/../../' . $this->config['path']['migration_directory'] . '/' . $migrationName. '.php';

        if (!file_exists($path)) {
            return 'Миграции "' . $migrationName . '" не существует';
        }

        $data = include $path;

        if (!$this->database()) {
            return "Ошибка соединения с базой данных";
        }

        $result = '';

        foreach ($data as $item) {
            foreach ($item as $key => $value) {
                switch ($key) {
                    case 'createTable':
                        $result .= $this->createTable($value);
                        break;
                    case 'insert':
                        $result .= $this->insert($value);
                        break;
                }
            }
        }

        if (empty($result)) {
            $result = 'Непредвиденная ошибка';
        }

        return $result;

    }

    private function createTable($description)
    {
        $columns = '';
        foreach ($description['columns'] as $name => $value) {
            $columns .= $name . ' ' . $value . ', ';
        }

        if (isset($description['primaryKey'])) {
            $columns .= 'PRIMARY KEY (' . $description['primaryKey'] . ')';
        } else {
            $columns = rtrim($columns, ", ");
        }

        $sql = 'CREATE TABLE ' . $description['name'] . ' (' .
            $columns . ')';

        $result = $this->pdo->exec($sql);

        if (false !== $result) {
            return 'Таблица "' . $description['name'] . '" была успешно создана' . "\n";
        }

        //return $result;
        return 'Ошибка при создании таблицы. Возможно таблица "' .
        $description['name'] . '" уже существует' . "\n";
    }

    private function insert($description)
    {
        $columns = implode(',', $description['columns']);
        $values = "'" . implode("','", $description['values']) . "'";

        $sql = 'INSERT INTO ' . $description['table'] . ' ('. $columns .') VALUES (' . $values . ')';

        $result = $this->pdo->exec($sql);

        if (false === $result) {
            return 'Ошибка при добавлении данных в таблицу "' . $description['table'] . '"' . "\n";
        }

        return 'Данные были успешно добавлены в таблицу "' . $description['table'] . '"' . "\n";
    }

    private function database()
    {
        $db_data = include __DIR__ . '/../../app/config/database.php';
        $dsn = 'mysql:dbname=' . $db_data['db_name'] . ';host=' . $db_data['db_host'];
        $this->pdo = new \PDO($dsn, $db_data['db_username'], $db_data['db_password'],array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );

        if ($this->pdo) {
            return true;
        }

        return false;
    }
}