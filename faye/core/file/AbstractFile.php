<?php
namespace faye\core\file;

use faye\core\pattern\State;

require __DIR__.'/../pattern/State.php';
require __DIR__.'/FileInterface.php';

abstract class AbstractFile implements FileInterface {
    const
        DEFAULT_MODE = 'r+b';

    protected
        $mode = self::DEFAULT_MODE,
        $path,
        $content,
        $handler,

        $size,
        $directory,
        $lastModified,
        $lastAccess,
        $extension,
        $MIME,

        $state
    ;

    public function __construct ($path, $mode = self::DEFAULT_MODE) {
        if (!is_file($path)) {
            touch($path);
        }

        $this->handler = fopen($this->path = $path, $this->mode = $mode);
        $this->state = new State(State::CLEAN_STATE);
    }

    public function __destruct () {
        fclose($this->handler);
    }

    public function read () {
        return $this->content = file_get_contents($this->path);
    }

    public function write ($data, $append = false) {
        $flag = $append ? FILE_APPEND : 0;

        file_put_contents($this->path, $data, $append);

        return $this;
    }

    public function delete () {
        unlink ($this->path);

        return $this;
    }

    public function truncate () {
        ftruncate($this->handler, 0);

        return $this;
    }

    public function save() {
        fclose($this->handler);
        fopen($this->path);

        return $this;
    }

    public function getSize () {
        if (empty($this->size)) {
            $this->size = filesize ($this->path);
        }

        return $this->size;
    }

    public function getDirectory () {
        if (empty($this->directory)) {
            $this->directory = realpath($this->path);
        }

        return $this->directory;
    }

    public function getExtension () {
        if (empty($this->extension)) {
            $this->extension = pathinfo($this->filePath, PATHINFO_EXTENSION);
        }

        return $this->extension;
    }

    public function getMIME () {
        if (empty($this->MIME)) {
            $this->MIME = MIME::getInstance()->getMIME($this->getExtension());
        }

        return $this->MIME;
    }

    public function getLastAccess () {
        if (empty($this->lastAccess)) {
            $this->lastAccess = fileatime($this->path);
        }

        return $this->lastAccess;
    }

    public function getLastModified () {
        if (empty($this->lastModified)) {
            $this->lastModified = filemtime($this->path);
        }

        return $this->lastModified;
    }

    public function getContent () {
        if (empty($this->content)) {
            $this->read();
        }

        return $this->content;
    }

    public function copyTo ($path) {
        return copy($this->path, $path);
    }

    public function cutTo ($path) {
        return rename($this->path, $path);
    }

    public function __toString () {
        return (string)$this->getContent();
    }
}