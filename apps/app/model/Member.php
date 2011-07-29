<?php
namespace apps\app\model;

use faye\core\model\Model;

class Member extends Model {
    /**
     *
     * @param type $username
     * @param type $password
     * @return boolean
     */
    public function login ($username, $password) {
        return true;
    }
}