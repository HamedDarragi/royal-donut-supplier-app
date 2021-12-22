<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        if (auth()->user()->hasRole('Customer')) {
            return redirect()->intended(RouteServiceProvider::CUSTOMER);
        } else if (auth()->user()->hasRole('Supplier')) {
            return redirect()->intended(RouteServiceProvider::SUPPLIER);
        } else if (auth()->user()->hasRole('Admin')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }else if (auth()->user()->hasRole('SuperAdmin')) {
            // dd(auth()->user()->hasRole('SuperAdmin'));
            
            return redirect()->intended(RouteServiceProvider::HOME);
        } else{
            dd('failed');
        }
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
