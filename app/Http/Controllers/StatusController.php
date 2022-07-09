<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;

class StatusController extends Controller
{
    public function form($id){
        $contact = User::getOne($id)->contact;
        return view('status', ['contact' => $contact]);
    }

    public function handler(Request $request, $id){
        User::statusUpdate($request, $id);
        $request->session()->flash('flash', 'Статус успешно изменён.');
        return redirect('/');
    }
}
