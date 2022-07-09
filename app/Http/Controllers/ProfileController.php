<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;

class ProfileController extends Controller
{
    public function page($id){
        $contact = User::getOne($id)->contact;
        return view('profile', ['contact' => $contact]);
    }
}
