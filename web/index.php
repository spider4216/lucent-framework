<?php

declare(strict_types=1);

// todo base root dir

use core\system\Lucent;
use core\system\Psr0AutoloaderClass;
use core\system\Psr4AutoloaderClass;


require_once __DIR__ . '/../core/system/Psr0AutoloaderClass.php';
require_once __DIR__ . '/../core/system/Psr4AutoloaderClass.php';

$psr4 = new Psr4AutoloaderClass();
$psr4->addNamespace('Packages\\PHPDAO', 'core/packages/PHPDAO/Classes');
$psr4->addNamespace('Packages\\PHPDAO\\DAObjects', 'core/packages/PHPDAO/DAObjects');
$psr4->addNamespace('Packages\\PHPDAO\\DAOFactories', 'core/packages/PHPDAO/DAOFactories');
$psr4->register();

$psr0 = new Psr0AutoloaderClass();
$psr0->run();

Lucent::run();