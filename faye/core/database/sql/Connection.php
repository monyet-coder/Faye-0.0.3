<?php
namespace faye\core\database\sql;

use faye\core\database\ConnectionInterface;

class Connection extends \PDO implements ConnectionInterface {
    protected
        $dsn      = '',
        $host     = '',
        $port     = '',
        $name     = '',
        $driver   = '',
        $username = '',
        $password = ''
    ;

    public function __construct (array $config) {
        $this->driver = $config['driver']['name'];
        $this->host = $config['host'];
        $this->name = $config['name'];
        $this->port = isset($config['port']) ? $config['port'] : '';
        $this->username = $config['username'];
        $this->password = $config['password'];

        switch(strtolower($this->driver)) {
            case 'mysql':
                $this->dsn = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->name);
            break;

            case 'pgsql':
            case 'postgre':
            case 'postgresql':
                $this->dsn = sprintf('pgsql:host=%s;dbname=%s', $this->host, $this->name);
            break;

            case 'oci':
            case 'ora':
            case 'oracle':
                $this->dsn = sprintf('oci:dbname=%s/%s', $this->host, $this->name);
            break;

            case 'mssql':
            case 'dblib':
            case 'sqlserver':
                $this->dsn = sprintf('dblib:host=%s;dbname=%s', $this->host, $this->name);
            break;

            case 'sqlite':
                $this->dsn = sprintf('sqlite:%s', $this->host);
            break;

            case 'sybase':
                $this->dsn = sprintf('sybase:host=%s;dbname=%s', $this->host, $this->name);
            break;

            case 'ibm':
            case 'db2':
                $this->dsn = sprintf('ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=%s;HOSTNAME=%s;PORT=%s;PROTOCOL=TCPIP', $this->name, $this->host, $this->port);
            break;
        }

        parent::__construct($this->dsn, $this->username, $this->password);

        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}
