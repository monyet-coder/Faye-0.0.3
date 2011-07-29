<?php
namespace faye\core\pattern;

abstract class Multiton {
    protected static $instances = array();

    protected function __construct () {}
    protected function __clone () {}

    public static function getInstance ($key) {
        if (empty(static::$instances[$key])) {
            $args = func_get_args();
            $key = array_pop($args);

            $reflector = new \ReflectionClass(get_called_class());

            static::$instances[$key] = $reflector->newInstanceArgs($args);
        }

        return static::$instances[$key];
    }
}