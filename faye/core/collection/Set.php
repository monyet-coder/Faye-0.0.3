<?php
namespace faye\core\collection;

class Set extends ArrayList {
    public static function isValid ($element) {
        return !$this->contains($element);
    }
}