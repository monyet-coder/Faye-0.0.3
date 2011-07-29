<?php
namespace faye\core\collection;

defined('faye\core\collection\_') or define('faye\core\collection\_', 2);

require __DIR__.'/ListInterface.php';

class ArrayList implements ListInterface {
    protected static $reducer = array ();
    protected $_list = array();

    public function __construct (array $elements = array()) {
        foreach ($elements as $element) {
            $this->push($element);
        }
    }

    public static function range ($start, $limit, $step = 1) {
        return new static(range($start, $limit, $step));
    }

    public static function registerReducer($name, $callback, $init = null) {
        self::$reducer[$name] = compact('callback', 'init');
    }

    public static function isValid ($element) {
        return true;
    }

    public static function isValidKey ($key) {
        return is_numeric($key);
    }

    public function clear () {
        $this->_list = array();

        return $this;
    }

    public function isEmpty () {
        return empty($this->_list);
    }

    public function push ($element) {
        if(static::isValid($element)) {
            $this->_list[] = $element;
        } else {
            throw new \InvalidArgumentException(sprintf('Fail to push, invalid element specified ($element: %s). ', gettype($element)));
        }

        return $this;
    }

    public function pop () {
        if ($this->count() <= 0) {
            throw new \Exception(sprintf('The %s is empty.', get_class($this)));
        }

        return array_pop($this->_list);
    }

    public function shift () {
        if ($this->count() <= 0) {
            throw new \Exception(sprintf('The %s is empty.', get_class($this)));
        }

        return array_shift($this->_list);
    }

    public function unshift ($element) {
        if (static::isValid($element)) {
            array_unshift($this->_list, $element);
        } else {
            throw new \InvalidArgumentException(sprintf('Fail to unshift, invalid type of element specified ($element: %s). ', gettype($element)));
        }

        return $this;
    }

    public function removeElement ($element) {
        $this->_list = array_diff($this->_list, is_object($element) ? array($element) : (array)$element);

        return $this;
    }

    public function removeKey ($key) {
        unset ($this->_list[$key]);

        return $this;
    }

    public function sort ($argument = null) {
        $function = 'asort';
        $flag = SORT_REGULAR;
        if(is_callable($argument)) {
            $function = 'uasort';
        } else if(is_numeric($argument)) {
            if($argument & self::SORT_DESCENDING) {
                $function = preg_replace('/(\w)*sort/', '\1rsort', $function);
            }

            if($argument & self::SORT_STRING) {
                $flag = SORT_STRING;
            } else if($argument & self::SORT_NUMERIC) {
                $flag = SORT_NUMERIC;
            }
        }

        $function($this->_list, $flag);

        return $this;
    }

    public function chunk ($size) {
        $chunks = new ArrayList(array_chunk($this->_list, $size));

        return $chunks->map(function ($chunk) {
                return new ArrayList($chunk);
            });
    }

    public function contains ($element) {
        if(!in_array($element, $this->_list)) {
            return false;
        }

        return true;
    }

    public function containsKey ($key) {
        return isset($this->_list[$key]);
    }

    public function unique () {
        $this->_list = array_unique($this->_list);

        return $this;
    }

    public function reverse () {
        $this->_list = array_reverse($this->_list);

        return $this;
    }

    public function shuffle () {
        shuffle($this->_list);

        return $this;
    }

    public function merge (ListInterface $list) {
        $this->_list = array_merge($this->_list, $list->toArray());

        return $this;
    }

    public function each ($callback) {
        if(!is_callable($callback)) {
            throw new Exception(sprintf('The callback passed to %s isn\'t callable.', __METHOD__));
        }

        foreach ($this->_list as $i => $element) {
            $callback($element, $i);
        }

        return $this;
    }

    public function map ($callback) {
        if(!is_callable($callback)) {
            throw new Exception(sprintf('The callback passed to %s isn\'t callable.', __METHOD__));
        }

        return new static(array_map($callback, $this->_list));
    }

    public function reduce ($callback, $init = null) {
        if(empty(self::$reducer)) {
            self::$reducer = array(
                _+_ => array(
                    'callback' => function ($sum, $el) { return $sum += $el; }
                ),
                _*_ => array(
                    'callback' => function ($sum, $el) { return $sum *= $el; },
                    'init' => 1
                ),
                _._ => array(
                    'callback' => function ($sum, $el) { return $sum .= $el; }
                ),
            );
        }

        if(is_string($callback) and isset(self::$reducer[$callback])) {
            $init = (empty($init) and !empty(self::$reducer[$callback]['init'])) ? self::$reducer[$callback]['init'] : $init;

            $callback = self::$reducer[$callback]['callback'];
        }

        if(!is_callable($callback)) {
            throw new Exception(sprintf('The callback passed to %s isn\'t callable.', __METHOD__));
        }

        return array_reduce($this->_list, $callback, $init);
    }

    public function filter ($callback) {
        if(!is_callable($callback)) {
            throw new Exception(sprintf('The callback passed to %s isn\'t callable.', __METHOD__));
        }

        $this->_list = array_filter($this->_list, $callback);

        return $this;
    }

    public function intersect (ListInterface $list) {
        $this->_list = array_intersect($this->_list, $list->toArray());

        return $this;
    }

    public function slice ($offset, $length = null) {
        $this->_list = array_slice($this->_list, $offset, $length, true);

        return $this;
    }

    public function join ($glue = null) {
        return implode($glue, $this->_list);
    }

    public function get ($offset) {
        if(is_string($offset)) {
            return $this->containsKey($offset) ? $this->_list[$offset] : null;
        }

        if ($this->count() === 1) {
            if ($offset === 0) {
                return $this->_list[0];
            }

            return null;
        }

        return $this->isEmpty() ? null : $this->_list[(($count = $this->count()) + $offset % $count) % $count];
    }

    public function set ($key, $element) {
        if($key === null) {
            $this->push ($element);
        } else if (static::isValidKey($key)) {
            $this->_list[$key] = $element;
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid key specified expecting integer, %s given.', gettype($key)));
        }

        return $this;
    }

    public function toArray () {
        return $this->_list;
    }

    public function count () {
        return count($this->_list);
    }

    public function offsetExists ($offset) {
        return $this->containsKey($offset);
    }

    public function offsetUnset ($offset) {
        unset($this->_list[$offset]);
    }

    public function offsetSet ($offset, $value) {
        return $this->set($offset, $value);
    }

    public function offsetGet ($offset) {
        return $this->get($offset);
    }

    public function getIterator () {
        return new \ArrayIterator($this->_list);
    }

    public function serialize () {
        return serialize ($this->_list);
    }

    public function unserialize ($serialized) {
        $this->_list = unserialize($serialized);
    }

    public function __toString() {
        return sprintf('[%s]', implode(', ', $this->_list));
    }
}