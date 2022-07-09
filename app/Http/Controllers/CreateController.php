<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;

class CreateController extends Controller
{
    public function form(){
        return view('create');
    }
    
    public function handler(Request $request){
        $this->validate($request, [
            'email' => 'bail|required|unique:users',
            'password' => 'bail|required|between:5,10',
            'name' => 'required',
            'img' => 'image',
        ]);
        User::addUser($request);
        User::contactsUpdate($request, $id);
        if($request->has('img')){
            User::imageUpdate($request->file('img'), $id);
        }
        $contact->save();
        $request->session()->flash('flash', 'Пользователь успешно добавлен.');
        return redirect('/');
    }
}
