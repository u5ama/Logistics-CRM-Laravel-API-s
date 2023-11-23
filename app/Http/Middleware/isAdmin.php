<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param String $authCheck
     * @return mixed
     */
    public function handle(Request $request, Closure $next,String $authCheck)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user){
            if($authCheck=="superAdmin" && $user->user_type != '1'){

                abort(403);
            }
            if($authCheck=="accounts" && $user->user_type != '2'){

                abort(403);
            }
            if($authCheck=="allocators" && $user->user_type != '3'){

                abort(403);
            }
            if($authCheck=="sales" && $user->user_type != '4'){

                abort(403);
            }
            if($authCheck=="drivers" && $user->user_type != '5'){

                abort(403);
            }
            if($authCheck=="safetyOfficer" && $user->user_type != '6'){

                abort(403);
            }
            if($authCheck=="user" && $user->user_type != 0){

                abort(403);
            }

            return $next($request);
        }
    }
}
