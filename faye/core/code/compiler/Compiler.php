<?php
namespace faye\core\code\compiler;

class Compiler {
    protected
        $indentation;

    public function indent ($step = 1) {
        $this->indentation += $step;

        return $this;
    }

    public function outdent ($step = 1) {
        $this->indentation -= $step;

        return $this;
    }

    public function addIndentation () {
        $this->code .= str_repeat('    ', $this->indentation);

        return $this;
    }

    public function compile ($source) {
        $lexer = new Lexer($source);
    }

    public function compileNode (NodeInterface $node) {
        $node->compile($this);
    }

    public function __invoke ($code) {
        return $this->write($code);
    }

    public function write ($code) {
        $this->code .= $code;

        return $this;
    }
}