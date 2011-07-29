<?php
namespace faye\core\code\generator;

class Generator {
    protected
        $code = '',
        $tabSize = 4,
        $indentation = 0
    ;

    public function getCode () {
        return $this->code;
    }

    public function getTabSize () {
        return $this->tabSize;
    }

    public function setTabSize ($tabSize) {
        if ($tabSize < 0) {
            throw new \InvalidArgumentException(sprintf('Tab size must be larger or equal to zero, negative value given (%d).', $tabSize));
        }

        $this->tabSize = (int)$tabSize;

        return $this;
    }

    public function indentation () {
        return str_repeat(' ', $this->indentation * $this->tabSize);
    }

    public function addIndentation () {
        $this->code .= $this->indentation();
    }

    public function indent ($step = 1) {
        $this->indentation += abs($step);

        return $this;
    }

    public function outdent ($step = 1) {
        if ($this->indentation - ($step = abs($step)) < 0) {
            throw new \InvalidArgumentException(sprintf('Can\'t outdent the current code by %s as the indentation will become less than zero.', $step));
        }

        $this->indentation -= $step;

        return $this;
    }

    public function write () {
        $this->addIndentation();
        foreach (func_get_args() as $code) {
            if(is_string($code)) {
                if (strpos($code, "\n") !== false) {
                    $code = str_replace("\n", "\n" . $this->indentation(), $code);
                }

                $this->code .= $code;
            } else if (is_array($code)) {
                $this->indent();
                $this->code .= "array(\n";
                foreach ($code as $key => $val) {
                    $this->write('"$key" => ', $val);
                }
                $this->outdent();
                $this->addIndentation();
                $this->code .= ')';
            }
        }
        $this->code .= "\n";

        return $this;
    }

    public function __toString () {
        return $this->code;
    }
}