<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\time;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function getTime()
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
    public function setTime($babak, Request $request)
    {
        if (Auth::user()->role != 1) return redirect('/dashboard');
        $time = new time();
        $time->babak = $babak;
        $time->startTime = $request->startTime;
        $time->endTime = $request->endTime;
        $time->save();
        return redirect('/');
    }
    public function updateTime($babak, Request $request)
    {
        if (Auth::user()->role != 1) return redirect('/dashboard');
        $time = time::where('babak', $babak)->first();
        $time->babak = $babak;
        $time->startTime = $request->startTime;
        $time->endTime = $request->endTime;
        $time->save();
        return redirect('/');
    }
}
