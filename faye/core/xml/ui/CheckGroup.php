<?php
namespace faye\core\xml\ui;

class CheckGroup extends Fragment {
    public function setAttributeName ($name) {
        $this('input[type="checkbox"]')->each(function ($node, $i) {
            $node->setAttribute('name', $name.'[]');
        });
    }

    public function setAttributeOptions (array $options) {
        foreach ($options as $value => $text) {

        }

        return false;
    }
}