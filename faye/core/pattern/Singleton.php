<?php
namespace faye\core\pattern;

abstract class Singleton {
    protected static $instance;

    protected function __construct () {}
    protected function __clone () {}

    public static function getInstance () {
        if (empty(static::$instance)) {
            $reflector = new \ReflectionClass(get_called_class());

            static::$instance = $reflector->newInstanceArgs(func_get_args());
        }

        return static::$instance;
    }
}