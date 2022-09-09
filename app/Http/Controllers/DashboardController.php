<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\peserta;
use App\Models\Soal;
use App\Models\Jawaban;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\time;
use DateTime;
use App\Models\Answer;
use App\Models\AnswerFile;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->role == 1){
            return view('admin.dashboard.index',[
                "times" => time::get(),
            ]);
        }
        else{
            $status = Auth::user()->status;
            if($status == 0) return view('peserta.prosesDaftar.upload');
            else if($status == 1) return view('peserta.prosesDaftar.waitAccPembayaran');
            else if($status == 2) return view('peserta.prosesDaftar.datadiri');
            else if($status == 3) return redirect('/biodata/1');
            else if($status == 4) return view('peserta.prosesDaftar.waitAccBiodata');
            else if($status == 5) return view('peserta.ujian.index');
            else if($status == 6){
                $now = new DateTime();
                $times = time::get();
                $selectedTime = new time();
                foreach($times as $time){
                    $checkTime = new DateTime($time->endTime);
                    if($now < $checkTime){
                        $selectedTime = $time;
                        break;
                    }
                }
                if($selectedTime->startTime){

                    $startSelectedTime = new DateTime($selectedTime->startTime);

                    if($now > $startSelectedTime){ //ujian dimulai
                        $endSelectedTime = new DateTime($selectedTime->endTime);
                        if($selectedTime->babak != 'Simulasi 2' && $selectedTime->babak != 'Penyisihan 2'){
                            $soals = Soal::get();

                            if($selectedTime->babak == 'Penyisihan1') $soals = Soal::where('babak', 'Penyisihan 1')->get();
                            else $soals = Soal::where('babak', $selectedTime->babak)->get();
                            if(!$request->soal) return redirect(strtok($_SERVER['REQUEST_URI'], '?').'?soal=1');
                            else if($request->soal < 1) return redirect(strtok($_SERVER['REQUEST_URI'], '?').'?soal=1');
                            else if($request->soal > $soals->count()) return redirect(strtok($_SERVER['REQUEST_URI'], '?').'?soal='.$soals->count());

                            return view('ujian', [
                                'soals' => $soals,
                                'soal' => $soals->slice($request->soal-1, 1)->first(),
                                'req' => $request,
                                'time' => $selectedTime,
                                'interval' => $now->diff($endSelectedTime),
                                'answers' => Answer::where('user_id', Auth::user()->id)->where('babak', $selectedTime->babak)->get(),
                            ]);
                        }
                        else{
                            return view('ujian2', [
                                'req' => $request,
                                'time' => $selectedTime,
                                'interval' => $now->diff($endSelectedTime),
                                'answer' => AnswerFile::where('user_id', Auth::user()->id)->where('babak', $selectedTime->babak)->first()
                            ]);
                        }
                    }
                    else{ //menunggu
                        // dd($now->diff($startSelectedTime));
                        return view('peserta.ujian.index2', [
                            'time' => $selectedTime,
                            'interval' => $now->diff($startSelectedTime)
                        ]);
                    }
                }
                else{
                    return view('peserta.ujian.done');
                }
            }
        }
    }
    public function pembayaran(Request $request)
    {
        if(Auth::user()->role == 1){
            $users = User::where('status', '1')->get()->merge(User::where('role', '=', '0')->where('status', '!=', '1')->orderBy('status', 'DESC')->get());
            return view('admin.pembayaran.index', [
                'users' => $users,
                'request' => $request
            ]);
        }
        else{
            return redirect('/');
        }
    }
    public function accPembayaran(Request $request)
    {
        if(Auth::user()->role == 1){
            $user = User::where('id', '=', $request->user_id)->first();
            $user->status = 2;
            $user->save();
            return redirect('/pembayaran');
        }
        else{
            return redirect('/');
        }
    }

    public function uploadBuktiBayar(Request $request){
        $validated = $request->validate([
            'file' => 'image|file|max:1024'
        ]);
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->bukti_pembayaran = $request->file('file')->store('bukti_pembayaran');
        $user->status = 1;
        $user->save();
        return redirect('/dashboard');
    }
    public function updateBuktiBayar(Request $request){
        $validated = $request->validate([
            'file' => 'image|file|max:1024'
        ]);
        $user = User::where('id', '=', Auth::user()->id)->first();
        Storage::delete($user->bukti_pembayaran);
        $user->bukti_pembayaran = $request->file('file')->store('bukti_pembayaran');
        $user->status = 1;
        $user->save();
        return redirect('/dashboard');
    }
}
