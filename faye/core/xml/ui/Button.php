<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\button as HTMLButton;
use faye\core\xml\html\img as HTMLImage;

class Button extends HTMLButton {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes, $children);

        $this->addClass('ui ui-button');
    }
    
    public function setAttributeIcon ($src) {
        $img = new Image($this->ownerDocument, array('src' => $src));
        
        if ($this->firstChild instanceof HTMLImage) {
            $this->replaceChild($img, $this->firstChild);
        } else {
            $this->prependChild(new \DOMText(' '));
            $this->prependChild($img);
        }
        
        return false;
    }
}