<?php
namespace faye\core\database\query\builder\node;

abstract class AbstractNode implements NodeInterface {
    protected
        $type = ''
    ;

    public function __toString () {
        return $type . ':' . $value;
    }
}