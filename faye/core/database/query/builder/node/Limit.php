<?php
namespace faye\core\database\query\builder\node;

class Limit extends AbstractNode {
    public function __construct ($offset, $limit) {
        parent::__construct (array('offset' => $offset, 'limit' => $limit));
    }
}