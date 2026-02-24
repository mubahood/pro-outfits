<?php

namespace App\Http\Middleware;

use App\Models\Utils;
use Closure;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // For development testing, let's use a default user ID
        // Get user ID from headers (like the frontend sends)
        $user_id = 0;
        
        // Check multiple header names to match frontend implementation
        if ($request->header('User-Id')) {
            $user_id = (int) $request->header('User-Id');
        } elseif ($request->header('HTTP_USER_ID')) {
            $user_id = (int) $request->header('HTTP_USER_ID');
        } elseif ($request->header('user_id')) {
            $user_id = (int) $request->header('user_id');
        }

        // For development, use a default user ID if none provided
        if ($user_id < 1) {
            // Set a default user ID for testing (adjust this to match a real user in your database)
            $user_id = 1; // or whatever user ID exists in your administrators table
        }

        // Find the user
        $u = Administrator::find($user_id);
        if ($u == null) {
            return response()->json([
                'code' => 0,
                'message' => 'User not found with ID: ' . $user_id,
                'data' => null
            ], 401);
        }

        // Add user to request for controller access
        $request->user = $user_id;
        $request->userModel = $u;

        return $next($request);
    }
}
