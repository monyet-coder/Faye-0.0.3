<?php
namespace faye\core\database\query\builder\node;

abstract class AbstractNode implements NodeInterface {
    protected $nodes = array(), $attributes = array();

    public function __construct (array $nodes = array(), array $attributes = array()) {
        $this->nodes = $nodes;
        $this->attributes = $attributes;
    }
}