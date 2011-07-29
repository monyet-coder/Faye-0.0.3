<?php
namespace apps\app\controller;

use faye\core\controller\Controller;
use faye\core\database\ConnectionManager;
use apps\app\model\Product;

class Index extends Controller {
    public function index () {
        $product = new Product;
    }
}