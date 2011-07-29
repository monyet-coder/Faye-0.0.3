<?php
namespace faye\core\code\compiler;

class Lexer {
    protected
        $cursor = -1,
        $stream = NULL,
        $tokens = array();

    public function __construct ($input) {
        empty($input) or $this->setInput ($input);
    }

    public function setInput ($input) {
        $this->tokens = array();
        $this->scan($input);
        $this->stream = new TokenStream($this->tokens);
    }

    public function scan ($input) {
        static $regex;

        if (!isset($regex)) {
            $regex = '/(' . implode(')|(', $this->getCatchablePatterns()) . ')|'
                   . implode('|', $this->getNonCatchablePatterns()) . '/i';
        }

        $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE;
        $matches = preg_split($regex, $input, -1, $flags);

        foreach ($matches as $match) {
            $value = $match[0];
            $position = $match[1];

            $line = count(explode("\n", substr($input, 0, $position)));

            $this->tokens[] = new Token($value, $position, $line);
        }
    }

    public function getStream () {
        return $this->stream;
    }

    protected function getNonCatchablePatterns () {
        return array('\s+');
    }

    protected function getCatchablePatterns () {
        return array(
            '[a-z_][a-z0-9_:]*',
            '(?:[0-9]+(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?',
            '"(?:[^"]|"")*"',
            '->|<\/'
        );
    }
}