<?php
namespace faye\core\database\relational\entity;

abstract class Entity {
    protected
        $name = '',
        $primaryKey = '';

    public function __construct () {

    }

    public function getName () {
        return $this->name;
    }

    public function getPrimaryKey () {
        return $this->primaryKey;
    }
}