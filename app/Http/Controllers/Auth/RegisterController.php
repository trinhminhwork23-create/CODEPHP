<?php

namespace App\Http\Controllers\Auth;

class RegisterController
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register()
    {
        //
    }
}
