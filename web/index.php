<?php

// todo base root dir

use core\system\Lucent;
use core\system\Psr0AutoloaderClass;

require_once __DIR__ . '/../core/system/Psr0AutoloaderClass.php';
require_once __DIR__ . '/../core/system/Psr4AutoloaderClass.php';
$psr0 = new Psr0AutoloaderClass();
$psr0->run();

Lucent::run();