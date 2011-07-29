<?php
namespace faye\core\view\calf;

use faye\core\view\template\ParserInterface;
use faye\core\view\template\TemplateInterface;
use faye\core\collection\Collection;
use faye\core\collection\ArrayList;
use faye\core\xml\dom\Document;
use faye\core\utility\Func;
use faye\core\xml\ui;

class Template implements TemplateInterface {
    protected
        $content,
        $vars = array(),
        $parserList = null,

        $styles = null, $scripts = null
    ;

    public function __construct ($path, array $vars = array()) {
        $this->vars = $vars;
        $this->content = new Content($path);
        $this->parserList = new ArrayList;

        $this->styles = new ArrayList(isset($vars['styles']) ? $vars['styles'] : array());
        $this->scripts = new ArrayList(isset($vars['scripts']) ? $vars['scripts'] : array());

        $this->addParser(new Parser);
    }

    public function addParser (ParserInterface $parser) {
        $this->parserList->push ($parser);

        return $this;
    }

    public function addStyle ($style) {
        $this->styles->contains($script) or $this->styles->push($script);

        return $this;
    }

    public function addStyles (array $styles = array()) {
        foreach ($styles as $style) {
            $this->addStyle($style);
        }

        return $this;
    }

    public function addScript ($script) {
        $this->scripts->contains($script) or $this->scripts->push($script);

        return $this;
    }

    public function addScripts (array $scripts = array()) {
        foreach ($scripts as $script) {
            $this->addScript($script);
        }

        return $this;
    }

    public function import (TemplateInterface $template, $position = null) {
        return $this;
    }

    public function render () {
        $this->vars['styles'] = array_unique(array_merge($this->vars['styles'], $this->styles->toArray()));
        $this->vars['scripts'] = array_unique(array_merge($this->vars['scripts'], $this->scripts->toArray()));

        foreach ($this->parserList as $parser) {
            $parser->parse($this->content, $this->vars);
        }

        return $this->content;
    }

    public function __set ($name, $value) {
        $this->vars[$name] = $value;
    }

    public function __toString () {
        try {
            return (string)$this->render();
        } catch (\Exception $e) {
            return '<pre>' . $e->getMessage() . $e->getTraceAsString();
        }
    }
}