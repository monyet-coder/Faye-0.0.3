<?php
namespace faye\core\config;

use faye\core\application\Application;

class Config {
    protected
        $app = null,
        $configs = array()
    ;

    public function exists ($name) {
        return is_file(SITE_PATH . '/apps/' . $this->app->getFolder() . '/config/' . $name . '.php');
    }

    public function __construct (Application $app) {
        $this->app = $app;
    }

    public function load ($name) {
        if (!isset($this->configs[$name]) and static::exists($name)) {
            $config = include (SITE_PATH . '/apps/' . $this->app->getFolder() . '/config/' . $name . '.php');

            $this->configs[$name] = $config;

            return $this;
        }

        throw new \Exception('Config file can\'t be found or read for inclusion.');
    }

    public function get ($name) {
        if (!isset($this->configs[$name])) {
            return $this->load($name)->get($name);
        }

        return $this->configs[$name];
    }

    public function __get ($name) {
        return $this->get($name);
    }
}
