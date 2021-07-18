<?php

namespace App\Providers;

use App\Models\Setting;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
// use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Blade::if('authcheck', function () {
            return Auth::user() == true;
        });
        Blade::if('notauth', function () {
            return Auth::user() == false;
        });
        Blade::if('verified', function () {
            return Auth::user() == true && !Auth::user()->email_verified_at == null;
        });
        Blade::if('admin', function () {
            return Auth::user() == true && Auth::user()->role == 'Admin';
        });
        Blade::if('moderator', function () {
            return Auth::user() == true && in_array(Auth::user()->role, ['Admin','Moderator']);
        });
        Blade::if('staff', function () {
            return Auth::user() == true && in_array(Auth::user()->role, ['Admin','Moderator','Staff']);
        });
        Blade::if('member', function () {
            return Auth::user() == true && in_array(Auth::user()->role, ['Admin','Moderator','Staff','Member']);
        });

        if (Schema::hasTable('settings')) {
            foreach (Setting::all() as $setting) {
                Config::set('setting.'.$setting->name, $setting->value);
            }
        }
    }
}
