<?php
namespace faye\core\xml\ui;

use faye\core\xml\html\form as HTMLForm;

class Form extends HTMLForm {
    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes + array('method' => 'post', 'enctype' => 'multipart/form-data'), $children);

        $this->addClass('ui ui-form');
    }

    public function setAttributeAsynchronousAction ($action) {
        $this->setData('asynchronous-action', $action);

        return false;
    }
}