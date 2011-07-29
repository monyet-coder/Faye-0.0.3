<?php
namespace faye\core\code\compiler;

class Token {
    const
        T_NONE          = -1,
        T_DOLLAR        = 1,
        T_IDENTIFIER    = 2,
        T_INTEGER       = 3,
        T_STRING        = 4,
        T_FLOAT         = 5,

        T_NULL                  = 100,
        T_TRUE                  = 101,
        T_FALSE                 = 102,
        T_OPEN_CURLY_BRACES     = 103,
        T_CLOSE_CURLY_BRACES    = 104,
        T_OBJECT_OPERATOR       = 105,
        T_OPEN_SQUARE_BRACKET   = 106,
        T_CLOSE_SQUARE_BRACKET  = 107,
        T_COLON                 = 108,
        T_LOWER_THAN            = 109,
        T_GREATER_THAN          = 110,
        T_SLASH                 = 111,
        T_AT                    = 112,
        T_PERIOD                = 113,
        T_COMMA                 = 114
    ;

    protected
        $literal    = '';

    public
        $value      = '',
        $type       = 0,
        $line       = 0,
        $position   = 0
    ;

    public function __construct ($value, $position, $line) {
        $this->value = $value;
        $this->position = $position;
        $this->line = $line;
        $this->type = $this->getType ();
    }

    protected function getType () {
        $value = $this->value;

        if (empty($value)) {
            return self::T_NONE;
        }

        if (is_numeric($value)) {
            return
                (strpos($value, '.') !== false || stripos($value, 'e') !== false) ? self::T_FLOAT : self::T_INTEGER;
        }

        switch (strtolower($value)) {
            case '<':
                return self::T_LOWER_THAN;
            case '>':
                return self::T_GREATER_THAN;
            case '{':
                return self::T_OPEN_CURLY_BRACES;
            case '$':
                return self::T_DOLLAR;
            case '}':
                return self::T_CLOSE_CURLY_BRACES;
            case '[':
                return self::T_OPEN_SQUARE_BRACKET;
            case ']':
                return self::T_CLOSE_SQUARE_BRACKET;
            case '->':
                return self::T_OBJECT_OPERATOR;
            case '/':
                return self::T_SLASH;
            case ':':
                return self::T_COLON;
            case 'null':
                return self::T_NULL;
            case 'true':
                return self::T_TRUE;
            case 'false':
                return self::T_FALSE;
            case '@':
                return self::T_AT;
            case ',':
                return self::T_COMMA;
            case '.':
                return self::T_PERIOD;
            default:
                if (ctype_alpha($value[0]) || $value[0] === '_') {
                    return self::T_IDENTIFIER;
                }

                break;
        }

        return self::T_NONE;
    }

    public function is ($type) {
        return $this->type === (int)$type;
    }

    public function getLiteral () {
        if (empty($this->literal)) {
            $reflector = new ReflectionClass ($this);
            $tokens = $reflector->getConstants();

            if (($name = array_search($this->type, $tokens)) !== false) {
                return get_class($this) . '::' . $name;
            }
        }

        return $this->literal;
    }
}