<?php
namespace faye\core\view\calf;

use faye\core\application\Application;
use faye\core\view\template\EngineInterface;
use faye\core\exception\FileNotFoundException;
use faye\core\exception\FileNotReadableException;

class Calf implements EngineInterface {
    protected
        $app = null
    ;

    public function __construct (Application $app) {
        $this->app = $app;
    }

    public function load ($templateFile, array $vars = array()) {
        $fileName = SITE_PATH . '/apps/' . $this->app->getFolder() . '/view/' . $templateFile;
        if (!is_file($fileName)) {
            throw new FileNotFoundException(sprintf('Template File %s is not exists.', $fileName));
        }

        if (!is_readable($fileName)) {
            throw new FileNotFoundException(sprintf('Template File %s is not readable.', $fileName));
        }

        return new Template($fileName, $vars);
    }
}