<?php
namespace faye\core\collection;

class Stream implements StreamInterface {
    protected
        $cursor = -1,
        $stream = array();

    public function __construct (array $stream = array()) {
        $this->stream = $stream;
    }

    public function count () {
        return count($this->stream);
    }

    public function isValid ($cursor) {
        return $cursor < $this->count() and $cursor >= 0;
    }

    public function next () {
        $cursor = $this->cursor += $step;

        return $this->isValid($cursor) ? $this->tokens[$cursor] : false;
    }

    public function peek ($offset) {
        $cursor = $this->cursor + $offset;

        return $this->isValid($cursor) ? $this->stream[$cursor] : false;
    }

    public function __toString () {
        return sprintf('[%s]', implode(', ', $this->stream));
    }
}