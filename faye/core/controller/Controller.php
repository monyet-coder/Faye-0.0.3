<?php
namespace faye\core\controller;

use faye\core\application\Application;
use faye\core\route\RequestInvoker;

use faye\core\view\View;

abstract class Controller {
    protected
        $app     = null,
        $view    = null,
        $request = null
    ;

    public function __construct (Application $app) {
        $this->app = $app;
        $this->view = new View($app);
        $this->request = $app->getRequest();
    }

    public function forward ($controller, $action = 'index') {
        if (is_string($controller)) {
            $class = 'apps\\' . $this->app->getFolder() . '\\controller\\' . $controller;

            $controller = new $class($this->app);
        }

        $invoker = new RequestInvoker($controller, $action, array_slice(func_get_args(), 2));

        return $invoker->invoke();
    }
}