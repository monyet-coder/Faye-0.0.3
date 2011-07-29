<?php
namespace faye\core\xml\html;

use faye\core\utility\String;

abstract class Element extends \DOMElement {
    protected static $nodeName;
    protected $attribs = array(), $children = array();

    public function __construct (\DOMDocument $document, array $attributes = array(), array $children = array(), \DOMNode $refNode = null) {
        parent::__construct(static::$nodeName);

        $document->appendChild($this);
        $this->children = $children;
        foreach ($children as $child) {
            if (is_string($child)) {
                $child = new \DOMText($child);
            }

            $this->appendChild($child);
        }

        $this->attribs = $attributes;
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }

        foreach ($attributes as $name => $value) {
            if (method_exists($this, $method = 'setAttribute' . String::pascalize($name))) {
                if (($replace = $this->{$method}($value)) === false) {
                    $this->removeAttribute($name);
                } else if (!empty($replace)) {
                    $this->setAttribute($name, $replace);
                }
            }
        }

        $refNode === null or $refNode->parentNode->replaceChild($this, $refNode);
    }

    public function __toString () {
        return $this->ownerDocument->saveXML($this);
    }

    public function __invoke ($selector) {
        return $this->ownerDocument->__invoke($selector, $this);
    }

    public function setAttribute ($name, $value) {
        parent::setAttribute($name, (string)$value);

        return $this;
    }

    public function hasClass ($class) {
        return strpos(' ' . $this->getAttribute('class'), ' ' . $class . ' ') !== false;
    }

    public function addClass ($class) {
        if (!$this->hasAttribute('class')) {
            $this->setAttribute('class', \trim($class));
        } else if (strpos($class, ' ') !== false) {
            foreach (explode(' ', $class) as $segment) {
                $this->addClass($segment);
            }
        } else if (!$this->hasClass($class)) {
            $this->setAttribute('class', $this->getAttribute('class') . ' ' . $class);
        }

        return $this;
    }

    public function removeClass ($class) {
        if ($this->hasAttribute('class')) {
            $this->setAttribute('class', str_replace($class, null, $this->getAttribute('class')));
        }

        return $this;
    }

    public function toggleClass ($class) {
        if ($this->hasClass($class)) {
            $this->removeClass($class);
        } else {
            $this->addClass($class);
        }

        return $this;
    }

    public function getAttributes () {
        return $this->attributes;
    }

    public function clearAttributes () {
        foreach ($this->attributes as $attribute) {
            $this->removeAttribute($attribute->name);
        }

        return $this;
    }

    public function clearChildNodes () {
        while($this->firstChild) {
            $this->removeChild($this->firstChild);
        }

        return $this;
    }

    public function prependChild (\DOMNode $node) {
        if ($this->hasChildNodes()) {
            $this->insertBefore($node, $this->firstChild);
        } else {
            $this->appendChild($node);
        }

        return $this;
    }

    public function appendTo (\DOMNode $node) {
        $node->appendChild ($this);

        return $this;
    }

    public function prependTo (\DOMNode $node) {
        if ($node instanceof self) {
            $node->prependChild ($this);
        } else {
            if ($node->hasChildNodes()) {
                $node->insertBefore($this, $node->firstChild);
            } else {
                $node->appendChild($this);
            }
        }

        return $this;
    }

    public function before (\DOMNode $newNode) {
        $parentNode = $this->parentNode;

        if ($parentNode) {
            $parentNode->insertBefore($newNode, $this);
        }

        return $this;
    }

    public function insertAfter (\DOMNode $newNode, \DOMNode $refNode) {
        if ($refNode === $this->lastChild) {
            $this->appendChild ($newNode);
        } else {
            $this->insertBefore($newNode, $refNode->nextSibling);
        }

        return $this;
    }

    public function after (\DOMNode $newNode) {
        $parentNode = $this->parentNode;

        if ($parentNode->lastChild === $this) {
            $parentNode->appendChild($newNode);
        } else {
            $parentNode->replaceChild($newNode, $this->nextSibling);
        }

        return $this;
    }

    public function setData ($key, $value) {
        return $this->setAttribute('data-' . $key, \trim(json_encode($value), '"'));
    }

    public function getData ($key) {
        return json_decode('"' . $this->getAttribute('data-' . $key) . '"');
    }

    public function removeData ($key) {
        return $this->removeAttribute('data-' . $key);
    }
}

class a extends Element {
    protected static $nodeName = 'a';
}

class button extends Element {
    const
        RESET     = 'reset',
        SUBMIT    = 'submit',
        BUTTON    = 'button'
    ;

    protected static $nodeName = 'button';

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes + array('type' => self::SUBMIT), $children);
    }
}

class div extends Element {
    protected static $nodeName = 'div';
}

class fieldset extends Element {
    protected static $nodeName = 'fieldset';
}

class form extends Element {
    protected static $nodeName = 'form';

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes + array(
            'action' => '',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ), $children);
    }
}

class h1 extends Element {
    protected static $nodeName = 'h1';
}

class h2 extends Element {
    protected static $nodeName = 'h2';
}

class h3 extends Element {
    protected static $nodeName = 'h3';
}

class h4 extends Element {
    protected static $nodeName = 'h4';
}

class h5 extends Element {
    protected static $nodeName = 'h5';
}

class h6 extends Element {
    protected static $nodeName = 'h6';
}

class img extends Element {
    protected static $nodeName = 'img';
}

class input extends Element {
    const
        TEXT     = 'text',
        FILE     = 'file',
        CHECK    = 'checkbox',
        RADIO    = 'radio',
        HIDDEN   = 'hidden',
        PASSWORD = 'password'
    ;

    protected static $nodeName = 'input', $type = self::TEXT;

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct($doc, $attributes + array('type' => static::$type), $children);
    }
}

class label extends Element {
    protected static $nodeName = 'label';
}

class legend extends Element {
    protected static $nodeName = 'legend';
}

class li extends Element {
    protected static $nodeName = 'li';
}

class link extends Element {
    protected static $nodeName = 'link';

    public function __construct (\DOMDocument $doc, array $attributes = array(), array $children = array()) {
        parent::__construct ($doc, $attributes + array('rel' => 'stylesheet', 'type' => 'text/css'), $children);
    }
}

class option extends Element {
    protected static $nodeName = 'option';
}

class p extends Element {
    protected static $nodeName = 'p';
}

class script extends Element {
    protected static $nodeName = 'script';
}

class select extends Element {
    protected static $nodeName = 'select';
    protected $selectedIndex = 0;
}

class span extends Element {
    protected static $nodeName = 'span';
}

class strong extends Element {
    protected static $nodeName = 'strong';
}

class table extends Element {
    protected static $nodeName = 'table';
}

class tbody extends Element {
    protected static $nodeName = 'tbody';
}

class td extends Element {
    protected static $nodeName = 'td';
}

class textarea extends Element {
    protected static $nodeName = 'textarea';
}

class tfoot extends Element {
    protected static $nodeName = 'tfoot';
}

class thead extends Element {
    protected static $nodeName = 'thead';
}

class tr extends Element {
    protected static $nodeName = 'tr';
}

class ul extends Element {
    protected static $nodeName = 'ul';
}
