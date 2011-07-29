<?php
namespace faye\core\view\calf;

use faye\core\view\template\ContentInterface;
use faye\core\xml\html\Document;

class Content implements ContentInterface {
    protected $path, $document;

    public function __construct ($path) {
        $this->path = $path;
        $this->document = new Document;

        $this->document->load($path);
    }

    public function setContent ($document) {
        $this->document = $document;

        return $this;
    }

    public function getContent () {
        return $this->document;
    }

    public function __toString () {
        return $this->document->__toString();
    }
}