<?php
namespace faye\core\model;

use faye\core\database\entity\Entity;

abstract class Model extends Entity implements ModelInterface {
    public function __construct () {
        parent::__construct (get_class($this));
    }

    public function __toString () {
        return sprintf('%s: %s', __CLASS__, $this->name);
    }
}