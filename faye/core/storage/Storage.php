<?php
namespace faye\core\storage;

use faye\core\pattern\State;
use faye\core\collection\Collection;

require __DIR__.'/../collection/Collection.php';
require __DIR__.'/StorageInterface.php';

abstract class Storage implements StorageInterface {
    protected
        $coll,
        $state;

    public function __construct () {
        $this->coll = new Collection;
        $this->state = new State(State::CLEAN_STATE);

        $this->load();
    }

    public function __destruct () {
        if ($this->state->is(State::DIRTY_STATE)) {
            $this->save();
        }
    }

    public function save () {
        $this->state->set(State::CLEAN_STATE);

        return $this;
    }
}