<?php
namespace faye\core\xml\selector\css;

class CombinatorNode implements NodeInterface {
    protected
        $xpath,
        $selector,
        $combinator;

    public function __construct ($selector, $combinator) {
        $this->selector = $selector;
        $this->combinator = $combinator;
    }

    public function getXPath () {
        if (empty($this->xpath)) {
            switch (trim($this->combinator)) {
                case ',':
                    $this->xpath = '|';

                    break;
                case '>':
                    $this->xpath = '/';

                    break;
                case '':
                case null:
                    $this->xpath = ' ';

                    break;
            }
        }

        return $this->xpath;
    }

    public function __toString () {
        return $this->combinator;
    }
}