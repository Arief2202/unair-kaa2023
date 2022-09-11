<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\AnswerFile;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\Soal;
use App\Models\User;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        if($request->jawaban_id){
            $model = Answer::where('user_id', Auth::user()->id)->where('soal_id', $request->soal_id)->first();
            if(!$model){
                $model = new Answer();
            }
            $model->ragu = false;
            if(isset($request->ragu)) $model->ragu = true;
            if(isset($request->raguEnd)) $model->ragu = true;

            $model->babak = $request->babak;
            $model->user_id = Auth::user()->id;
            $model->soal_id = $request->soal_id;
            $model->jawaban_id = $request->jawaban_id;
            $model->save();
        }
        if(isset($request->raguEnd) || isset($request->end)) return redirect($request->uri.'?soal='.(int)$request->soal_number);
        else return redirect($request->uri.'?soal='.((int)$request->soal_number)+1);
    }
    public function upload(Request $request){
        $model = AnswerFile::where('user_id', Auth::user()->id)->where('babak', $request->babak)->first();
        if(!$model) $model = new AnswerFile();
        $model->babak = $request->babak;
        $model->user_id = Auth::user()->id;
        if(isset($model->jawaban)) Storage::delete($model->jawaban);
        if($request->babak == "Simulasi 2") $model->jawaban = $request->file('jawaban')->storeAs('jawaban_simulasi', Auth::user()->email.'.xlsx');
        if($request->babak == "Penyisihan 2") $model->jawaban = $request->file('jawaban')->storeAs('jawaban', Auth::user()->email.'.xlsx');
        $model->save();
        return redirect($request->uri);
    }

    public function nilai($sublink, Request $request){
        if(Auth::user()->role != 1) return redirect('/dashboard');
        $babak = "";
        if($sublink != "penyisihan2" && $sublink != "simulasi2"){
            if($sublink == "simulasi") $babak = "Simulasi";
            else if($sublink == "preliminary") $babak = "Preliminary";
            else if($sublink == "penyisihan1") $babak = "Penyisihan 1";
            else return redirect('/nilai/preliminary');
            $scores = null;
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
                $scores[$index] = (object) [
                        "user" => (object)$user->toArray(),
                        "true" => $true,
                        "false" => $false,
                        "empty" => $empty,
                        "score" => $score,
                ];
            }
            $scores = collect($scores)->sortByDesc('score');
            return view('admin.nilai.index', [
                'babak' => $babak,
                'scores' => $scores,
            ]);
        }
        else{
            if($sublink == "simulasi2") $babak = "Simulasi 2";
            else if($sublink == "penyisihan2") $babak = "Penyisihan 2";
            return view('admin.nilai.penyisihan2', [
                'babak' => $babak,
                'users' => User::where('role', '!=', 1)->get(),
                'answers' => AnswerFile::where('babak', $babak)->get(),
            ]);
        }
    }
    public function updateNilai(Request $request){
        if(Auth::user()->role != 1) return redirect('/dashboard');
        $model = AnswerFile::where('id', $request->answer_id)->first();
        $model->score = $request->nilai;
        $model->save();
        return redirect($request->uri);
    }
}
