<?php namespace App\Http\Middleware;

use App\Models\Model;
use Closure;

class RegisterGlobalViewVariable {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        view()->share('models', Model::get());
		return $next($request);
	}

}
