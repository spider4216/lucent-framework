<?php

return [

    '0' => [
        'createTable' => [
            'name' => 'users',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'username' => 'varchar(255)',
                'password' => 'text',
                'role_id' => 'int',
                'email' => 'varchar(255)',
            ],
        ],
    ],

    '1' => [
        'insert' => [
            'table' => 'users',
            'columns' => [
                'username',
                'password',
                'role_id',
                'email',
            ],

            'values' => [
                'admin',
                //до тех пор, пока не будет реализована установка системы...
                '21232f297a57a5a743894a0e4a801fc3', //admin
                '1',
                'admin@example.com',
            ],
        ],
    ],

    '2' => [
        'createTable' => [
            'name' => 'pages',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'title' => 'varchar(255)',
                'content' => 'text',
            ],
        ],
    ],

    '3' => [
        'insert' => [
            'table' => 'pages',
            'columns' => [
                'title',
                'content'
            ],

            'values' => [
                'Добро пожаловать в систему Lucent',
                'Вас привествует чрезвычайно простой, удобный и яркий фраемворк Lucent',
            ],
        ],
    ],

    '4' => [
        'createTable' => [
            'name' => 'roles',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'name' => 'varchar(255)',
            ],
        ],
    ],

    '5' => [
        'insert' => [
            'table' => 'roles',
            'columns' => [
                'name',
            ],

            'values' => [
                'admin',
            ],
        ],
    ],

    '6' => [
        'insert' => [
            'table' => 'roles',
            'columns' => [
                'name',
            ],

            'values' => [
                'user',
            ],
        ],
    ],

    '7' => [
        'createTable' => [
            'name' => 'regions',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'name' => 'varchar(255)',
            ],
        ],
    ],

    '8' => [
        'insert' => [
            'table' => 'regions',
            'columns' => [
                'name',
            ],

            'values' => [
                'content',
            ],
        ],
    ],

    '9' => [
        'insert' => [
            'table' => 'regions',
            'columns' => [
                'name',
            ],

            'values' => [
                'left',
            ],
        ],
    ],

    '10' => [
        'createTable' => [
            'name' => 'blocks',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'name' => 'varchar(255)',
                'region_id' => 'varchar(255)',
                'content' => 'text',
                'weight' => 'int',
            ],
        ],
    ],

    '11' => [
        'insert' => [
            'table' => 'blocks',
            'columns' => [
                'name',
                'region_id',
                'content',
                'weight',
            ],

            'values' => [
                'Информация',
                '2',
                'Здесь будет ваша информация',
                '2',
            ],
        ],
    ],

    '12' => [
        'insert' => [
            'table' => 'blocks',
            'columns' => [
                'name',
                'region_id',
                'content',
                'weight',
            ],

            'values' => [
                'Статистика',
                '2',
                'Здесь будет ваша статистика',
                '1',
            ],
        ],
    ],

    '13' => [
        'insert' => [
            'table' => 'blocks',
            'columns' => [
                'name',
                'region_id',
                'content',
                'weight',
            ],

            'values' => [
                'Главное меню',
                '2',
                'Здесь будет главное меню',
                '0',
            ],
        ],
    ],

    '14' => [
        'insert' => [
            'table' => 'blocks',
            'columns' => [
                'name',
                'region_id',
                'content',
                'weight',
            ],

            'values' => [
                'CMF Lucent',
                '1',
                'Изящный фундамент для ваших веб проектов',
                '0',
            ],
        ],
    ],

];

?>