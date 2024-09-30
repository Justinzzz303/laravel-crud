<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request) {
        // Correct the spelling here to "incomingFields"
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);
        // Correct the variable name here as well
        if(auth()->attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/');
        }

        // Handle failed login attempt
        return back()->withErrors(['loginfailed' => 'Invalid login details']);
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function register(Request $request) {
        // Correct the spelling here as well
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:10', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:24'],
        ]);

        // Hash the password
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Create user and log them in
        $user = User::create($incomingFields);
        auth()->login($user);

        return redirect('/');
    }
}
