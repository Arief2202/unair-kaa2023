<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public function check(){
        return Jawaban::where('id', $this->jawaban_id)->first()->is_correct;
    }
}
