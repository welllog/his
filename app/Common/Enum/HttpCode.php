<?php

namespace App\Common\Enum;


class HttpCode
{
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NO_CONTENT = 204;      // 浏览器不会接受返回结果
    const RESET_CONTENT = 205;   // 浏览器不会接受返回结果
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const REQUEST_TIME_OUT = 408;
    const CONFLICT = 409;
    const GONE = 410;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const HTTP_VERSION_NOT_SUPPORTED = 505;

}