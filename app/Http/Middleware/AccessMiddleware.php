<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Plugins\Helper;
use Plugins\Query;
use Plugins\Template;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $route = request()->route() ?? false;
        $action = $route->getAction();
        $action_code = $action['as'] ?? 'home';
        $action_controller = false;
        $action_route = $action['name'] ?? false;

        if (isset($action['controller'])) {

            $array_controller = explode('@', $action['controller']) ?? [];
            $action_controller = Helper::getTemplate($array_controller[0]);
        }

        $data = [
            'action_code' => $action_code,
            'template' => $action_controller,
            'route' => $action_route,
        ];

        share($data);
        $permision = Query::permision();

        // $checkPermision = $permision->contains(function($value) use($action_code){
        //     return $value->system_permision_code == $action_code &&
        //     $value->system_permision_role_code == auth()->user()->role;
        // });

        // if(!$checkPermision){
        //     abort(403, 'You are not autorize');
        // }

        Gate::define('allow', function ($user) use($action_code, $permision) {
           return $permision->contains('system_permision_code', $action_code);
        });

        // if (!Gate::check('allow')) {
        //     abort(403);
        // }

        try {
            share([
                // 'access' => Template::routes(),
                'filter' => Template::filter(),
                'groups' => Query::groups(true),
            ]);
        } catch (\Throwable$th) {
            //throw $th;
        }

        return $next($request);
    }
}
