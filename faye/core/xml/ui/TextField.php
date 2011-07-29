<?php
namespace faye\core\xml\ui;

class TextField extends Input {
    protected static $type = self::TEXT;

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes, $children);

        $this->addClass('ui ui-text-field');
    }

    public function setAttributeGhostText ($text) {
        $this->setAttribute('value', $text);
        $this->addClass('ui-ghost-text');
        $this->setData('ghost-text', $text);

        return false;
    }
}