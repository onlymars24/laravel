<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function form(Request $request){
        $flash = $request->session()->get('flash');
        return view('login', ['flash' => $flash]);
    }
    
    public function handler(Request $request){
        if (!Auth::attempt($request->except('remember', '_token'), $request->has('remember'))) {
            $request->session()->flash('flash', 'Неправильный логин или пароль.');
            return redirect()->route('login');
        }
        return redirect('/');
    }
}
