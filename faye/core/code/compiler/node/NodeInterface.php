<?php
namespace faye\core\code\compiler\node;

use faye\core\code\compiler\Compiler;

interface NodeInterface {
    public function compile (Compiler $compiler);
}
