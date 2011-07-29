<?php
namespace faye\core\http\response;

class Response {
    protected
        $code          = HTTPCode::ACCEPTED,

        $protocol      = 'HTTP/1.1',
        $content       = '',
        $contentType   = 'text/plain',
        $contentLength = 0
    ;
}