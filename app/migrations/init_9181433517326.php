<?php

return [
    'up' => [
        '0' => [
            'createTable' => [
                'name' => 'users',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'username' => 'varchar(255)',
                    'password' => 'text',
                    'role_id' => 'int',
                    'hash' => 'text',
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
                    'page_type_id' => 'int',
                ],
            ],
        ],

        '2' => [
            'insert' => [
                'table' => 'pages',
                'columns' => [
                    'title',
                    'content',
                    'page_type_id',
                ],

                'values' => [
                    'Welcome to CMF Lucent',
                    'Lucent - Amazing foundation for your projects',
                    '1',
                ],
            ],
        ],

        '3' => [
            'insert' => [
                'table' => 'pages',
                'columns' => [
                    'title',
                    'content',
                    'page_type_id',
                ],

                'values' => [
                    'CMF Lucent - Plans',
                    'Plans will be appeared soon',
                    '1',
                ],
            ],
        ],

        '4' => [
            'insert' => [
                'table' => 'pages',
                'columns' => [
                    'title',
                    'content',
                    'page_type_id',
                ],

                'values' => [
                    'CMF Lucent - Features',
                    'Features will be appeared soon',
                    '1',
                ],
            ],
        ],

        '5' => [
            'insert' => [
                'table' => 'pages',
                'columns' => [
                    'title',
                    'content',
                    'page_type_id',
                ],

                'values' => [
                    'CMF Lucent',
                    'Lucent is open source PHP Content Management Framework which can help to create web sites, '.
                    'information systems or web applications very quickly and easily. Lucent based on MVC '.
                    'architectural pattern and has module structure, so everyone can extend and improve that '.
                    'system very easily',
                    '2',
                ],
            ],
        ],

        '6' => [
            'insert' => [
                'table' => 'pages',
                'columns' => [
                    'title',
                    'content',
                    'page_type_id',
                ],

                'values' => [
                    'Welcome to CMF Lucent',
                    'Visit our <a target="_blank" href="http://github.com/spider4216/lucent-framework">github</a>. ' .
                    'Everyone can contribute CMF Lucent, improve and modify it',
                    '2',
                ],
            ],
        ],

        '7' => [
            'createTable' => [
                'name' => 'roles',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'name' => 'varchar(255)',
                ],
            ],
        ],

        '8' => [
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

        '9' => [
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

        '10' => [
            'createTable' => [
                'name' => 'regions',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'name' => 'varchar(255)',
                ],
            ],
        ],

        '11' => [
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

        '12' => [
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

        '13' => [
            'createTable' => [
                'name' => 'blocks',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'machine_name' => 'varchar(255)',
                    'name' => 'varchar(255)',
                    'region_id' => 'varchar(255)',
                    'content' => 'text',
                    'weight' => 'int',
                ],
            ],
        ],

        '14' => [
            'insert' => [
                'table' => 'blocks',
                'columns' => [
                    'machine_name',
                    'name',
                    'region_id',
                    'content',
                    'weight',
                ],

                'values' => [
                    'information',
                    'Information',
                    '2',
                    'This is information block',
                    '2',
                ],
            ],
        ],

        '15' => [
            'createTable' => [
                'name' => 'menu',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'name' => 'varchar(255)',
                    'machine_name' => 'varchar(255)',
                    'description' => 'text',
                    'weight' => 'int',
                    'region_id' => 'int',
                ],
            ],
        ],

        '16' => [
            'insert' => [
                'table' => 'menu',
                'columns' => [
                    'name',
                    'machine_name',
                    'description',
                    'weight',
                    'region_id',
                ],

                'values' => [
                    'Main menu',
                    'menu_main_menu',
                    'Menu for important CMF items',
                    '0',
                    '2',
                ],
            ],
        ],

        '17' => [
            'createTable' => [
                'name' => 'nestedset_menu_main_menu',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'left_key' => 'int',
                    'right_key' => 'int',
                    'level' => 'int',
                    'value' => 'text',
                    'tree' => 'int',
                    'link' => 'text',
                ],
            ],
        ],

        '18' => [
            'insert' => [
                'table' => 'nestedset_menu_main_menu',
                'columns' => [
                    'left_key',
                    'right_key',
                    'level',
                    'value',
                    'tree',
                    'link',
                ],

                'values' => [
                    '1',
                    '6',
                    '0',
                    'About',
                    '1',
                    '/page/basic/view?id=1',
                ],
            ],
        ],

        '19' => [
            'insert' => [
                'table' => 'nestedset_menu_main_menu',
                'columns' => [
                    'left_key',
                    'right_key',
                    'level',
                    'value',
                    'tree',
                    'link',
                ],

                'values' => [
                    '2',
                    '3',
                    '1',
                    'Plans',
                    '1',
                    '/page/basic/view?id=2',
                ],
            ],
        ],

        '20' => [
            'insert' => [
                'table' => 'nestedset_menu_main_menu',
                'columns' => [
                    'left_key',
                    'right_key',
                    'level',
                    'value',
                    'tree',
                    'link',
                ],

                'values' => [
                    '4',
                    '5',
                    '1',
                    'Features',
                    '1',
                    '/page/basic/view?id=3',
                ],
            ],
        ],

        '21' => [
            'createTable' => [
                'name' => 'vkauth',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'client_id' => 'int',
                    'client_secret' => 'text',
                    'redirect_uri' => 'text',
                ],
            ],
        ],

		'22' => [
			'createTable' => [
				'name' => 'page_types',
				'primary_key' => 'id',
				'columns' => [
					'id' => 'serial',
					'title' => 'text',
					'description' => 'text',
				],
			],
		],

        '23' => [
            'insert' => [
                'table' => 'page_types',
                'columns' => [
                    'title',
                    'description',
                ],

                'values' => [
                    'Basic page',
                    'Simple basic page',
                ],
            ],
        ],

        '24' => [
            'insert' => [
                'table' => 'page_types',
                'columns' => [
                    'title',
                    'description',
                ],

                'values' => [
                    'News',
                    'Simple news',
                ],
            ],
        ],

		'25' => [
			'createTable' => [
				'name' => 'page_collections',
				'primary_key' => 'id',
				'columns' => [
					'id' => 'serial',
					'name' => 'text',
					'description' => 'text',
					'page_type_id' => 'int',
					'pagination' => 'int',
					'region_id' => 'int',
					'links' => 'text',
					'weight' => 'int',
				],
			],
		],

        '26' => [
            'insert' => [
                'table' => 'page_collections',
                'columns' => [
                    'name',
                    'description',
                    'page_type_id',
                    'pagination',
                    'region_id',
                    'links',
                    'weight',
                ],

                'values' => [
                    'News',
                    'Simple news collection',
                    '2',
                    '0',
                    '1',
                    'null',
                    '0',
                ],
            ],
        ],

        '27' => [
            'createTable' => [
                'name' => 'guide',
                'primary_key' => 'id',
                'columns' => [
                    'id' => 'serial',
                    'machine_name' => 'text',
                    'switch' => 'int',
                ],
            ],
        ],

        '28' => [
            'insert' => [
                'table' => 'guide',
                'columns' => [
                    'machine_name',
                    'switch',
                ],

                'values' => [
                    'start',
                    '1',
                ],
            ],
        ],
    ],

    'down' => [
        '0' => [
            'deleteTable' => [
                'name' => 'users',
            ],
        ],

        '1' => [
            'deleteTable' => [
                'name' => 'pages',
            ]
        ],

        '2' => [
            'deleteTable' => [
                'name' => 'roles',
            ]
        ],

        '3' => [
            'deleteTable' => [
                'name' => 'regions',
            ]
        ],

        '4' => [
            'deleteTable' => [
                'name' => 'blocks',
            ]
        ],

		'5' => [
			'deleteTable' => [
				'name' => 'page_types',
			]
		],

		'6' => [
			'deleteTable' => [
				'name' => 'page_collections',
			]
		],

        '7' => [
			'deleteTable' => [
				'name' => 'nestedset_menu_main_menu',
			]
		],

        '8' => [
			'deleteTable' => [
				'name' => 'menu',
			]
		],

        '9' => [
			'deleteTable' => [
				'name' => 'guide',
			]
		],

        '10' => [
			'deleteTable' => [
				'name' => 'vkauth',
			]
		],
    ],
];