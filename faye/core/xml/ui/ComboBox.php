<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\select as HTMLSelect;
use faye\core\xml\html\option as HTMLOption;

class ComboBox extends HTMLSelect {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes, $children);

        $this->addClass('ui ui-combo-box');
    }

    public function setAttributeOptions (array $options) {
        foreach ($options as $value => $text) {
            $this->appendChild(new HTMLOption($this->ownerDocument, array('value' => $value), array($text)));
        }

        return false;
    }
}