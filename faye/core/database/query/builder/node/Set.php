<?php
namespace faye\core\database\query\builder\node;

class Set extends AbstractNode {
    public function __construct ($field, $value) {
        parent::__construct (array('field' => $field, 'value' => $value));
    }
}