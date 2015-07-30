<?php

/**
 * Главный конфигурационный файл приложения
 */
return [
    'project_name' => 'Lucent Framework',
    //Данную запись менять не стоит. Локализация и т.д
    'project_system_name' => 'lucent',
    //access: en
    'lang' => 'en',
    /** Контроллер по умолчанию*/
    'default_controller' => 'home',
    /** Действие по умолчанию*/
    'default_action' => 'index',
    
    'system_tables' => [
        'users' => 'users',
        'roles' => 'roles',
    ],

    'path' => [
        'migration_directory' => 'app/migrations',
    ],
];

?>