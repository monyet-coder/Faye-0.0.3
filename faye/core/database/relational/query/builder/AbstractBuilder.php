<?php
namespace faye\core\database\query\builder;

use faye\core\database\query\builder\node\Select;
use faye\core\database\query\builder\node\From;
use faye\core\database\query\builder\node\GroupBy;
use faye\core\database\query\builder\node\OrderBy;

use faye\core\collection\ArrayList;

abstract class AbstractBuilder implements BuilderInterface {
    protected
        $select = null,
        $where = null,
        $from = null,
        $groupBy = null,
        $orderBy = null
    ;

    public function __construct () {
        $this->select = new ArrayList;
        $this->where = new ArrayList;
        $this->groupBy = new ArrayList;
        $this->orderBy = new ArrayList;
    }

    public function select ($field) {
        if (count($args = func_get_args()) === 1) {
            if (strpos($field, ' ') !== false) {
                foreach (explode(' ', $field) as $field) {
                    $this->select($field);
                }
            } else {
                $node = new Select($field);

                if (!$this->select->contains($node)) {
                    $this->select->push($node);
                }
            }
        } else {
            foreach($args as $field) {
                $this->select($field);
            }
        }

        return $this;
    }

    public function where ($field, $value = null) {
        $argCount = func_num_args();

        if ($argCount === 1) {
            if (is_array($field)) {

            } else if (is_string($field)) {

            }
        } else {

        }
    }
}