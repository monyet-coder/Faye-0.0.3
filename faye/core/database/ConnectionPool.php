<?php
namespace faye\core\database;

use faye\core\collection\Collection;

class ConnectionPool extends Collection {
    public static function isValid($element) {
        return parent::isValid($element) and $element instanceof ConnectionInterface;
    }
}