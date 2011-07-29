<?php
namespace faye\core\file;

require __DIR__.'/AbstractFile.php';

class Text extends AbstractFile {
    public function append () {
        fseek($this->handler, $this->size(), SEEK_SET);
        fwrite($this->handler, implode(func_get_args()));

        return $this;
    }

    public function prepend () {
        $this->truncate();
        $this->write($this->content . implode(func_get_args()));

        return $this;
    }

    public function readLine () {
        return fgets($this->handler);
    }
}