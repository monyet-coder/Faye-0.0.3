<?php
namespace faye\core\xml\ui;

class Typeahead extends TextField {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes, $children);
        
        $this->addClass('ui-typeahead');
    }
    
    public function setAttributeSource ($source) {
        if (is_array($source)) {
            $this->setData('source', $source);
        }
        
        return false;
    }    
}