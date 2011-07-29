<?php
namespace faye\core\collection;

interface ListInterface extends \ArrayAccess, \IteratorAggregate, \Countable, \Serializable {
    const
        SORT_STRING     = 1,
        SORT_NUMERIC    = 2,
        SORT_DESCENDING = 4;

    public function __construct (array $elements = array());

    public static function isValid ($element);
    public static function isValidKey ($key);

    public function clear ();

    public function pop ();
    public function push ($element);
    public function shift ();
    public function unshift ($element);

    public function removeElement ($element);
    public function removeKey ($key);

    public function contains ($element);
    public function containsKey ($key);

    public function merge (ListInterface $coll);
    public function unique ();
    public function reverse ();
    public function shuffle ();
    public function intersect (ListInterface $coll);
    public function slice ($offset, $length = NULL);
    public function chunk ($size);
    public function sort ($flag = NULL);

    public function filter ($callback);
    public function map ($callback);
    public function reduce ($callback, $init = NULL);

    public function join ($glue = null);

    public function get ($key);
    public function set ($key, $element);

    public function toArray ();

    public function __toString ();
}