<?php
namespace faye\core\xml\ui;

class RadioGroup extends Fragment {
    public function setAttributeName ($name) {
        $this('input[type="radio"]')->each(function ($node, $i) {
            $node->setAttribute('name', $name . '[]');
        });
    }
}