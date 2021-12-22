<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->image != null) {
            $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images\\' . $model), $imageName);
        } else
            $imageName = null;

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'image' => $imageName,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $user->assignRole('Admin');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_name' => 'required',
        ]);
        if ($request->image != null) {
            $imageName = time() . rand(1, 10000) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images\\User'), $imageName);
        } else {
            $user = User::find($id);
            $imageName = $user->image;
        }

        $user = User::where('id', $id)->update([
            'user_name' => $request->user_name,
            'image' => $imageName
        ]);


        return back();
    }
}
