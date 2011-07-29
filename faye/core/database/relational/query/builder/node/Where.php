<?php
namespace faye\core\database\query\builder\node;

abstract class Where implements NodeInterface {
    protected $field, $value, $operator, $placeholder, $conjunction;

    public function __construct ($arg1, $arg2 = NULL, $conjunction = 'AND') {
        $this->conjunction = $conjunction;

        if (!empty($arg1) and $arg2 === NULL) {
            if (is_array($arg1)) {
                $this->conditions($arg1);
            } else if (is_numeric($arg1)) {
                $this->primaryKey($arg1);
            }
        }
    }

    protected function store ($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }

    protected function conditions (array $conditions) {
        foreach ($conditions as $field => $val) {

        }
    }

    protected function primaryKey ($pk) {
        $this->store ('{{PRIMARY_KEY}}', $pk);
    }
}

abstract class Where implements NodeInterface {
    
}