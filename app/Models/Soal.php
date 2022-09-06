<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function jawaban(){
        return Jawaban::where('soal_id', $this->id)->get();
    }

    public function jawabanSecure(){
        return Jawaban::where('soal_id', $this->id)->select('id', 'jawaban')->get();
    }
}
