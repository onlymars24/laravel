<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;

class ImageController extends Controller
{
    public function form($id){
        $contact = User::getOne($id)->contact;
        return view('image', ['contact' => $contact]);
    }

    public function handler($id, Request $request){
        $this->validate($request, [
            'img' => 'bail|required|image',
        ]);
        User::imageUpdate($request->file('img'), $id);
        $request->session()->flash('flash', 'Аватар успешно изменен.');
        return redirect('/');
    }
}
