<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Soal;
use App\Models\Jawaban;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function test(Request $request){
        // dd(Jawaban::latest()->select('id', 'jawaban')->first());
        if(Auth::user()->role == 1 || Auth::user()->status == 6 ){
            if(!$request->soal) return redirect(strtok($_SERVER['REQUEST_URI'], '?').'?soal=1');
            $soals = Soal::all();
            return view('ujian', [
                'soals' => $soals,
                'soal' => $soals->slice($request->soal-1, 1)->first(),
                'req' => $request
            ]);
        }
        else return redirect('/dashboard');
    }
    public function index($sublink, Request $request)
    {
        if(Auth::user()->role != 1) return redirect('/dashboard');
        $soalDetail = null;
        if($request->soal_id){
            $soalDetail = Soal::where('id', $request->soal_id)->first();
        }
        if($sublink == "preliminary"){
            return view('admin.soal.index', [
                'babak' => "Preliminary",
                'soals' => Soal::where('babak', 'Preliminary')->get(),
                'soalDetail' => $soalDetail
            ]);
        }
        else if($sublink == "penyisihan1"){
            return view('admin.soal.index', [
                'babak' => "Penyisihan 1",
                'soals' => Soal::where('babak', 'Penyisihan 1')->get(),
                'soalDetail' => $soalDetail
            ]);
        }
        else if($sublink == "simulasi"){
            return view('admin.soal.index', [
                'babak' => "Simulasi",
                'soals' => Soal::where('babak', 'Simulasi')->get(),
                'soalDetail' => $soalDetail
            ]);
        }
        else if($sublink == "penyisihan2"){
            return view('admin.soal.penyisihan2', [
                'babak' => "Penyisihan 2",
            ]);
        }
        else{
            return redirect('/banksoal/preliminary');
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()->role != 1) return redirect('/dashboard');
        $soal = new Soal();
        $soal->babak = $request->babak;
        $soal->jenis_soal = $request->jenis;
        if($request->jenis == "text"){
            $soal->soal = $request->soalText;
            $soal->save();
        }
        else if($request->jenis == "gambar"){
            $validated = $request->validate([
                'soalGambar' => 'image|file'
            ]);
            $soal->soal = $request->file('soalGambar')->store('soal');
            $soal->save();
        }
        Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawabanA,
            'is_correct' => $request->valueTrue == 'A',
        ]);
        Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawabanB,
            'is_correct' => $request->valueTrue == 'B',
        ]);
        Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawabanC,
            'is_correct' => $request->valueTrue == 'C',
        ]);
        Jawaban::create([
            'soal_id' => $soal->id,
            'jawaban' => $request->jawabanD,
            'is_correct' => $request->valueTrue == 'D',
        ]);
        return redirect($request->uri);
    }

    public function destroy(Request $request)
    {
        if(Auth::user()->role != 1) return redirect('/dashboard');
        foreach(Jawaban::where('soal_id', $request->soal_id)->get() as $jawaban){
            $jawaban->delete();
        }
        $soal = Soal::where('id', $request->soal_id)->first();
        if($soal->jenis_soal == 'gambar'){
            Storage::delete($soal->soal);
        }
        $soal->delete();
        return redirect($request->uri);
    }
}
