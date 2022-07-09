<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;

class UsersController extends Controller
{
    public function page(Request $request){
        $contacts = Contact::all();
        $flash = $request->session()->get('flash');
        return view('users', ['contacts' => $contacts, 'flash' => $flash]);
    }
}
