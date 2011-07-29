<?php
namespace faye\core\utility;

class String {
    protected static $replace = array(
        '_' => ' ',
        '-' => ' ',
    );

    public static function hyphenate ($string, $preserveCase = false) {
        $string = preg_replace('/\s*([a-z]+|[A-Z][a-z]+)/', '-\1', $string);
        $string = trim($string, '-');

        if(!$preserveCase) {
            $string = strtolower($string);
        }

        return $string;
    }

    public static function dash ($string, $preserveCase = false) {
        $string = preg_replace('/\s*([a-z]+|[A-Z][a-z]+)/', '_\1', $string);
        $string = trim($string, '_');

        if(!$preserveCase) {
            $string = strtolower($string);
        }

        return $string;
    }

    public static function pascalize ($string) {
        $string = str_replace(array_keys(self::$replace), self::$replace, $string);
        $string = ucwords($string);
        $string = str_replace(' ', NULL, $string);

        return $string;
    }

    public static function camelize ($string) {
        return lcfirst(self::pascalize($string));
    }

    public static function spaceSeparate ($string, $ucwords = true) {
        $string = preg_replace('/([A-Z][A-Z]?[a-z]*)/', ' \1', $string);
        $string = str_replace(array_keys(self::$replace), self::$replace, $string);
        $string = trim($string);

        if($ucwords) {
            $string = ucwords($string);
        } else {
            $string = ucfirst(strtolower($string));
        }


        return $string;
    }

    public static function namespaceToDirectory ($namespace) {
        return str_replace('\\', '/', $namespace);
    }

    public static function directoryToNamespace ($directory) {
        return str_replace('/', '\\', $directory);
    }
}