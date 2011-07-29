<?php
namespace faye\core\file;

interface FileInterface {
    public function read ();
    public function write ($data, $append = false);
    public function truncate ();
    public function delete ();
    public function save ();
    public function getSize ();
    public function getDirectory ();
    public function getExtension ();
    public function getMIME ();
    public function getLastAccess ();
    public function getLastModified ();
    public function getContent ();
    public function copyTo ($path);
    public function cutTo ($path);
}