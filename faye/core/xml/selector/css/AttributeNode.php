<?php
namespace faye\core\xml\selector\css;

class AttributeNode implements NodeInterface {
    protected
        $xpath,
        $selector,
        $name,
        $operator,
        $value;

    public function __construct ($selector, array $attribute) {
        $this->selector = $selector;
        $this->name = trim($attribute[0]);
        $this->operator = trim($attribute[1]);
        $this->value = $attribute[2];
    }

    public function getXPath () {
        if (empty($this->xpath)) {
            $value = trim($this->value);
            if (empty($value)) {
                return NULL;
            }

            switch ($this->operator) {
                case '=':
                    $this->xpath = sprintf("@%s='%s'", $this->name, $this->value);

                    break;
                case '~=':
                    $this->xpath = sprintf("contains(concat(' ', normalize-space(@%s), ' '), '%s')", $this->name, $this->value);

                    break;
                case '*=':
                    $this->xpath = sprintf("contains(@%s, '%s')", $this->name, $this->value);

                    break;
                case '^=':
                    $this->xpath = sprintf("starts-with(@%s, '%s')", $this->name, $this->value);

                    break;
                case '$=':
                    $this->xpath = sprintf("substring(@%s, string-length(@%s)-%d) = '%s'", $this->name, $this->name, strlen($this->value) - 1, $this->value);

                    break;
                default:
                    $this->xpath = sprintf("@%s", $this->name);

                    break;
            }
        }

        return $this->xpath = sprintf('[%s]', $this->xpath);
    }

    public function __toString () {
        return sprintf('[%s%s%s]', $this->name, $this->operator, $this->value);
    }
}