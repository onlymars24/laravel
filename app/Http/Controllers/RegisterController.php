<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;

class RegisterController extends Controller
{
    public function form(){
        return view('register');
    }

    public function handler(Request $request){
        $this->validate($request, [
            'email' => 'bail|required|unique:users',
            'password' => 'bail|required|between:5,10',
            'name' => 'required',
        ]);
        User::addUser($request);
        return redirect()->route('login');
    }
}
