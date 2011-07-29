<?php
namespace faye\core\database;

use faye\core\application\Application;

class ConnectionManager {
    protected
        $app = null,
        $currentConnection = '',
        $connectionPool = null;

    public function __construct (Application $app) {
        $this->app = $app;
        $this->connectionPool = new ConnectionPool;
    }

    public function getConnection ($key = null) {
        $DBConfig = $this->app->getConfig()->load('database')->database;

        if (empty($key)) {
            if (!empty($this->currentConnection)) {
                $key = $this->currentConnection;
            } else {
                $key = $DBConfig['active'];
            }
        }

        if (($connection = $this->connectionPool->get($key)) === null) {
            $DBConfig = $DBConfig[$key];

            $connection = $this->establish($DBConfig);

            $this->connectionPool->set($key, $connection);
        }

        return $connection;
    }

    public function establish (array $config) {
        static $classMap = array(
            'mysql' => 'faye\\core\\database\\sql\\mysql\\MySQL',

            'mongo' => 'faye\\core\\database\\nosql\\mongo\\Mongo',
        );

        $class = $classMap[$config['driver']['name']];

        return new $class($config);
    }
}