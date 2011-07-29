<?php
namespace faye\core\database\query\builder\node;

class Field extends AbstractClass {
    public function __construct ($name, $alias = null, $aggregate = null) {
        $attributes = array();

        $alias !== null and $attributes['alias'] = $alias;
        $aggregate !== null and $attributes['aggregate'] = $aggregate;

        parent::__construct (array('name' => $name), $attributes);
    }
}