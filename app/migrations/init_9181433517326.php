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

    '2' => [
        'insert' => [
            'table' => 'pages',
            'columns' => [
                'title',
                'content'
            ],

            'values' => [
                'Welcome to CM Lucent',
                'Lucent - Content Management Framework (CMF)',
            ],
        ],
    ],

    '3' => [
        'createTable' => [
            'name' => 'roles',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'name' => 'varchar(255)',
            ],
        ],
    ],

    '4' => [
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

    '5' => [
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

    '6' => [
        'createTable' => [
            'name' => 'regions',
            'primary_key' => 'id',
            'columns' => [
                'id' => 'serial',
                'name' => 'varchar(255)',
            ],
        ],
    ],

    '7' => [
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

    '8' => [
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

    '9' => [
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

    '10' => [
        'insert' => [
            'table' => 'blocks',
            'columns' => [
                'name',
                'region_id',
                'content',
                'weight',
            ],

            'values' => [
                'Information',
                '2',
                'Content here',
                '2',
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
                'Statistic',
                '2',
                'Statistic here',
                '1',
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
                'Main menu',
                '2',
                'Content menu here',
                '0',
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
                'CMF Lucent',
                '1',
                'Amazing foundation for your projects',
                '0',
            ],
        ],
    ],

];

?>