<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorepesertaRequest;
use App\Http\Requests\UpdatepesertaRequest;
use Illuminate\Http\Request;
use App\Models\peserta;
use App\Models\User;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role != 1) return redirect('/dashboard');
        $user =  peserta::where('user_id', '=', $request->id_user)->get();
        $users = User::where('status', '4')->get()->merge(User::where('role', '=', '0')->where('status', '>=', '2')->where('status', '!=', '4')->orderBy('status', 'DESC')->get());
        $peserta = NULL;
        $lengkap = TRUE;
        if($request->role == 'ketua') $peserta = $user->where('role', '=', 'Ketua')->first();
        else if($request->role == 'anggota1') $peserta = $user->where('role', '=', 'Anggota 1')->first();
        else if($request->role == 'anggota2') $peserta = $user->where('role', '=', 'Anggota 2')->first();
        return view('admin.peserta.index',[
            'lengkap' => $lengkap,
            'request' => $request,
            'users' => $users,
            'peserta' => $peserta,
            'pesertaAll' => peserta::get(),
        ]);
    }

    public function donePayment(){
        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->status = 3;
        $user->save();
        return redirect('/biodata/1');
    }

    public function biodata($biodata, Request $request){
        $status = Auth::user()->status;
        $anggota = peserta::where('user_id', '=', Auth::user()->id)->get();
        if($status != 3) return redirect('/dashboard');
        if($biodata == 1) $role = "Ketua";
        else if($biodata == 2)  $role = "Anggota 1";
        else if($biodata == 3)  $role = "Anggota 2";
        else if($biodata == 4){
            return view ('peserta.prosesDaftar.submitBiodata', [
                'anggota' => $anggota,
            ]);
        }
        else return abort(404);

        $data = $anggota->where('role', '=', $role)->first();

        return view ('peserta.prosesDaftar.biodata',[
            'role' => $role,
            'anggota' => $anggota,
            'data' => $data,
        ]);
    }
    public function updatePeserta($biodata, Request $request){
        $biodataInt = (int) $biodata;
        if($biodata != 4){
            $validated = $request->validate([
                'asal_instansi' => 'required',
                'nama' => 'required',
                'no_telp' => 'required',
                'email' => 'required'
            ]);
            if($biodata == 1) $role = "Ketua";
            else if($biodata == 2)  $role = "Anggota 1";
            else if($biodata == 3)  $role = "Anggota 2";
            $peserta = peserta::where('user_id', '=', Auth::user()->id)->where('role', '=', $role)->first();
            $peserta->asal_instansi = $validated['asal_instansi'];
            $peserta->nama = $validated['nama'];
            $peserta->no_telpon = $validated['no_telp'];
            $peserta->email = $validated['email'];
            $peserta->save();
            if(isset($request->foto)){
                $validated = $request->validate([
                    'foto' => 'image|file|max:1024'
                ]);
                if(isset($peserta->foto)) Storage::delete($peserta->foto);
                $peserta->foto = $request->file('foto')->store('peserta');
                $peserta->save();
            }
            if(isset($request->fotoKTM)){
                $validated = $request->validate([
                    'fotoKTM' => 'image|file|max:1024'
                ]);
                if(isset($peserta->fotoKTM)) Storage::delete($peserta->fotoKTM);
                $peserta->fotoKTM = $request->file('fotoKTM')->store('peserta');
                $peserta->save();
            }
            if(isset($request->fotoSKMA)){
                $validated = $request->validate([
                    'fotoSKMA' => 'image|file|max:1024'
                ]);
                if(isset($peserta->fotoSKMA)) Storage::delete($peserta->fotoSKMA);
                $peserta->fotoSKMA = $request->file('fotoSKMA')->store('peserta');
                $peserta->save();
            }
        }

        if($biodataInt == 4 && $request->action == 'Submit'){
            $user = user::where('id', '=', Auth::user()->id)->first();
            $user->status = 4;
            $user->save();
        }

        if($request->action == 'Next') return redirect('biodata/'.$biodataInt+1);
        else if($request->action == 'Back') return redirect('biodata/'.$biodataInt-1);
        else if($request->action == 'Submit') return redirect('biodata/'.$biodataInt+1);
    }

    public function createPeserta($biodata, Request $request){
        $biodataInt = (int) $biodata;
        if($biodata == 1) $role = "Ketua";
        else if($biodata == 2)  $role = "Anggota 1";
        else if($biodata == 3)  $role = "Anggota 2";
        if($biodata != 4){
            $validated = $request->validate([
                'user_id' => 'required',
                'role' => 'required',
                'asal_instansi' => 'required',
                'nama' => 'required',
                'no_telp' => 'required',
                'email' => 'required',
                'foto' => 'image|file|max:1024|required',
                'fotoKTM' => 'image|file|max:1024|required',
                'fotoSKMA' => 'image|file|max:1024'
            ]);
            if(peserta::where('user_id', '=', $validated['user_id'])->where('role', '=', $validated['role'])->get()->count() == 0){
                peserta::create([
                    'user_id' => $validated["user_id"],
                    'role' => $validated["role"],
                    'asal_instansi' => $validated["asal_instansi"],
                    'nama' => $validated["nama"],
                    'no_telpon' => $validated["no_telp"],
                    'email' => $validated["email"],
                    'foto' => $request->file('foto')->store('peserta'),
                    'fotoKTM' => $request->file('fotoKTM')->store('peserta'),
                ]);

                $peserta = peserta::where('user_id', '=', Auth::user()->id)->where('role', '=', $role)->first();
                if(isset($request->fotoSKMA)){
                    $validated = $request->validate([
                        'fotoSKMA' => 'image|file|max:1024'
                    ]);
                    if(isset($peserta->fotoSKMA)) Storage::delete($peserta->fotoSKMA);
                    $peserta->fotoSKMA = $request->file('fotoSKMA')->store('peserta');
                    $peserta->save();
                }
            }
        }

        if($biodataInt == 4 && $request->action == 'Submit'){
            $user = user::where('id', '=', Auth::user()->id)->first();
            $user->status = 4;
            $user->save();
        }

        if($request->action == 'Next') return redirect('biodata/'.$biodataInt+1);
        else if($request->action == 'Back') return redirect('biodata/'.$biodataInt-1);
        else if($request->action == 'Submit') return redirect('biodata/'.$biodataInt+1);
    }

    public function accPeserta(Request $request){
        if(Auth::user()->role != 1) return redirect('/dashboard');
        $user = user::where('id', '=', $request->user_id)->first();
        $user->status = 5;
        $user->save();
        return redirect('peserta');
    }
}
