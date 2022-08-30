<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function getUser(){
        return User::where('id', '=', $this->user_id)->get();
    }
}
