<?php
namespace faye\core\view\template;

interface EngineInterface {
    public function load ($templateFile, array $vars = array());
}