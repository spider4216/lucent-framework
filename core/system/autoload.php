<?php

function autoload($myClassName)
{
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
    if (file_exists($path)) {
        require $path;
    }
}
spl_autoload_register('autoload');

?>