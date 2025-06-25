<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Absensi extends Model
{

    protected $table = 'absensi';

     protected $fillable = [
         'users_id',
         'created_at'
    ];

    protected $hidden = [
        'users_id',
        'updated_at'
    ];

     public function user() {
         return $this->belongsTo(User::class, 'users_id', 'id');
     }
}
