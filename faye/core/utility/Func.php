<?php
namespace faye\core\utility;

class Func {
    /**
     *
     * @param Callback $callback
     * @return \ReflectionFunction
     */
    public static function getReflector ($callback) {
        if(!is_callable($callback)) {
            throw new \InvalidArgumentException(sprintf('Callback isn\'t callable, %s given.', gettype($callback)));
        }

        // If it's an array then the
        // callback is a method.
        if(is_array($callback) or (is_string($callback) and strpos($callback, '::'))) {
            list($class, $method) = $callback;

            $reflector = new \ReflectionMethod($class, $method);
        // if it's a string contains double
        // colon, then the callback is a
        // static method.
        } else if (is_string($callback) and strpos($callback, '::')) {
            list($class, $method) = explode('::', $callback);

            $reflector = new \ReflectionMethod($class, $method);
        // else, it's a string of function name
        // or a closure.
        } else {
            $reflector = new \ReflectionFunction($callback);
        }

        return $reflector;
    }

    public static function getParameters($callback) {
        if(!is_callable($callback)) {
            throw new InvalidArgumentException(sprintf('Callback isn\'t callable, %s given.', gettype($callback)));
        }

        return self::getReflector($callback)->getParameters();
    }

    public static function callAssoc($callback, $parameters) {
        if(!is_callable($callback)) {
            throw new \InvalidArgumentException(sprintf('Callback isn\'t callable, %s given.', gettype($callback)));
        }

        $reflector = self::getReflector($callback);

        // Iterate over the parameters of callback
        // see if the parameter name is exists
        // on the $callParams array.
        $params = $names = array();
        foreach(self::getParameters($callback) as $param) {
            $name = $param->getName();
            $value = isset($parameters[$name]) ? $parameters[$name] : null;
            $names[] = '$' . $name;

            if(empty($value)) {
                if($param->isOptional()) {
                    continue;
                } else {
                    $method = is_array($callback) ? sprintf('%s::%s', get_class($callback[0]), $callback[1]) : $reflector->getName();

                    throw new \InvalidArgumentException(sprintf('Missing argument %d for %s(%s, ...)', $param->getPosition() + 1, $method, implode(', ', $names)));
                }
            } else {
                $params[] = $value;
            }
        }

        return empty($params) ? call_user_func($callback) : \call_user_func_array($callback, $params);
    }

    public static function callStatic ($method) {
        $parameters = array_slice(func_get_args(), 1);

        return self::getReflector($method)->invokeArgs($parameters);
    }
}