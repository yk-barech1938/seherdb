<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\District;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $districts = District::all();

        return view('auth.register',compact('districts'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'district' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'district_id'=>$request->input('district'),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        if ($user->status === 'active') {
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        } else {
            // User is inactive, do not log them in, redirect back to login page
            return redirect()->route('login')->with('status', 'Your account is registered. To activate your account please contact admin myounas.ce@gmail.com');
        }

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }
}
