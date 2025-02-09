<?php

// app/Http/Middleware/RoleRedirect.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->role == 'superadmin') {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('dashboard.user');
        }
    }
}
