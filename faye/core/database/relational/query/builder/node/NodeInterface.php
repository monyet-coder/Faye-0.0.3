<?php
namespace faye\core\database\query\builder\node;

use faye\core\database\query\builder\BuilderInterface;

class NodeInterface {
    public function build (BuilderInterface $builder);
}