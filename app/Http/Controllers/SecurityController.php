<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function form($id){
        $user = User::getOne($id);
        return view('security', ['user' => $user]);
    }
    
    public function handler($id, Request $request){
        $user = User::find($id);
        $validation = [
            'password' => 'bail|required|between:5,10|confirmed',
            'password_confirmation' => 'bail|required',
        ];
        if($user->email != $request->email){
            $validation['email'] = 'bail|required|unique:users';
        }
        $this->validate($request, $validation);
        User::securityDataUpdate($request, $id);
        $request->session()->flash('flash', 'Данные авторизации успешно изменены.');
        return redirect('/');
    }
}
