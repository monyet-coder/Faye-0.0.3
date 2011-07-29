<?php
namespace faye\core\collection;

require __DIR__.DS.'ArrayList.php';
require __DIR__.DS.'CollectionInterface.php';

class Collection extends ArrayList implements CollectionInterface {
    public static function isValidKey ($key) {
        return !is_object($key) and !is_array($key);
    }

    public function sort ($argument = NULL) {
        $function = 'asort';
        $flag = SORT_REGULAR;
        if(is_callable($argument)) {
            $function = 'uasort';
        } else if(is_numeric($argument)) {
            if($argument & self::SORT_KEY) {
                $function = 'ksort';
            }

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

    public function keys () {
        return new ArrayList(array_keys($this->_list));
    }
}