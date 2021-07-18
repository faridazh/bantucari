<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        return view('index', [
            'pagetitle' => 'Beranda',
            'pagedesc' => 'Halaman Utama',
            'pageid' => 'home',
            'posts' => Post::select('id','cat_id','case_code','verify','created_at')
                            ->where('verify', 'Approved')
                            ->where('status', 'Hilang')
                            ->orderBy('created_at', 'desc')
                            ->limit(4)->get(),
        ]);
    }

    public function about()
    {
        return view('about', [
            'pagetitle' => 'Tentang Web',
            'pagedesc' => '',
            'pageid' => 'about',
        ]);
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function verifyEmail()
    {
        if (Auth::user()->email_verified_at == null) {
            Alert::warning('Verifikasi Email', 'Silakan cek email anda untuk verifikasi email');
            return redirect()->route('home')->with('verify-email', 'Lakukan verifikasi email anda!');
        }

        Alert::success('Verifikasi Email', 'Email anda sudah terverifikasi');
        return redirect()->route('home');
    }

    public function verifyEmailHandler(EmailVerificationRequest $request)
    {
        if (Auth::user()->email_verified_at == null) {
            $request->fulfill();

            Alert::success('Verifikasi Email', 'Email berhasil diverfikasi');
            return redirect()->route('home');
        }

        Alert::success('Verifikasi Email', 'Email anda sudah terverifikasi');
        return redirect()->route('home');
    }

    public function ResendVerifEmail(Request $request)
    {
        if (Auth::user()->email_verified_at == null) {
            $request->user()->sendEmailVerificationNotification();

            Alert::info('Verifikasi Email', 'Link verifikasi berhasil dikirimkan ke email anda');
            return redirect()->route('home');
        }

        Alert::success('Verifikasi Email', 'Email anda sudah terverifikasi');
        return redirect()->route('home');
    }
}
