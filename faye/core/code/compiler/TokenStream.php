<?php
namespace faye\core\code\compiler;

class TokenStream implements \Countable {
    protected
        $cursor = -1,
        $tokens = array()
    ;

    public function __construct (array $tokens) {
        $this->tokens = array_values($tokens);
    }

    public function count () {
        return count ($this->tokens);
    }

    public function isValid ($cursor) {
        return $cursor < $this->count() and $cursor >= 0;
    }

    public function next ($step = 1) {
        $cursor = $this->cursor += $step;

        return $this->isValid($cursor) ? $this->tokens[$cursor] : false;
    }

    public function peek ($step = 0) {
        $cursor = $this->cursor + $step;

        return $this->isValid($cursor) ? $this->tokens[$cursor] : false;
    }

    public function expect () {
        if (($nextToken = $this->peek(+1)) !== false and !in_array($nextToken->type, func_get_args())) {
            throw new ParsingException ('Unexpected ' . $nextToken->getLiteral() . ' at line ' . $nextToken->line . '.');
        }

        return true;
    }
}