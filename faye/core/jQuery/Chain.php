<?php
namespace faye\core\jQuery;

use faye\core\collection\ArrayList;

class Chain {
    protected
        $selector = '', $actions = null
    ;

    public function __construct ($selector) {
        $this->selector = $selector;
        $this->actions = new ArrayList;
    }

    protected function action ($name, array $parameters = array()) {
        $this->actions->push(new Action($name, $parameters));

        return $this;
    }

    public function css ($name, $value = '') {
        return $this->action(__FUNCTION__, func_get_args());
    }

    public function hide () {
        return $this->action(__FUNCTION__);
    }

    public function show () {
        return $this->action(__FUNCTION__);
    }

    public function addClass ($class) {
        return $this->action(__FUNCTION__, array($class));
    }

    public function removeClass ($class) {
        return $this->action(__FUNCTION__, array($class));
    }

    public function toggleClass ($class) {
        return $this->action(__FUNCTION__, array($class));
    }

    public function remove () {
        return $this->action(__FUNCTION__);
    }

    public function append ($content) {
        return $this->action(__FUNCTION__, array($content));
    }

    public function prepend () {
        return $this->action(__FUNCTION__, array($content));
    }

    public function click () {
        return $this->action(__FUNCTION__, func_get_args());
    }
    public function __toString () {
        if (empty($this->selector) or $this->actions->isEmpty()) {
            return '';
        }

        $selector = $this->selector;
        if ($this->selector !== this) {
            $selector = "'{$this->selector}'";
        }

        return sprintf("$(%s).%s;\n", $selector, $this->actions->join('.'));
    }
}
