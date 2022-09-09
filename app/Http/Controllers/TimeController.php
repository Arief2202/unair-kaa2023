<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\time;
use Illuminate\Http\Request;
use DateTime;

class TimeController extends Controller
{
    public function getTimes()
    {
        return response()
            ->json(
                [
                    'success' => true,
                    'time' => time::get(),
                ],
                200
            )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    public function getTime()
    {
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

        return response()
            ->json(
                [
                    'success' => true,
                    'server_time' => new DateTime(),
                    'time' => $selectedTime,
                ],
                200
            )
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    public function setTime($babak, Request $request)
    {
        if (Auth::user()->role != 1) return redirect('/dashboard');
        $time = new time();
        if($babak == 'Penyisihan1') $time->babak = "Penyisihan 1";
        else if($babak == 'Penyisihan2') $time->babak = "Penyisihan 1";
        else if($babak == 'Simulasi2') $time->babak = "Simulasi 2";
        else $time->babak = $babak;
        $time->startTime = $request->startTime;
        $time->endTime = $request->endTime;
        $time->save();
        return redirect('/');
    }
    public function updateTime($babak, Request $request)
    {
        if($babak == 'Penyisihan1') $babak = "Penyisihan 1";
        else if($babak == 'Penyisihan2') $babak = "Penyisihan 2";
        else if($babak == 'Simulasi2') $babak = "Simulasi 2";
        if (Auth::user()->role != 1) return redirect('/dashboard');
        $time = time::where('babak', $babak)->first();
        $time->babak = $babak;
        $time->startTime = $request->startTime;
        $time->endTime = $request->endTime;
        $time->save();
        return redirect('/');
    }
}
