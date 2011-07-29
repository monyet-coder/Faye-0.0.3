<?php
namespace faye\core\xml\html;

use faye\core\xml\selector\css\Selector;
use faye\core\xml\html\Crawler;
use faye\core\xml\html\Fragment;

class Document extends \DOMDocument {
    protected $xpath = null;

    public function __construct ($version = '1.0', $encoding = 'UTF-8') {
        parent::__construct($version, $encoding);
    }

    public function __invoke ($selector, \DOMNode $context = null) {
        $selector = new Selector($selector);

        return $this->xpath($selector->getXPath(), $context);
    }

    public function xpath ($query, \DOMNode $context = null) {
        if (empty($this->xpath)) {
            $this->xpath = new \DOMXPath($this);
        }

        $nodes = array();
        foreach($this->xpath->query($query, $context === null ? $this->documentElement : $context) as $node) {
            $nodes[] = $node;
        }

        return new Crawler($nodes);
    }

    public function saveXML (\DOMNode $node = null, $options = null) {
        $this('span.dom-fragment')->each(function ($node, $i) {
            while($node->firstChild) {
                $node->parentNode->insertBefore($node->firstChild, $node);
            }
            $node->parentNode->removeChild($node);
        });

        return '<' . \ltrim(parent::saveXML($node, $options), '<?xml version="1.0"?>' . "\n");
    }

    public function __toString () {
        return $this->saveHTML();
    }
}