<?php

function ajaxSuccess(array $data = [], $meta = '', string $msg = 'success', int $httpCode = 200)
{
    $return = [
        'code' => 0,
        'msg' => $msg,
        'data' => $data,
        'meta' => $meta
    ];
    return response()->json($return, $httpCode);
}

function ajaxError(string $errMsg = 'error', int $httpCode = 200)
{
    $return = [
        'code' => 1,
        'exception' => $errMsg
    ];
    return response()->json($return, $httpCode);
}
