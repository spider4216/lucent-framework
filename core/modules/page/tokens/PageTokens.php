<?php

namespace core\modules\page\tokens;


use core\classes\SysDisplay;
use core\classes\SysPath;
use core\classes\SysWidget;
use core\classes\SysController;
use core\modules\page\models\Page;
use core\modules\page\models\PageCollections;
use core\modules\page\models\PageType;

class PageTokens {

    public function listAll()
    {
        $model = new Page();

        $pagesList = SysWidget::build('WTable', $model, [
            'columns' => [
                'title',
            ],

            'buttons' => [
                'view' => [
                    'link' => '/page/basic/view',
                ],
                'update' => [
                    'link' => '/page/basic/update',
                ],
                'delete' => [
                    'link' => '/page/basic/delete',
                ],
            ],
        ]);

        return $pagesList;
    }

	public function listTypesAll()
	{
		$model = new PageType();

		$pagesList = SysWidget::build('WTable', $model, [
			'columns' => [
				'title',
			],

			'buttons' => [
				'update' => [
					'link' => '/page/type/update',
				],
				'delete' => [
					'link' => '/page/type/delete',
				],
			],
		]);

		return $pagesList;
	}

	public function collectionsAll()
	{
		$model = new PageCollections();

		$pagesList = SysWidget::build('WTable', $model, [
			'columns' => [
				'name',
				'description',
			],

			'buttons' => [
				'update' => [
					'link' => '/page/collection/update',
				],
				'delete' => [
					'link' => '/page/collection/delete',
				],
			],
		]);

		return $pagesList;
	}
}