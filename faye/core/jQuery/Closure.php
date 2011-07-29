<?php
namespace faye\core\jQuery;

class Closure {
    protected $closure = null;

    public function __construct (\Closure $closure) {
        $this->closure = $closure;
    }

    public function __toString () {
        $jQuery = new jQuery;

        $closure = $this->closure;

        $return = $closure($jQuery) === false ? "return false;" : null;

        return sprintf("function () {%s%s}", $jQuery, $return);
    }
}