<?php
namespace faye\core\storage;

interface StorageInterface {
    public function load ();
    public function save ();
    public function destroy ();
}