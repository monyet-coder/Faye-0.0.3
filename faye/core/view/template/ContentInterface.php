<?php
namespace faye\core\view\template;

interface ContentInterface {
    public function getContent ();
    public function setContent ($content);
    public function __toString ();
}
