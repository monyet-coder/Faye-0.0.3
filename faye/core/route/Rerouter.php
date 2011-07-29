<?php
namespace faye\core\route;

use faye\core\http\request\URI;

class Rerouter {
    protected
        $router = null,
        $reroute = '',
        $URI = null
    ;

    public function __construct (Router $router) {
        $this->router = $router;

        $this->reroute();
    }

    protected function reroute () {
        $this->reroute = $route = $this->router->getURI()->__toString();

        foreach (array() as $pattern => $replace) {
            if (preg_match($pattern, $route)) {
                $this->reroute = preg_replace($pattern, $replace, $route);

                break;
            }
        }

        $this->URI = new URI($this->reroute);
    }

    public function getURI () {
        return $this->URI;
    }
}