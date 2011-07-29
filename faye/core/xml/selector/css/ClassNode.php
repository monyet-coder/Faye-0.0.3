<?php
namespace faye\core\xml\selector\css;

class ClassNode extends AttributeNode {
    protected
        $xpath,
        $selector,
        $className;
    
    public function __construct ($selector, $className) {
        $this->selector = $selector;
        $this->className = $className;
        
        parent::__construct ($selector, array('class', '~=', ' ' . $className . ' '));
    }
    
    public function __toString () {
        return '.' . $this->className;
    }
}