<?php
namespace faye\core\jQuery;

use faye\core\collection\ArrayList;

define('faye\core\jQuery\this', 'this');

class jQuery {
    protected
        $chainList = null
    ;

    public function __construct () {
        $this->chainList = new ArrayList;
    }

    public function __invoke ($selector = this) {
        $this->chainList->push($action = new Chain($selector));

        return $action;
    }

    public function __toString () {
        return $this->chainList->join();
    }
}

function jQuery ($selector = null) {
    static $jQuery;

    if(empty($jQuery)) {
        $jQuery = new jQuery;
    }

    return $selector === null ? $jQuery : $jQuery($selector);
}