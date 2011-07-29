<?php
namespace faye\core\database\query\builder\node;

use faye\core\database\query\builder\BuilderInterface;

interface NodeInterface {
    const
        HAS_ALIAS       = '/AS\s+(\w+)/i',
        HAS_OPERATOR    = '/(>=|<=|<|>|!|=|IS[\s]+NULL|IS[\s]+NOT[\s]+NULL|[\s]+LIKE[\s]+|NOT[\s]+LIKE|[\s]+IN[\s]+|NOT[\s]+IN)/i',
        HAS_AGGREGATE 	= '/(SUM|COUNT|MIN|MAX|AVG)\s*\((\w+)\)/i',
        HAS_ARITHMETIC	= '/([+|-|\/|\*|%|^|&|~|\||<<|>>]\s*\w[0-9|\w]*)/i'
    ;

    public function build (BuilderInterface $builder);
    public function __toString ();
}