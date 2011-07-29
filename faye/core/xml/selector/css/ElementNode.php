<?php
namespace faye\core\xml\selector\css;

class ElementNode implements NodeInterface {
    protected
        $xpath,
        $nodeName,
        $selector;
    
    public function __construct ($selector, $nodeName) {
        $this->nodeName = $nodeName;
        $this->selector = $this->selector;
    }
    
    public function getXPath () {
        if (empty($this->xpath)) {
            switch (trim(strtolower($this->nodeName))) {
                case '':
                case '*':
                case NULL:
                    $this->xpath = '*';
                    
                    break;
                default:
                    $this->xpath = $this->nodeName;
                    
                    break;
            }
        }
        
        return $this->xpath;
    }
    
    public function __toString () {
        return $this->nodeName;
    }
}
