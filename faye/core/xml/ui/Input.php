<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\input as HTMLInput;

abstract class Input extends HTMLInput {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes, $children);

        $this->addClass('ui-input');
    }
}