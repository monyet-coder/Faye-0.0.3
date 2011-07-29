<?php
namespace apps\app\controller;

use faye\core\controller\Controller;

class Calf extends Controller {

    public function index () {
        $template = $this->view->load('template.html', 'calf');

        $template->title = 'Faye, Beautiful PHP Framework.';
        $template->loginAction = 'member/login';
        $template->gender = array(
            'Man', 'Woman', 
        );
        $template->styles = array(
            'http://localhost/faye.0.0.3/apps/app/resource/css/ui/ui.css',
        );
        $template->scripts = array(
            'http://localhost/faye.0.0.3/apps/app/resource/js/jquery-1.6.2.min.js',
            'http://localhost/faye.0.0.3/apps/app/resource/js/ui.js',
        );
        $template->suggestions = array(
            'Hive', 'jQuery', 'PHP', 'CodeIgniter',
            'Symfony', 'Cake', 'Rails', 'HPHP',
            'XHP', 'Python', 'Erlang', 'Yii',
            'ZeNd', 'Oracle', 'PeopleSoft', 'Thrift', 
        );
        $template->column = 2;
        
        echo $template;
    }
}