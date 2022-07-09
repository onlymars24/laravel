<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
