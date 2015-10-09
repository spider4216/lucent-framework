<?php

function dependency() {
    $dir = __DIR__ . '/../vendor/';

    if (is_dir($dir)) {
        require_once $dir . 'autoload.php';
    }
}

function autoload($myClassName) {
    $classParts = explode('\\', $myClassName);

    switch ($classParts[0]) {
        case 'app':
            $classParts[0] = $_SERVER['DOCUMENT_ROOT'] . '/app';
            break;
        case 'core':
            $classParts[0] = $_SERVER['DOCUMENT_ROOT'] . '/core';
    }

    $path = implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
    //echo $path;

    //small trick for cli (I mean for phpunit)
    if ('cli' == PHP_SAPI) {
        $path = __DIR__ . '/../../'. $path;
    }

    if (file_exists($path)) {
        require $path;
    }
}
spl_autoload_register('autoload');
dependency();