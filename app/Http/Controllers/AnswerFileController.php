<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\AnswerFile;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use App\Models\Soal;
use App\Models\User;

use App\Exports\ScoreExport;
use Maatwebsite\Excel\Facades\Excel;

class AnswerFileController extends Controller
{

    public function export($babak){
        return Excel::download(new ScoreExport($babak), $babak.'.xlsx');
    }
}
