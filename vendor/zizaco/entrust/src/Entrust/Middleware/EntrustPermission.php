<?php namespace Zizaco\Entrust\Middleware;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;

class EntrustPermission
{
	protected $auth;

	/**
	 * Creates a new instance of the middleware.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  Closure $next
	 * @param  $permissions
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permissions)
	{
	    $permission_user = $request->user()->permissions->pluck('name')->toArray();
	    /*
		if ($this->auth->guest() || !$request->user()->can(explode('|', $permissions))) {
			abort(403);
		}*/
        $arr_permissions = explode('|', $permissions);
        $result = array_intersect($permission_user,$arr_permissions);

	    if($this->auth->guest() || sizeof($result)<= 0) {
	        if($request->ajax()) {
	           return response()->json(['status'=> 403 ]);
            }else
            abort(403);

        }
		return $next($request);
	}
}
