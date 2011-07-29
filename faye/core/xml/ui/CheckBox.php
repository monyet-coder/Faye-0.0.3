<?php
namespace faye\core\xml\ui;

class CheckBox extends Input {
    protected static $type = self::CHECK;

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes, $children);

        $this->addClass('ui-check-box');
    }

    public function setAttributeLabel ($label) {
        #$this->after(new Label($this->ownerDocument, array(), array(new \DOMText($label))));
        $label = new Label($this->ownerDocument, array(), array(new \DOMText($label)));

        $this->after($label);
        $label->appendChild($this);

        return false;
    }
}