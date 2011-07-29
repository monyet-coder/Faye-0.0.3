<?php
namespace faye\core\database\query\builder;

interface BuilderInterface {
    const
        ASCENDING  = 'ASC',
        DESCENDING = 'DESC',

        OPEN_QUOTE = '',
        CLOSE_QUOTE = '',

        TRUE = '1',
        FALSE = '0',

        DATETIME_FORMAT = 'Y-m-d H:i:s',

        SELECT_QUERY = 0,
        DELETE_QUERY = 1,
        UPDATE_QUERY = 2
    ;

    public function select ();
    public function insert (array $data);
    public function update ();
    public function set ($fields, $value = NULL);
    public function delete ();
    public function where ($fields, $value = NULL, $conjunction = 'AND');
    public function orWhere ($fields, $value = NULL);
    public function groupBy ();
    public function asc ();
    public function desc ();
    public function orderBy ();
    public function offset ($offset);
    public function limit ($limit);
    public function reset ();
    public function getTree ();
    public function __toString ();
}