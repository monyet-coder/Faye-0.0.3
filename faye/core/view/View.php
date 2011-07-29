<?php
namespace faye\core\view;

use faye\core\application\Application;
use faye\core\utility\String;
use faye\core\collection\ArrayList;
use faye\core\view\template\ResourceLoader;

class View implements ResourceLoader {
    protected
        $app = null,
        $drivers = array(),

        $styles = null, $scripts = null
    ;

    public function __construct (Application $app) {
        $this->app = $app;

        $config = $app->getConfig();
        $config->load('resource');

        $this->styles = new ArrayList($config->resource['styles']);
        $this->scripts = new ArrayList($config->resource['scripts']);
    }

    public function addStyle ($style) {
        $this->styles->push($style);

        return $this;
    }

    public function addStyles (array $styles = array()) {
        foreach ($styles as $style) {
            $this->addStyle($style);
        }

        return $this;
    }

    public function addScript ($script) {
        $this->scripts->push($script);

        return $this;
    }

    public function addScripts (array $scripts = array()) {
        foreach ($scripts as $script) {
            $this->addScript($script);
        }

        return $this;
    }

    /**
     *
     * @param $driver Driver name of template engine.
     * @return TemplateEngineInterface
     */
    protected function getDriver ($driver) {
        if (!isset($this->drivers[$driver])) {
            $class = 'faye\\core\\view\\' . strtolower($driver) . '\\' . String::pascalize($driver);

            $this->drivers[$driver] = new $class($this->app);
        }

        return $this->drivers[$driver];
    }

    /**
     * @return TemplateInterface
     */
    public function load ($file, $driver = 'native') {
        return $this->getDriver($driver)->load($file, array('styles' => $this->styles->toArray(), 'scripts' => $this->scripts->toArray()));
    }
}