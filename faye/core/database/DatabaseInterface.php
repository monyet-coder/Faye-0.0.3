<?php
namespace faye\core\database;

interface DatabaseInterface {
    public function getConnection ($key = null);
    public function query ();
    public function beginTransaction ();
    public function rollbackTransaction ();
    public function commitTransaction ();
}
