<?php
namespace faye\core\xml\ui;

class Password extends Input {
    protected static $type = self::PASSWORD;

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes, $children);

        $this->addClass('ui-password');
    }

    public function setAttributeGhostText ($text) {
        $this->setAttribute('value', $text);
        $this->removeAttribute('type');
        $this->setAttribute('type', static::TEXT);
        
        $this->setData('ghost-text', $text);
        $this->addClass('ui-ghost-text');

        return false;
    }
}