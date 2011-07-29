<?php
namespace faye\core\autoload;

use faye\core\pattern\Singleton;

require __DIR__.'/../pattern/Singleton.php';
require __DIR__.'/Storage.php';

class Autoload extends Singleton {
    protected $storage = NULL;

    public function __construct () {
        $this->storage = new Storage('D:\cache.php');

        $this->register(array($this, 'load'));
    }

    public function load ($class) {
        #if ($this->storage->containsKey($class)) {
        #    require $this->storage->get($class);
        #} else {
            $path = SITE_PATH.'/'.str_replace('\\', '/', $class) . '.php';

            if (is_file($path)) {
                #$this->storage->set($class);

                require $path;
            }
        #}
    }

    public function register ($callback) {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException(sprintf('The callback specified for %s isn\'t callable.', __METHOD__));
        }

        spl_autoload_register($callback);

        return $this;
    }
}

Autoload::getInstance();