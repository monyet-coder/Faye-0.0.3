<?php
namespace faye\core\view\calf\parser;

use faye\core\view\template\ParserInterface;
use faye\core\view\template\ContentInterface;
use faye\core\utility\String;

class Constant implements ParserInterface {
    public function parse (ContentInterface $content, array $vars = array()) {
        $doc = $content->getContent();

        $doc('*[*^="{"]')->each(function (\DOMNode $node, $i) use ($vars) {
            foreach ($node->attributes as $attribute) {
                $len = strlen($attribute->value);
                $key = substr($attribute->value, 1, $len - 2);

                
            }
        });
    }
}