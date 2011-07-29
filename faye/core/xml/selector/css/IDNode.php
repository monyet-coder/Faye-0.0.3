<?php
namespace faye\core\xml\selector\css;

class IDNode extends AttributeNode {
    protected
        $id,
        $selector;
    
    public function __construct ($selector, $id) {
        $this->id = $id;
        $this->selector = $this->selector;
        
        parent::__construct ($selector, array('id', '=', $id));
    }
    
    public function __toString () {
        return '#' . $this->id;
    }
}