<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Models\User;

class UserController extends Controller
{
    public function list()
    {
        return view('front.User.users_list');
    }
}
