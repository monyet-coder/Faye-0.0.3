<?php
namespace faye\core\collection;

interface CollectionInterface extends ListInterface  {
    const SORT_KEY = 1;

    public function keys ();
}