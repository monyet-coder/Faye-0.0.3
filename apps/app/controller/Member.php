<?php
namespace apps\app\controller;

use faye\core\controller\Controller;

class Member extends Controller {
    public function login () {
        print_r($_POST);
    }
}