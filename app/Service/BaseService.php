<?php

namespace App\Service;


class BaseService
{
    protected $error = '';
    protected $httpCode = 200;

    public function getError()
    {
        return $this->error;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}