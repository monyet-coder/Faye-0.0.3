<?php
namespace faye\core\xml\selector\css;

use faye\core\collection\Collection;

class CSS {
    const PATTERN = '/([\w-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w-]+)(?:([!*^$]?=)["\']?(.*?)["\']?)?\])?([\/, >]+)/is';
    
    protected
        $nodes = array(),
        $selector = '',
        $prefix = '',
        $xpath = '';
    
    public function __construct ($selector, $prefix = '//') {
        $this->selector = $selector;
        $this->prefix = $prefix;
        
        $this->parse();
    }
    
    protected function parse() {
        if(preg_match_all(self::PATTERN, trim($this->selector) . ' ', $matches, PREG_SET_ORDER)) {
            foreach ($matches as $comp) {
                $this->nodes[] = new Node($comp);
            }

            return true;
        }
    }
    
    public function getXPath () {
        if (empty($this->xpath)) {            
            foreach ($this->nodes as $node) {
                $this->xpath .= $this->prefix . $node->getXPath();
            }
        }

        return rtrim($this->xpath, '/');
    }
    
    public function __toString () {
        return $this->selector;
    }
}