<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CekRole
{
    /**
     * Informasi Roles
     *
     * Admin
     * Moderator
     * Staff
     * Member
     * Banned
     *
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $roles = [
            'admin' => ['Admin'],
            'moderator' => ['Admin','Moderator'],
            'staff' => ['Admin','Moderator','Staff'],
            'member' => ['Admin','Moderator','Staff','Member'],
        ];

        if (!Auth::check()) {
            Alert::toast('Silakan login!', 'error');
            return route('login');
        }

        if(Auth::user()->role == 'Banned')
        {
            Alert::error('Banned', 'Akun anda telah dibanned!');
            return route('user_profile', Auth::user()->username);
        }

        if(in_array(Auth::user()->role, $roles[$role]))
        {
            return $next($request);
        }

        Alert::toast('Anda tidak mempunyai akses!', 'error');
        return route('home');
    }
}
