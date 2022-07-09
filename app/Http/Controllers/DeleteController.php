<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function delete($id){
        User::deleteUser($id);
        if(Auth::id() == $id){
            Auth::logout();
            return redirect()->route('login');
        }
        return redirect('/');
    }
}
