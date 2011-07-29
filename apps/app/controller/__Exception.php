<?php
namespace apps\app\controller;

use faye\core\controller\Controller;

class __Exception extends Controller {
    public function index (\Exception $e) {
        echo "here's an exception page.";
        echo get_class($e);
        echo $e->getMessage();
    }
}