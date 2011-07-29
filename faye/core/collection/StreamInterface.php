<?php
namespace faye\core\collection;

interface StreamInterface extends \Countable, \IteratorAggregate {
    public function next ($step = 1);
    public function peek ($offset = 0);
}