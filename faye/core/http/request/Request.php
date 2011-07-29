<?php
namespace faye\core\http\request;

use faye\core\application\Application;
use faye\core\utility\String;

class Request {
    const
        GET  = 'GET',
        POST = 'POST',
        PUT  = 'PUT',
        DELETE = 'DELETE';

    protected $app, $URI, $method;

    public function __construct (Application $app) {
        $this->app = $app;
        $this->app->setRequest($this);
    }

    public function getTime () {
        return $_SERVER['REQUEST_TIME'];
    }

    public function getReferer () {
        return $_SERVER['HTTP_REFERER'];
    }

    public function getURI () {
        if (empty($this->URI)) {
            $this->URI = new URI(isset($_GET['rt']) ? $_GET['rt'] : '');

            unset($_GET['rt']);
        }

        return $this->URI;
    }

    public function isAJAX () {
        return
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) and
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function getIP () {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getUserAgent () {
        static $userAgent;

        if (empty($userAgent)) {
            $userAgent = new UserAgent;
        }

        return $userAgent;
    }

    public function is ($type) {
        $method = String::camelize('is ' . $type);

        if(is_callable(array($this, $method))) {
            return $this->{$method}();
        }

        throw new \InvalidArgumentException('The request method specified isn\'t recognized.');
    }

    public function isGet () {
        return $_SERVER['REQUEST_METHOD'] === self::GET;
    }

    public function isPut () {
        return $_SERVER['REQUEST_METHOD'] === self::PUT;
    }

    public function isPost () {
        return $_SERVER['REQUEST_METHOD'] === self::POST;
    }

    public function isDelete () {
        return $_SERVER['REQUEST_METHOD'] === self::DELETE;
    }
}