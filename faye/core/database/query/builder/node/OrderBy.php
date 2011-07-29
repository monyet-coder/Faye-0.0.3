<?php
namespace faye\core\database\query\builder\node;

class OrderBy extends AbstractNode {
    public function __construct ($name) {
        parent::__construct (array('name' => $name));
    }
}