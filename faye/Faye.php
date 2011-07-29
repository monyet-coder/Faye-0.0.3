<?php
namespace faye;

use faye\core\application\Application as App;

class Faye {
    public static function init () {
        foreach (self::initFiles() as $file) {
            require $file;
        }

        $app = App::getInstance('app', 'Tutorial');

        $app->run();
    }

    public static function initFiles () {
        return array(
            SITE_PATH . '/faye/core/autoload/Autoload.php',
        );
    }
}