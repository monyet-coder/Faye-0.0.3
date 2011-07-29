<?php
namespace faye\core\view\template;

interface ResourceLoader {
    public function addScript ($script);
    public function addScripts (array $scripts = array());

    public function addStyle ($style);
    public function addStyles (array $style = array());
}