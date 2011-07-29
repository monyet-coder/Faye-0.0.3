<?php
namespace faye;

$start = microtime(true);

define('SITE_PATH', __DIR__);

define('DS', DIRECTORY_SEPARATOR);

require __DIR__.DS.'faye'.DS.'Faye.php';

Faye::init();
echo microtime(true) - $start;