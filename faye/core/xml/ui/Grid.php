<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\table as HTMLTable;

class Grid extends HTMLTable {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes, $children);

        $this->addClass('ui-grid');

        $this->clearChildNodes();
        $children = array_chunk($children, ($column = $this->getAttribute('column')) ? (int)$column : 1);
        for ($i = 0, $count = count($children); $i < $count; ++$i) {
            $tr = $this->ownerDocument->createElement('tr');
            $this->appendChild($tr);
            for ($j = 0; $j < $column and isset($children[$i][$j]); ++$j) {
                $td = $this->ownerDocument->createElement('td');

                $tr->appendChild($td);
                $td->appendChild($children[$i][$j]);
            }
        }

        $this->removeAttribute('column');


    }
}