<?php

require __DIR__ . '/core/console/ConsoleCmd.php';
require __DIR__ . '/core/console/ConsoleMigration.php';

$namespace = '';
$pathCommandCore = __DIR__ . '/app/commands';
$pathCommandApp = __DIR__ . '/core/commands';

$commandsCore = scandir($pathCommandCore);
$commandsApp = scandir($pathCommandApp);

$commands = [];

$argCommand = isset($argv[1]) ? $argv[1] : '';
$argAction = isset($argv[2]) ? $argv[2] : '';
$argParamOne = isset($argv[3]) ? $argv[3] : '';

foreach ($commandsCore as $command) {
    if ('.' != $command && '..' != $command) {
        $commands[] = strtolower(str_replace('.php', '', str_replace('Cmd', '', $command)));
    }
}

foreach ($commandsApp as $command) {
    if ('.' != $command && '..' != $command) {
        $commands[] = strtolower(str_replace('.php', '', str_replace('Cmd', '', $command)));
    }
}

if (empty($argCommand)) {
    $text = "Добро пожаловать в Lucent Console. Доступны следующие команды: \n";
    foreach ($commands as $command) {
        $text .= '- ' . $command . "\n";
    }

    echo $text;
    die();
}

if (!empty($argCommand)) {
    if (in_array($argCommand, $commands)) {

        $path = $pathCommandCore . '/Cmd' . $argCommand . '.php';
        $namespace = 'core\\commands\\';
        if (!file_exists($path)) {
            $path = $pathCommandApp . '/Cmd' . ucfirst($argCommand) . '.php';
            $namespace = 'core\\commands\\';
        }

        require $path;

        //Правила наименование команды CmdName
        $objName = $namespace . 'Cmd' . ucfirst($argCommand);
        $commandObj = new $objName;
        if (empty($argAction)) {
            $argAction = 'actionIndex';
        } else {
            //правила наименования экшенов actionName
            $argAction = 'action' . ucfirst($argAction);
        }

        if (!empty($argParamOne)) {
            $commandObj::$param = $argParamOne;
        }

        $result = $commandObj->$argAction();

        echo $result;

    } else {
        echo 'Комманда "' . $argCommand . '" не существует' . "\n";
        die();
    }
}




?>