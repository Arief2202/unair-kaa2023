<?php

namespace App\Exports;

use App\Models\Answer;
use App\Models\AnswerFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Soal;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ScoreExport implements FromCollection, ShouldAutoSize
{
    protected $babak;

    public function __construct(String $babak)
    {
        $this->babak = $babak;
    }
    public function collection()
    {
        // dd($this->babak);
        $babak = "";
        if($this->babak != "penyisihan2" && $this->babak != "simulasi2"){
            if($this->babak == "simulasi") $babak = "Simulasi";
            else if($this->babak == "preliminary") $babak = "Preliminary";
            else if($this->babak == "penyisihan1") $babak = "Penyisihan 1";
            else return redirect('/nilai/preliminary');
            $scores = null;
            $scores[0] = (object) [
                "nama" => "Nama",
                "no_telp" => "No Telp",
                "email" => "Email",
                "true" => "Betul",
                "false" => "Salah",
                "empty" => "Kosong",
                "score" => "Nilai",
            ];
            foreach(User::where('role', '!=', 1)->get() as $index=>$user){
                $answerUsers = Answer::where('babak', $babak)->where('user_id', $user->id)->get();
                $true = 0;
                $false = 0;
                $empty = Soal::where('babak', $babak)->get()->count() - ($answerUsers->count());
                $score = 0;
                foreach($answerUsers as $answer){
                    if($answer->check()){
                        $true++;
                        $score+=4;
                    }
                    else{
                        $false++;
                        $score-=1;
                    }
                }
                $scores[($index)+1] = (object) [
                        "nama" => $user->nama,
                        "no_telp" => (string)$user->telp,
                        "email" => $user->email,
                        "true" => (string)$true,
                        "false" => (string)$false,
                        "empty" => (string)$empty,
                        "score" => (string)$score,
                ];
            }
            $scores = collect($scores)->sortByDesc('score');
            return $scores;
        }
        else{
            if($this->babak == "simulasi2") $babak = "Simulasi 2";
            else if($this->babak == "penyisihan2") $babak = "Penyisihan 2";

            $scores = null;
            $scores[0] = (object) [
                "nama" => "Nama",
                "no_telp" => "No Telp",
                "email" => "Email",
                "score" => "Nilai",
            ];

            foreach(User::where('role', '!=', 1)->get() as $index=>$user){
                $answerUsers = AnswerFile::where('babak', $babak)->where('user_id', $user->id)->first();
                if(!$answerUsers){
                    $answerUsers = new AnswerFile();
                    $answerUsers->score = 0;
                }
                $scores[($index)+1] = (object) [
                        "nama" => $user->nama,
                        "no_telp" => (string)$user->telp,
                        "email" => $user->email,
                        "score" => (string)$answerUsers->score,
                ];
            }
            $scores = collect($scores)->sortByDesc('score');
            return $scores;
            return view('admin.nilai.penyisihan2', [
                'babak' => $babak,
                'scores' => $scores,
            ]);
        }
    }
}
