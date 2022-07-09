<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position', 'phone', 'address', 'user_id',];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}