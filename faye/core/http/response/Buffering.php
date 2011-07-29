<?php
namespace faye\core\http\response;

class Buffering {
    protected $content = '';

    public function start ($callback = NULL) {
        if ($callback === NULL) {
            ob_start();
        } else {
            ob_start($callback);
        }
    }

    public function getContent () {
        return $this->content = ob_get_contents();
    }

    public function getLength () {
        return ob_get_length();
    }

    public function end () {
        ob_end_clean();

        return $this;
    }

    public function clear () {
        ob_clean();

        return $this;
    }

    public function flush () {
        ob_flush();

        return $this;
    }

    public function __toString () {
        return $this->content;
    }
}