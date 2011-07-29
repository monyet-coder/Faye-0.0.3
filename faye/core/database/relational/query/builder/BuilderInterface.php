<?php
namespace faye\core\database\query\builder;

interface BuilderInterface {
    public function select ();
    public function insert ();
    public function update ();
    public function set ($field, $value = NULL);
    public function delete ();
    public function avg ();
    public function sum ();
    public function max ();
    public function min ();
    public function from ();
    public function where ($arg1, $arg2 = NULL, $conjunction = 'AND');
    public function orWhere ($arg1, $arg2 = NULL);
    public function groupBy ();
    public function asc ();
    public function desc ();
    public function orderBy ();
    public function offset ($offset);
    public function limit ($limit);
    public function reset ();
}