<?php
namespace apps\app\controller;

use faye\core\controller\Controller;
use faye\core\code\compiler\Compiler as CodeCompiler;

class Compiler extends Controller {
    public function index () {
        $compiler = new CodeCompiler;

        echo $compiler->compile('{$muka + $badan}');
    }
}