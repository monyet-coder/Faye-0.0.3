<?php
namespace faye\core\http\response;

class HTTPCode {
    const
        OK                        = 200,
        CREATED                   = 201,
        ACCEPTED                  = 202,
        NO_CONTENT                = 204,

        MOVED_PERMANENTLY         = 301,
        NOT_MODIFIED			  = 304,

        BAD_REQUEST               = 400,
        UNAUTHORIZED              = 401,
        FORBIDDEN                 = 403,
        NOT_FOUND                 = 404,
        METHOD_NOT_ALLOWED        = 405,
        REQUEST_TIMEOUT           = 408,

        INTERNAL_SERVER_ERROR     = 500,
        NOT_IMPLEMENTED           = 501,
        BAD_GATEWAY               = 502,
        GATEWAY_TIMEOUT           = 503
    ;

    private $statuses = array();

    public static function getStatuses () {
        if (empty(self::$statuses)) {
            $reflector = \ReflectionClass(get_called_class());

            foreach ($reflector->getConstants() as $status => $code) {
                self::$statuses[$code] = String::spaceSeparate($status);
            }
        }

        return self::$statuses;
    }

    public static function getStatus ($code) {
        self::getStatuses();

        if (isset(self::$statuses[$code])) {
            return self::$statuses[$code];
        }

        throw new \InvalidArgumentException();
    }
}