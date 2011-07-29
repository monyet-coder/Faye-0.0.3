<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\fieldset as HTMLFieldSet;
use faye\core\xml\html\legend as HTMLLegend;
use faye\core\xml\html\img as HTMLImage;

class GroupBox extends HTMLFieldSet {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes, $children);

        $this->addClass('ui-group-box');
        if ($this->hasAttribute('title')) {
            $legend = new HTMLLegend($doc);

            $legend->appendChild(new \DOMText($this->getAttribute('title')));
            $legend->prependTo($this);

            $this->removeAttribute('title');
        }
        
        if ($this->hasAttribute('icon') and $this->firstChild->nodeName === 'legend') {
            $this->setIcon($this->getAttribute('icon'));
            
            $this->removeAttribute('icon');
        }
    }
    
    public function setIcon ($src) {
        $img = new Image($this->ownerDocument, array('src' => $src));

        $legend = $this->firstChild;
        if ($legend->firstChild instanceof HTMLImage) {            
            $legend->replaceChild($img, $legend->firstChild);
        } else {
            $legend->prependChild(new \DOMText(' '));
            $legend->prependChild($img);            
        }
        
        return $this;
    }
}