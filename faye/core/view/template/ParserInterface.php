<?php
namespace faye\core\view\template;

interface ParserInterface {
    public function parse (ContentInterface $content, array $vars = array());
}