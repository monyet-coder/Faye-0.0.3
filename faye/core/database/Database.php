<?php
namespace faye\core\database;

use faye\core\application\Application;

class Database {
    protected
        $app = null,
        $manager = null;

    public function __construct (Application $app) {
        $this->app = $app;
        $this->manager = new ConnectionManager($app);
    }
}