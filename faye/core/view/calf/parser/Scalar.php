<?php
namespace faye\core\view\calf\parser;

use faye\core\view\template\ParserInterface;
use faye\core\view\template\ContentInterface;

class Scalar implements ParserInterface {
    public function parse (ContentInterface $content, array $vars = array()) {
        $doc = $content->getContent();

        $doc('*[*^="{$"]')->each(function (\DOMNode $node, $i) use ($vars) {
            $removeList = array();

            foreach ($node->attributes as $attribute) {
                $len = strlen($attribute->value);
                if ($len > 3 and substr_compare($attribute->value, '{$', 0, 2) === 0) {
                    $key = substr($attribute->value, 2, $len - 3);
                    if(isset($vars[$key])) {
                        $node->setAttribute($attribute->name, $vars[$key]);
                    } else {
                        $removeList[] = $attribute->name;
                    }
                }
            }

            foreach ($removeList as $remove) {
                $node->removeAttribute($remove);
            }
        });

        return $content;
    }
}