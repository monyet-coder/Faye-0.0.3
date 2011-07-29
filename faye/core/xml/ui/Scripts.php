<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\script as HTMLScript;

class Scripts extends Fragment {
    protected function setAttributeItems (array $items) {
        foreach ($items as $script) {
            $this->appendChild(new HTMLScript($this->ownerDocument, array('src' => $script), array('')));
        }

        return false;
    }
}