<?php namespace App\Http\Middleware;

use Closure;

class CRUDMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $request->merge([
            'creatable' => $request->has('creatable'),
            'editable'  => $request->has('editable'),
            'listable'  => $request->has('listable'),
            'slug'      => str_slug($request->get('table_name')),
        ]);
		return $next($request);
	}

}
