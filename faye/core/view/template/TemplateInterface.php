<?php
namespace faye\core\view\template;

interface TemplateInterface extends ResourceLoader {
    public function __construct ($file, array $vars = array());
    public function import (TemplateInterface $template, $position = null);
    public function render ();
    public function __toString ();
}