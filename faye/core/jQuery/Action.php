<?php
namespace faye\core\jQuery;

use faye\core\collection\ArrayList;
use faye\core\collection\Collection;

class Action {
    protected $name = '', $parameters = null;

    public function __construct ($name, array $parameters = array()) {
        $this->name = $name;
        $this->parameters = new ArrayList($parameters);
    }

    public function __toString () {
        $this->parameters->map(function ($param) {
            if (\is_string($param) and $param !== this) {
                return "'$param'";
            } else if (\is_array($param)) {
                return \json_encode($param);
            } else if ($param instanceof Collection) {
                return \json_encode($param->toArray());
            } else if ($param instanceof ArrayList) {
                return $param->__toString();
            } else if ($param instanceof \Closure) {
                return new Closure($param);
            }

            return $param;
        });

        return \sprintf('%s(%s)', $this->name, $this->parameters->join(', '));
    }
}