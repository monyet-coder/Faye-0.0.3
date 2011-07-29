<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\Fragment as HTMLFragment;
use faye\core\xml\html\link as HTMLLink;

class Stylesheets extends HTMLFragment {
    protected function setAttributeItems (array $items) {
        foreach ($items as $style) {
            $this->appendChild(new HTMLLink($this->ownerDocument, array('href' => $style)));
        }

        return false;
    }
}