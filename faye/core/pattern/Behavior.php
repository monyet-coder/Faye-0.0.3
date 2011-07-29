<?php
namespace faye\core\pattern;

use faye\utility\String;

abstract class Behavior {
    protected
        $sender   = NULL,
        $enabled  = true,
        $handlers = array()
    ;

    public function __construct($sender) {
        $this->sender = $sender;

        foreach($this->getEvents() as $eventName) {
            $this->handlers[$eventName] = array();
        }
    }

    abstract public function getEvents();

    public function enabled() {
        $this->enabled = true;

        return $this;
    }

    public function disabled() {
        $this->enabled = false;

        return $this;
    }

    public function isEnabled() {
        return $this->enabled;
    }

    protected function recognized($eventName) {
        return in_array($eventName, $this->getEvents());
    }

    public function on($eventName, $eventHandler) {
        $eventName = 'on' . String::pascalize($eventName);

        if($this->recognized($eventName) and is_callable($eventHandler)) {
            $this->handlers[$eventName][] = $eventHandler;
        }

        return $this;
    }

    public function trigger() {
        foreach(func_get_args() as $eventName) {
            substr($eventName, 0, 2) === 'on' or $eventName = 'or' . $eventName;

            if($this->recognized($eventName)) {
                foreach($this->handlers[$eventName] as $handler) {
                    $handler($this->sender);
                }
            }
        }

        return $this;
    }
}