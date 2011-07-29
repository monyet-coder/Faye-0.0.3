<?php
namespace faye\core\database\entity;

use faye\core\database\query\builder\BuilderInterface;
use faye\core\application\Application as App;

abstract class Entity {
    protected
        $name = '',

        $database = null,
        $builder = null,
        $row = null, $column = null
    ;

    public function __construct ($name) {
        $this->name = $name;

        $this->row = new Row;
        $this->column = new Column;
    }

    public function getName () {
        return $this->name;
    }
}