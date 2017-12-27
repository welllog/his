<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\Redis;

class TestController
{
    public function test()
    {
        var_dump(ajaxSuccess([], '', 202));
    }
}