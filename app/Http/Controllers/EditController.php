<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Contact;

class EditController extends Controller
{
    public function form($id){
        $contact = User::getOne($id)->contact;
        return view('edit', ['contact' => $contact]);
    }
    
    public function handler($id, Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);
        User::contactsUpdate($request, $id);
        $request->session()->flash('flash', 'Контакты успешно изменены.');
        return redirect('/');
    }
} 