<?php
namespace faye\core\storage;

use faye\core\file\Text as TextFile;

require __DIR__.'/Storage.php';
require __DIR__.'/../file/Text.php';

class File extends Storage {
    protected $file = NULL;

    public function __construct ($path) {
        $this->file = new TextFile ($this->path = $path);

        parent::__construct ();
    }

    public function load () {
        $this->coll = unserialize($this->file->read());

        return $this;
    }

    public function save () {
        $this->file->write(serialize($this->coll));

        return $this;
    }

    public function destroy () {
        $this->clear();
        $this->file->delete();

        return $this;
    }
}