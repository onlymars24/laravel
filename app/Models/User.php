<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public static function securityDataUpdate(Request $request, $id){
        $user = self::getOne($id);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public static function statusUpdate(Request $request, $id){
        $contact = self::getOne($id)->contact;
        $contact->status = $request->status;
        $contact->save();
    }

    public static function imageUpdate($img, $id)
    {
        $contact = self::getOne($id)->contact;
        if($contact->img != 'avatars/avatar-m.png'){
            Storage::delete($contact->img);
        }
        $img = $img->store('avatars');
        $contact->img = $img;
        $contact->save();
    }

    public static function addUser(Request $request)
    {
        $user = self::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);
        Contact::create([
            'user_id' => $user->id,
            'name' => $request->name,
        ]);
    }

    public static function deleteUser($id)
    {
        $user = self::getOne($id);
        $contact = $user->contact;
        $user->delete();
        $contact->delete();
    }

    public static function contactsUpdate(Request $request, $id)
    {
        $contact = self::getOne($id)->contact;
        $contact->fill($request->except(['_token', 'email', 'password', 'img']));
        $contact->user_id = $id;
        $contact->save();
    }

    public static function getOne($id)
    {
        return self::find($id);
    }
}
