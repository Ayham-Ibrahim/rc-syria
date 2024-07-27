<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userInfo = $request->route('userInfo');

        if (!Auth::check()) {
            return response()->json(['error' => 'not authenticated',403]);
        }

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if ($user->id === $userInfo->user_id ) {
            return $next($request);
        }else{
            return response()->json(['error' => 'Unauthorized,You are not the Owner'], 403);
        }
        
    }
}
