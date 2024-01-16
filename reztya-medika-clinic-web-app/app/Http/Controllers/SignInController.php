<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;


class SignInController extends Controller
{

    public function userLogout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }

    public function userLogin(Request $request) {
        if($request->all()) {
            $credentials = $request->validate([
                'email' => 'required|email:rfc,dns',
                'password' => 'required'
            ]);

            if(!RateLimiter::tooManyAttempts('failed', 3)) {
                if(Auth::attempt($credentials)) {
                    if(auth()->user()->hasVerifiedEmail()) {
                        if(!auth()->user()->is_banned) {
                            $remember_me = $request->remember_me;
                            if($remember_me) {
                                Cookie::queue('email', $request->email);
                                Cookie::queue('password', $request->password);
                            }

                            $request->session()->regenerate();

                            RateLimiter::resetAttempts('failed');
                            return redirect('/home')->with('success', 'Anda berhasil masuk!');
                        } else {
                            Auth::logout();
                            return redirect()->back()->with('loginError', 'Akun Anda telah diblokir! Silahkan kontak klinik!');
                        }
                    } else {
                        RateLimiter::hit('failed', 300);
                        $request->user()->sendEmailVerificationNotification();
                        return redirect(route('verification.notice'))->with('message', 'Link verifikasi telah dikirim! '.RateLimiter::retriesLeft('failed', 3).'x coba masuk lagi!');
                    }
                } else {
                    RateLimiter::hit('failed', 300);
                    return redirect()->back()->with('loginError', 'Informasi yang dimasukkan salah, '.RateLimiter::retriesLeft('failed', 3).'x coba lagi!');
                }
            } else {
                return redirect('/signin')->with('loginError', 'Terlalu banyak gagal memasukkan email / password! Harap tunggu '. round(RateLimiter::availableIn('failed') / 60) .' menit lagi untuk mencoba ulang!');
            }
        }
        return redirect()->back()->with('loginError', 'Masuk tidak berhasil!');
    }
}
