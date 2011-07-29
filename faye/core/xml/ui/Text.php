<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\span as HTMLSpan;

class Text extends HTMLSpan {
    protected static $nodeName = 'span';

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes, $children);

        $this->addClass('ui-text');
    }
}