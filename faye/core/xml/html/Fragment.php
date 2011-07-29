<?php
namespace faye\core\xml\html;

abstract class Fragment extends span {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes, $children);

        $this->addClass('dom-fragment');
    }
}