<?php

namespace core\components;

use core\system\Lucent;

use Packages\PHPDAO\DAOFactories\MySQLDAOFactory;
use Packages\PHPDAO\DAOFactory;

class DAOComponent
{
    private $generator;

    public function createGenerator(int $genNum):DAOComponent
    {
        $this->generator = DAOFactory::initial($genNum);

        if (DAOFactory::MYSQL == $genNum) {
            $this->mysql($this->generator);
        }

        return $this;

    }

    public function getDaoObject(string $name)
    {
        if (!method_exists($this->generator, $name)) {
            throw new \Exception('DAO object does not exist');
        }

        return $this->generator->$name();
    }

    private function mysql(MySQLDAOFactory $generator)
    {
        $config = Lucent::$app->components->config->getConfig('main')['database'];

        $generator->setHost($config['host']);
        $generator->setDbName($config['dbname']);
        $generator->setUsername($config['username']);
        $generator->setPassword($config['password']);
        $generator->createConnection();
    }
}