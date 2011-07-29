<?php
namespace faye\core\database\query\builder\node;

class Select extends AbstractNode {
    public function __construct (array $fields, $distinct = false) {
        parent::__construct ($fields, ($distinct ? array('distinct' => 'DISTINCT') : array()));
    }
}
