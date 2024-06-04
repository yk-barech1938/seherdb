<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Fortify\Contracts\LoginResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
    
        $user = $request->user();

        $request->session()->regenerate();
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('login')->with('error', "To activate your account please contact admin: \nykbarech@gmail.com.");
        }
        $url ='';
        if($request->user()->role ==='admin'){
            $url= 'admin/dashboard';

        }elseif($request->user()->role ==='agent'){
            $url= 'agent/dashboard';
        }
        elseif($request->user()->role ==='user'){
            $url= '/dashboard';
        }
         // return redirect()->intended(RouteServiceProvider::HOME);
         return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
