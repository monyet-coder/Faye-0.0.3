<?php
namespace apps\app\controller;

use faye\core\jQuery\jQuery as BasejQuery;
use faye\core\controller\Controller;

class jQuery extends Controller {
    public function index () {
        $jQuery = new BasejQuery;

        echo
            $jQuery('*')
                ->hide()
                ->show()
                ->addClass('tpd')
                ->css(array(
                    'background-color' => 'black',
                    'font-size' => '12px',
                ))
                ->click(function ($jQuery) {
                    $jQuery()->hide();

                    return false;
                })
            ;
    }
}