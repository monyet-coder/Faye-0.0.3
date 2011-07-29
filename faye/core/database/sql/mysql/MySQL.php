<?php
namespace faye\core\database\sql\mysql;

use faye\core\database\sql\Connection;

class MySQL extends Connection {
    public function __construct (array $config) {
        parent::__construct(array('driver' => array(
            'name' => 'mysql',
            'type' => 'sql')
        ) + $config);
    }
}