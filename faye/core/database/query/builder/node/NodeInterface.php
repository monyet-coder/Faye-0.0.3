<?php
namespace faye\core\database\query\builder\node;

interface NodeInterface {
    public function __construct (array $node = array(), array $attributes = array());
    public function __toString ();
}