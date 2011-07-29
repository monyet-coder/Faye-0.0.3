<?php
namespace faye\core\http\request;

use faye\core\collection\ArrayList;
use faye\core\collection\Collection;

class URI {
    protected
        $URI,
        $segments = null,
        $parameters = null
    ;

    public function __construct ($URI) {
        $this->URI = $URI;
        $this->segments = new ArrayList($segments = explode('/', (string)$URI));
        $this->parameters = new Collection;

        $len = count($segments);
        for($i = $len % 2 === 0 ? 2 : 1; $i < $len - 1; $i += 2) {
            $this->parameters->set($this->segments->get($i), $this->segments->get($i + 1));
        }
    }

    public function getSegment ($index) {
        return $this->segments->get($index);
    }

    public function getParameter ($key) {
        return $this->parameters->get($key);
    }

    public function getSegments () {
        return $this->segments;
    }

    public function getParameters () {
        return $this->parameters;
    }

    public function __toString () {
        return (string)$this->URI;
    }
}