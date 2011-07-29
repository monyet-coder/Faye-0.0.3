<?php
namespace faye\core\xml\selector\css;

class Node implements NodeInterface {
    protected    
        $selector,
        $nodeName,
        $id,
        $class,
        $attribute,
        $combinator
    ;

    public function __construct (array $nodes) {
        $this->selector   = $nodes[0];
        
        $this->nodeName   = new ElementNode ($this->selector, $nodes[1]);
        $this->id         = new IDNode ($this->selector, $nodes[2]);
        $this->class      = new ClassNode ($this->selector, $nodes[3]);
        $this->attribute  = new AttributeNode ($this->selector, array_slice($nodes, 4, 3));
        $this->combinator = new CombinatorNode($this->selector, $nodes[7]);
    }
    
    public function getXPath () {
        if (empty($this->xpath)) {
            $this->xpath = implode (array(
                $this->nodeName->getXPath(),
                $this->id->getXPath(),
                $this->class->getXPath(),
                $this->attribute->getXPath(),
                $this->combinator->getXPath()
            ));
        }
        
        return $this->xpath;
    }
    
    public function __toString () {
        return $this->selector;
    }
}