<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;

class AdminPermissionMiddleware
{
    private $admin;


    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permision)
    {

        if (!$this->admin->canUse($permision)) {
            abort(403, 'У Вас нет прав использовать этот раздел');
        }
        return $next($request);
    }
}
