<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\peserta;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 1){
            return view('admin.dashboard.index');
        }
        else{
            $status = Auth::user()->status;
            if($status == 0) return view('peserta.prosesDaftar.upload');
            else if($status == 1) return view('peserta.prosesDaftar.waitAccPembayaran');
            else if($status == 2) return view('peserta.prosesDaftar.datadiri');
            else if($status == 3) return redirect('/biodata/1');
            else if($status == 4) return view('peserta.prosesDaftar.waitAccBiodata');
            else if($status == 5) return view('peserta.ujian.index');
        }
    }
    public function pembayaran(Request $request)
    {
        if(Auth::user()->role == 1){
            return view('admin.pembayaran.index', [
                'users' => User::where('email', '!=', 'admin@kaasemnasunair2022.com')->get(), 
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