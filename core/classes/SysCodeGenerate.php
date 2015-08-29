<?php
namespace core\classes;

/**
 * Class SysCodeGenerate
 * @package core\classes
 * Класс генирации данных
 */
class SysCodeGenerate
{
    /**
     * @param $db_name - Имя БД
     * @param $db_username - Имя пользователя БД
     * @param $db_password - Пароль пользователя
     * @param string $db_host - Сервер
     * @return string
     * Генерирует конфигурационный файл с БД данными
     * Возвразает json
     */
    public static function dbFile($db_name, $db_username, $db_password, $db_host = 'localhost')
    {
        $tpl = [
            'db_name' => $db_name,
            'db_username' => $db_username,
            'db_password' => $db_password,
            'db_host' => $db_host,
        ];

        return json_encode($tpl);
    }

    /**
     * @param $data - даные пришедшие из модуля установки (install)
     * @return string
     * Генерирует главнй конфигурационный файл проекта
     * Возвразает json
     */
    public static function configMain($data)
    {
        $tpl = [
            'project_name' => $data['projectName'],
            'project_system_name' => 'lucent',
            'lang' => $data['lang'],
            'default_controller' => 'home',
            'default_action' => 'index',
            'system_tables' => [
                'users' => 'users',
                'roles' => 'roles',
            ],
            'path' => [
                'migration_directory' => 'app/migrations',
            ],
        ];

        return json_encode($tpl);
    }


}