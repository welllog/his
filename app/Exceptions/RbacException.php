<?php

namespace App\Exceptions;


use Exception;

class RbacException extends Exception
{
    const NOT_RULE = 403;
    public static $errMsg = [
        RbacException::NOT_RULE => '您没有权限'
    ];

    public $errorMsg = "";
    public $errorNo = "";

    function __construct($errorNo, $msg="")
    {
        if($errorNo && $msg) {
            $this->errorNo   = $errorNo;
            $this->errorMsg    = $msg;

            parent::__construct($msg, $errorNo);
            return true;
        }
        $this->errorNo   = $errorNo;

        if(!empty($msg)) {
            $this->errorMsg  = $msg;
        } else {
            $this->errorMsg  = RbacException::$errMsg[$errorNo];
        }

        parent::__construct($msg);
    }


    public function getErrorMsg(){

        return $this->errorMsg;

    }


    public function getErrorNo() {
        return $this->errorNo;
    }



}
