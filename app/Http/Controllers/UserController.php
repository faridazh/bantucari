<?php

namespace App\Http\Controllers;

use Image;
use QrCode;

use App\Models\Post;
use App\Models\User;

use App\Models\ReportCategory;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;

// use Auth; // or
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function login()
    {
        return view('users.login', [
            'pagetitle' => 'Masuk',
            'pagedesc' => '',
            'pageid' => 'login',
        ]);
    }

    public function postlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            Alert::toast('Silahkan periksa kembali email/password anda!', 'error');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = $request->rememberMe;

        if(Auth::attempt($credentials, $remember))
        {
            Alert::toast('Anda berhasil masuk!', 'success');
            return (request()->header('referer')) ? redirect()->route('home') : redirect()->back();
        }

        Alert::toast('Silahkan periksa kembali email/password anda!', 'error');
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::toast('Anda berhasil keluar!', 'success');
        return redirect()->route('home');
    }

    public function register()
    {
        $maxsize = config('setting.user_avatar_size');
        $maxwidth = config('setting.user_avatar_width');
        $maxheight = config('setting.user_avatar_height');

        return view('users.register', [
            'pagetitle' => 'Daftar',
            'pagedesc' => 'Mendaftar sebagai anggota',
            'pageid' => 'register',
            'maxsize' => $maxsize.'KB',
            'maxdimensions' => $maxwidth.'x'.$maxheight.'px',
        ]);
    }

    public function postregister(Request $request)
    {
        $maxsize = config('setting.user_avatar_size');
        $maxwidth = config('setting.user_avatar_width');
        $maxheight = config('setting.user_avatar_height');

        $request->validate([
            'username' => 'required|alpha_num|min:5|max:30|unique:users,username',
            'fullname' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'birthdate' => 'required|date',
            'phone' => 'nullable|numeric|digits_between:8,15',
            'address' => 'nullable|string',
            'states' => 'nullable|in:Aceh,Bali,Banten,Bengkulu,Gorontalo,Jakarta,Jambi,Jawa Barat,Jawa Tengah,Jawa Timur,Kalimantan Barat,Kalimantan Tengah,Kalimantan Timur,Kalimantan Utara,Kepulauan Bangka Belitung,Kepulauan Riau,Lampung,Maluku,Maluku Utara,Nusa Tenggara Barat,Nusa Tenggara Timur,Papua,Papua Barat,Provinsi Kalimantan Selatan,Provinsi Sulawesi Selatan,Riau,Sulawesi Barat,Sulawesi Tengah,Sulawesi Tenggara,Sulawesi Utara,Sumatera Barat,Sumatera Selatan,Sumatera Utara,Yogyakarta',
            'zipcode' => 'nullable|numeric|digits:5',
            // 'avatar' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,webp|image|max:'.$maxsize.'|dimensions:min_width=100,min_height=100,max_width='.$maxwidth.',max_height='.$maxheight,
            'avatar' => 'nullable|image',
            'captcha' => 'required|captcha',
        ]);

        DB::transaction(function() use($request, $maxwidth, $maxheight) {
            if ($request->hasfile('avatar'))
            {
                if (!empty(Auth::user()->avatar))
                {
                    Storage::disk('public')->delete('uploads/avatars/' . Auth::user()->avatar);
                }

                $img = Image::make($request->file('avatar'));

                if ($img->width() > $maxwidth) {
                    $img->resize($maxwidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                elseif ($img->height() > $maxheight) {
                    $img->resize(null, $maxheight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                else {
                    $img->resize($maxwidth, $maxheight, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                $avatar_name = Auth::user()->username . '_' . date('Ymdhis', time()) . '.' . $request->file('avatar')->extension();
                // $request->file('avatar')->storeAs('uploads/avatars/', $avatar_name, 'public');
                $img->save(public_path('uploads/avatars/'.$avatar_name));
            }
            else
            {
                $avatar_name = Auth::user()->avatar;
            }

            $user = User::create([
                        'username' => $request->username,
                        'name' => $request->fullname,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'birthdate' => $request->birthdate,
                        'phone' => $request->phone * 1,
                        'avatar' => $avatar_name,
                        'address' => Crypt::encryptString($request->address),
                        'states' => $request->states,
                        'zipcode' => $request->zipcode,
                        'remember_token' => Str::random(60),
                    ]);

            Auth::login($user);

            // Verivikasi Email Sender
            event(new Registered($user));
        });

        Alert::toast('Akun berhasil didaftarkan!', 'success');
        return redirect()->route('home');
    }

    public function controlPanel()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if (!$user->address == null) {
            $decryptAddress = Crypt::decryptString($user->address);
        }
        else {
            $decryptAddress = $user->address;
        }

        $maxsize = config('setting.user_avatar_size');
        $maxwidth = config('setting.user_avatar_width');
        $maxheight = config('setting.user_avatar_height');

        return view('users.setting', [
            'pagetitle' => 'Pengaturan',
            'pagedesc' => '',
            'pageid' => 'control-panel',
            'maxsize' => $maxsize.'KB',
            'maxdimensions' => $maxwidth.'x'.$maxheight.'px',
            'user' => $user,
            'decryptAddress' => $decryptAddress,
        ]);
    }

    public function edit_controlPanel(Request $request)
    {
        $maxsize = config('setting.user_avatar_size');
        $maxwidth = config('setting.user_avatar_width');
        $maxheight = config('setting.user_avatar_height');

        if (Auth::user()->email != $request->email) {
            $request->validate([
                'email' => 'required|email|max:255|unique:users,email',
            ]);
        }

        $request->validate([
            'fullname' => 'required|string|min:5|max:255',
            'birthdate' => 'required|date',
            'phone' => 'nullable|numeric|digits_between:8,15',
            'address' => 'nullable|string',
            'states' => 'nullable|in:Aceh,Bali,Banten,Bengkulu,Gorontalo,Jakarta,Jambi,Jawa Barat,Jawa Tengah,Jawa Timur,Kalimantan Barat,Kalimantan Tengah,Kalimantan Timur,Kalimantan Utara,Kepulauan Bangka Belitung,Kepulauan Riau,Lampung,Maluku,Maluku Utara,Nusa Tenggara Barat,Nusa Tenggara Timur,Papua,Papua Barat,Provinsi Kalimantan Selatan,Provinsi Sulawesi Selatan,Riau,Sulawesi Barat,Sulawesi Tengah,Sulawesi Tenggara,Sulawesi Utara,Sumatera Barat,Sumatera Selatan,Sumatera Utara,Yogyakarta',
            'zipcode' => 'nullable|numeric|digits:5',
            // 'avatar' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,webp|image|max:'.$maxsize.'|dimensions:min_width=100,min_height=100,max_width='.$maxwidth.',max_height='.$maxheight,
            'avatar' => 'nullable|image',
            'captcha' => 'required|captcha',
        ]);

        DB::transaction(function() use($request, $maxwidth, $maxheight) {
            if ($request->hasfile('avatar'))
            {
                if (!empty(Auth::user()->avatar))
                {
                    Storage::disk('public')->delete('uploads/avatars/' . Auth::user()->avatar);
                }

                $img = Image::make($request->file('avatar'));

                if ($img->width() > $maxwidth) {
                    $img->resize($maxwidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                elseif ($img->height() > $maxheight) {
                    $img->resize(null, $maxheight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                else {
                    $img->resize($maxwidth, $maxheight, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                $avatar_name = Auth::user()->username . '_' . date('Ymdhis', time()) . '.' . $request->file('avatar')->extension();
                // $request->file('avatar')->storeAs('uploads/avatars/', $avatar_name, 'public');
                $img->save(public_path('uploads/avatars/'.$avatar_name));
            }
            else
            {
                $avatar_name = Auth::user()->avatar;
            }

            User::where('id', Auth::user()->id)
                    ->update([
                        'name' => $request->fullname,
                        'email' => $request->email,
                        'birthdate' => $request->birthdate,
                        'phone' => $request->phone * 1,
                        'address' => Crypt::encryptString($request->address),
                        'states' => $request->states,
                        'zipcode' => $request->zipcode,
                        'avatar' => $avatar_name,
                    ]);
        });

        Alert::toast('Akun berhasil diperbarui!', 'success');
        return redirect()->route('user_editpengaturan');
    }

    public function userProfile($username)
    {
        $user = User::where('username', $username)->first();

        if ($user == null && Auth::check()) {
            Alert::toast('Error, member tidak ada!', 'error');
            return redirect()->route('user_profile', Auth::user()->username);
        }
        elseif ($user == null) {
            return abort(404);
        }

        if (Auth::guest() || $user->id != Auth::user()->id) {
            $posts = User::find($user->id)->posts()->where('verify', 'Approved');
            $post_count = User::find($user->id)->posts()->where('verify', 'Approved')->count();
        }
        elseif ($user->id == Auth::user()->id) {
            $posts = User::find($user->id)->posts();
            $post_count = User::find($user->id)->posts()->count();
        }

        // foreach ($posts as $post) {
        //     $data[] = [
        //         'name' => $post->user->name,
        //         'case_code' => $post->case_code,
        //         'case_name' => $post->laporan($post->cat_id)->fullname,
        //         'cat_id' => $post->cat_id,
        //         'category' => $post->kategori->cat_name,
        //         'post_count' => $post->count(),
        //         'post_hilang' => $post->where('status', 'Hilang')->count(),
        //         'post_temu' => $post->where('status', 'Ditemukan')->count(),
        //     ];
        // }
        //
        // dd($data);

        return view('users.profile', [
            'pagetitle' => 'Tentang Saya',
            'pagedesc' => '@'.$user->username.' - '.$user->name,
            'pageid' => 'profile-page',
            'user' => $user,
            'posts' => $posts->paginate(8),
            'post_count' => $post_count,
            'report_cats' => ReportCategory::whereIn('cat_for', ['Member', 'Both'])->get(),
        ]);
    }

    public function lupaPassword()
    {
        return view('users.password.forgot', [
            'pagetitle' => 'Lupa Password',
            'pagedesc' => '',
            'pageid' => 'forgot-password',
        ]);
    }

    public function kirimResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            Alert::toast(__($status), 'success');
            return redirect()->back();
        }
        else {
            Alert::toast(__($status),'error');
            return redirect()->back();
        }
    }

    public function perbaruiPassword_errorHandler()
    {
        return redirect()->route('home');
    }

    public function perbaruiPassword(Request $request, $token)
    {
        return view('users.password.reset', [
            'pagetitle' => 'Reset Password',
            'pagedesc' => '',
            'pageid' => 'reset-password',
            'token' => $token,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Alert::toast(__($status), 'success');
            return redirect()->route('login');
        }
        else {
            Alert::toast(__($status),'error');
            return redirect()->back();
        }
    }
}
