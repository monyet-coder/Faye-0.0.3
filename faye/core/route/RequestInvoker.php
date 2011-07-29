<?php
namespace faye\core\route;

use faye\core\utility\Func;
use faye\core\controller\Controller;

class RequestInvoker {
    protected
        $controller,
        $action,
        $parameters
    ;

    public function __construct (Controller $controller, $action = 'index', array $parameters = array()) {
        $this->action = $action;
        $this->controller = $controller;
        $this->parameters = $parameters;
    }

    public function __invoke () {
        return $this->invoke();
    }

    public function invoke () {
        return Func::callAssoc(array($this->controller, $this->action), $this->parameters);
    }
}