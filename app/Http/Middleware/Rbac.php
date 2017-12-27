<?php

namespace App\Http\Middleware;

use App\Exceptions\RbacException;
use App\Model\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Rbac
{
    protected $prefix = 'App\\Http\\Controllers\\Admin\\';
    protected $rulesCacheKey = 'rules_cache_v1';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentRule = $this->getCurrentRule();
        $rules = $this->getRules();
        if (!in_array($currentRule, $rules))
        throw new RbacException(RbacException::NOT_RULE);
        return $next($request);
    }

    public function getCurrentRule()
    {
        $origRule = Route::current()->getActionName();
        $rule = substr($origRule, strlen($this->prefix));
        return strtolower($rule);
    }

    public function getRules()
    {
        $id = Auth::guard('admin')->id();
        if (!$id) return [];
        $admin = new Admin();
        return $admin->getAdminRules($id);
    }
}
