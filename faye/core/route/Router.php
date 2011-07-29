<?php
namespace faye\core\route;

use faye\core\http\request\URI;
use faye\core\utility\String;
use faye\core\http\request\Request;
use faye\core\application\Application;
use faye\core\controller\Controller;

class Router {
    protected
        $app = null,
        $URI = null,
        $request = null,
        $rerouter = null
    ;

    public function __construct (Application $app, Request $request) {
        $this->app = $app;
        $this->app->setRouter($this);
        $this->request = $this->app->getRequest();
        
        $this->URI = new URI($this->request->getURI());
        $this->rerouter = new Rerouter($this);
    }

    public function getURI () {
        return $this->URI;
    }

    public function getRerouter () {
        return $this->rerouter;
    }

    public function run () {
        $URI = $this->rerouter->getURI();

        $controller = $URI->getSegment(0);
        $controller = 'apps\\' . $this->app->getFolder() . '\\controller\\' . String::pascalize(empty($controller) ? 'index' : $controller);

        $action = $URI->getSegment(1);
        $action = String::camelize(empty($action) ? 'index' : $action);

        if (is_file(SITE_PATH . '/' . String::namespaceToDirectory($controller) . '.php')) {
            $controller = new $controller($this->app);
        } else {
            exit('404');
        }

        try {
            $invoker = new RequestInvoker($controller, $action, $URI->getParameters()->toArray());

            return $invoker->invoke();
        } catch (\Exception $e) {
            $class = 'apps\\app\\controller\\' . $this->app->getConfig()->load('controller')->controller['exception'];

            $invoker = new RequestInvoker(new $class($this->app), 'index', array('e' => $e));

            return $invoker->invoke();
        }
    }
}