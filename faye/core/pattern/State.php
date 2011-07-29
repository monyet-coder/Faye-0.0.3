<?php
namespace faye\core\pattern;

class State {
    const
        INITIAL_STATE = -1,
        CLEAN_STATE   = 1,
        DIRTY_STATE   = 2;

    protected $state = self::INITIAL_STATE;

    public function __construct ($state = self::INITIAL_STATE) {
        $this->state = $state;
    }

    public function clear () {
        $this->state = static::INITIAL_STATE;

        return $this;
    }

    protected function operate ($state, $modify = 'add') {
        switch ($state) {
            case 'add':
                $this->state |= $state;

                break;
            case 'remove':
                $this->state ^= $state;

                break;
        }

        return $this;
    }

    public function add () {
        foreach (func_get_args() as $state) {
            $this->operate($state, __FUNCTION__);
        }

        return $this;
    }

    public function set ($state) {
        $this->state = $state;

        return $this;
    }

    public function remove () {
        foreach (func_get_args() as $state) {
            $this->operate($state, __FUNCTION__);
        }
    }

    public function is ($state) {
        return $this->state & $state;
    }
}