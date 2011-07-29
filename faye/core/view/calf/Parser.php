<?php
namespace faye\core\view\calf;

use faye\core\view\template\ParserInterface;
use faye\core\view\template\ContentInterface;
use faye\core\utility\String;

class Parser implements ParserInterface {
    public function parse (ContentInterface $content, array $vars = array()) {
        $doc = $content->getContent();

        require SITE_PATH . '/faye/core/xml/html/Element.php';
        $doc('ui:*')->each(function (\DOMNode $node, $i) use ($doc, $vars) {
            $name = \str_replace('ui:', null, $node->nodeName);
            $class = 'faye\\core\\xml\\ui\\' . String::pascalize($name);

            $attributes = array();
            foreach ($node->attributes as $attribute) {
                $value = trim($attribute->value);

                if (preg_match('/^\{\$(.+)\}$/', $value, $match)) {
                    $var = $match[1];

                    isset($vars[$var]) and $value = $vars[$var];
                }

                $attributes[$attribute->name] = $value;
            }

            $children = array();
            foreach ($node->childNodes as $child) {
                if ($child instanceof \DOMText and preg_match('/^\{\$([\w|-|_]+)\}$/', trim($child->wholeText), $match)) {
                    $var = $match[1];

                    isset($vars[$var]) and $child = new \DOMText($vars[$var]);
                }

                $children[] = $child;
            }

            $node->parentNode->replaceChild(new $class($doc, $attributes, $children), $node);
        });
        $doc->xpath('//*[starts-with(normalize-space(text()), \'{$\')]/text()')->each(function ($node) use ($doc, $vars) {            
            if (preg_match('/^\{\$([\w|-|_]+)\}$/', trim($node->wholeText), $match)) {
                $var = $match[1];
                
                $node->parentNode->replaceChild(new \DOMText($vars[$var]), $node);
            }            
        });

        return $content->getContent()->saveXML();
    }
}