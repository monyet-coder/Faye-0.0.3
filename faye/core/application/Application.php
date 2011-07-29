<?php
namespace faye\core\application;

use faye\core\config\Config;
use faye\core\http\request\Request;
use faye\core\route\Router;
use faye\core\pattern\Multiton;

class Application extends Multiton {
    protected static $instance = null;
    protected
        $path = '',
        $name = '',
        $folder = '',

        $registry = null
    ;

    protected function __construct ($folder, $name = '') {
        $this->path = SITE_PATH . '/apps/' . $folder;
        $this->name = empty($name) ? $folder : $name;
        $this->folder = $folder;

        $this->registry = new Registry;
        $this->registry->set('config', new Config($this));
    }

    protected function __clone () {}

    public static function getInstance ($folder, $name = '') {
        static $apps = array();

        if (empty($apps[$folder])) {
            $apps[$folder] = new static ($folder, $name);
        }

        return $apps[$folder];
    }

    public function __call ($method, array $args = array()) {
        $type = substr($method, 0, 3);
        $key = lcfirst(substr($method, 3));

        if ($type === 'set') {
            return $this->registry->set($key, $args[0]);
        } else if ($type === 'get') {
            return $this->registry->get($key);
        }

        throw new \Exception(sprintf('Call to undefined method %s::%s()', __CLASS__, $method));
    }

    public function getFolder () {
        return $this->folder;
    }

    public function setName ($name) {
        $this->name = $name;

        return $this;
    }

    public function getName () {
        return $this->name;
    }

    public function getDatabase () {
        $db = $this->__call(__FUNCTION__);

        if (empty($db)) {
            $db = new Database;

            $this->setDatabase($db);
        }

        return $db;
    }

    public function run () {
        $request  = new Request($this);
        $router   = new Router($this, $request);
        $rerouter = $router->getRerouter();

        $router->run();
    }
}