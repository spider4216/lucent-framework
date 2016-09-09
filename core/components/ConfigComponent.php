<?php

namespace core\components;


class ConfigComponent
{
    private $configs = [];

    public function setConfig(string $name)
    {
        $path = __DIR__ . '/../../app/configs/' . $name . '.json';

        if (!file_exists($path)) {
            throw new \Exception('Config does not exist');
        }

        $content = file_get_contents($path);

        $conf = json_decode($content, true);

        $this->configs[$name] = $conf;
    }

    public function getConfig(string $name):array
    {
        return $this->configs[$name] ?? [];

    }
}