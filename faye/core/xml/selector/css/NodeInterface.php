<?php
namespace faye\core\xml\selector\css;

interface NodeInterface {
    public function getXPath ();
    public function __toString ();
}