<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biodata | {{$role}}</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    @include('../../layouts/navbar')
    
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <h3>Biodata {{$role}}</h3>
                @if(!isset($data))
                <form action="/createPeserta/{{Request::segment(2)}}" method="post" enctype="multipart/form-data"> @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="role" value="
                        @if(Request::segment(2) == 1) Ketua
                        @elseif(Request::segment(2) == 2) Anggota 1
                        @elseif(Request::segment(2) == 3) Anggota 2
                        @endif
                    ">
                    <div class="mb-3">
                        <label for="asal_instansi" class="form-label">Asal Instansi <span style="color: red">*</span></label>
                        <input type="text" class="form-control @error('asal_instansi') is-invalid @enderror" value="{{old('asal_instansi')}}" id="asal_instansi" name="asal_instansi" required>
                        @error('asal_instansi')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span style="color: red">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}"  id="nama" name="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telpon <span style="color: red">*</span></label>
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" value="{{old('no_telp')}}"  id="no_telp" name="no_telp" required>
                        @error('no_telp')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"  id="email" name="email" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <label for="foto" class="form-label">Foto 3x4 (Max 1 MB) <span style="color: red">*</span></label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" value="{{old('email')}}"  id="foto" name="foto" onchange="updateFoto('foto')" required>
                        <button id="buttonFoto" class="btn btn-outline-secondary" type="button" disabled data-bs-toggle="modal" data-bs-target="#modalFoto">Preview Foto</button>
                        @error('foto')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <label for="fotoKTM" class="form-label">Foto / Scan KTM (Max 1 MB) <span style="color: red">*</span></label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('fotoKTM') is-invalid @enderror" id="fotoKTM" name="fotoKTM" onchange="updateFoto('fotoKTM')" required>
                        <button id="buttonKTM" class="btn btn-outline-secondary" type="button" disabled data-bs-toggle="modal" data-bs-target="#modalKTM">Preview Foto</button>
                        @error('fotoKTM')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <label for="fotoSKMA" class="form-label">Foto / Scan Surat Keterangan Mahasiswa Aktif (Max 1 MB) </label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('fotoSKMA') is-invalid @enderror" id="fotoSKMA" name="fotoSKMA" onchange="updateFoto('fotoSKMA')">
                        <button id="buttonSKMA" class="btn btn-outline-secondary" type="button" disabled data-bs-toggle="modal" data-bs-target="#modalSKMA">Preview Foto</button>
                        @error('fotoSKMA')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <span style="color: red">Surat Keterangan Mahasiswa Aktif Wajib di isi oleh :</span><br>
                    <span style="color: red">- Prodi S1 tahun 2018 Keatas</span><br>
                    <span style="color: red">- Prodi D3 Tahun 2019 Keatas</span><br><br>

                    <span style="color: red">dengan tanda * wajib di isi!</span><br>
                    <div class="row mt-3">
                        <div class="col">             
                            @if(Request::segment(2) == "2" || Request::segment(2) == "3")  
                            <input type="submit" class="btn btn-success" name="action" value="Back">
                            @endif
                        </div>
                        <div class="col d-flex justify-content-end">

                            @if(Request::segment(2) == "1" || Request::segment(2) == "2")  
                                <input type="submit" class="btn btn-success" name="action" value="Next">
                            @else
                                <input type="submit" class="btn btn-success" name="action" value="Submit">
                            @endif
                        </div>
                    </div>
                </form>
                @else
                
                <form action="/updatePeserta/{{Request::segment(2)}}" method="post" enctype="multipart/form-data"> @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="role" value="
                        @if(Request::segment(2) == 1) Ketua
                        @elseif(Request::segment(2) == 2) Anggota 1
                        @elseif(Request::segment(2) == 3) Anggota 2
                        @endif
                    ">
                    <div class="mb-3">
                        <label for="asal_instansi" class="form-label">Asal Instansi <span style="color: red">*</span></label>
                        <input type="text" class="form-control @error('asal_instansi') is-invalid @enderror" value="{{old('asal_instansi', $data->asal_instansi)}}" id="asal_instansi" name="asal_instansi" required>
                        @error('asal_instansi')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span style="color: red">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama', $data->nama)}}"  id="nama" name="nama" required>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No Telpon <span style="color: red">*</span></label>
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" value="{{old('no_telp', $data->no_telpon)}}"  id="no_telp" name="no_telp" required>
                        @error('no_telp')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email', $data->email)}}"  id="email" name="email" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>

                    <label for="foto" class="form-label">Foto 3x4 (Max 1 MB) <span style="color: red">*</span></label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="foto" name="foto" onchange="updateFoto('foto')">
                        <button id="buttonFoto" class="btn btn-outline-secondary" type="button" @if($data->foto == NULL) disabled @endif data-bs-toggle="modal" data-bs-target="#modalFoto">Preview Foto</button>
                    </div>
                    <label for="fotoKTM" class="form-label">Foto / Scan KTM (Max 1 MB) <span style="color: red">*</span></label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="fotoKTM" name="fotoKTM" onchange="updateFoto('fotoKTM')">
                        <button id="buttonKTM" class="btn btn-outline-secondary" type="button" @if($data->fotoKTM == NULL) disabled @endif data-bs-toggle="modal" data-bs-target="#modalKTM">Preview Foto</button>
                    </div>
                    <label for="fotoSKMA" class="form-label">Foto / Scan Surat Keterangan Mahasiswa Aktif (Max 1 MB) </label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="fotoSKMA" name="fotoSKMA" onchange="updateFoto('fotoSKMA')">
                        <button id="buttonSKMA" class="btn btn-outline-secondary" type="button" @if($data->fotoSKMA == NULL) disabled @endif data-bs-toggle="modal" data-bs-target="#modalSKMA">Preview Foto</button>
                    </div>
                    <span style="color: red">Surat Keterangan Mahasiswa Aktif Wajib di isi oleh :</span><br>
                    <span style="color: red">- Prodi S1 tahun 2018 Keatas</span><br>
                    <span style="color: red">- Prodi D3 Tahun 2019 Keatas</span><br><br>

                    <span style="color: red">dengan tanda * wajib di isi!</span><br>
                    <div class="row mt-3">
                        <div class="col">              
                            @if(Request::segment(2) == "2" || Request::segment(2) == "3")
                            <input type="submit" class="btn btn-success" name="action" value="Back">
                            @endif
                        </div>
                        <div class="col d-flex justify-content-end">

                            @if(Request::segment(2) == "1" || Request::segment(2) == "2")  
                                <input type="submit" class="btn btn-success" name="action" value="Next">
                            @else
                                <input type="submit" class="btn btn-success" name="action" value="Submit">
                            @endif
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalFoto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Foto 3x4</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($data != null)
                    <img id="modalIMGFoto" src="{{env('APP_URL')}}/storage/{{$data->foto}}" alt="Foto 3x4" width="100%">
                @else
                    <img id="modalIMGFoto" alt="Foto 3x4" width="100%">
                @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalKTM">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Foto KTM</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($data != null)
                    <img id="modalIMGKTM" src="{{env('APP_URL')}}/storage/{{$data->fotoKTM}}" alt="Foto KTM" width="100%">
                @else
                    <img id="modalIMGKTM" alt="Foto 3x4" width="100%">
                @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modalSKMA">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Foto Surat Keterangan Mahasiswa Aktif</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($data != null)
                    <img id="modalIMGSKMA" src="{{env('APP_URL')}}/storage/{{$data->fotoSKMA}}" alt="Foto Surat Keterangan Mahasiswa Aktif" width="100%">
                @else
                    <img id="modalIMGSKMA" alt="Foto 3x4" width="100%">
                @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>


    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">       
        function updateFoto(jenis){
            if(jenis == 'foto'){
                const foto = document.querySelector('#foto');
                const modalFoto = document.querySelector('#modalIMGFoto');
                const buttonFoto = document.querySelector('#buttonFoto');
                const oFReader = new FileReader();
                oFReader.readAsDataURL(foto.files[0]);
                oFReader.onload = function(oFREvent){
                    modalFoto.src = oFREvent.target.result;
                    buttonFoto.disabled = false;
                }
            }
            else if(jenis == 'fotoKTM'){
                const foto = document.querySelector('#fotoKTM');
                const modalFoto = document.querySelector('#modalIMGKTM');
                const buttonFoto = document.querySelector('#buttonKTM');
                const oFReader = new FileReader();
                oFReader.readAsDataURL(foto.files[0]);
                oFReader.onload = function(oFREvent){
                    modalFoto.src = oFREvent.target.result;
                    buttonFoto.disabled = false;
                }
            }
            else if(jenis == 'fotoSKMA'){
                const foto = document.querySelector('#fotoSKMA');
                const modalFoto = document.querySelector('#modalIMGSKMA');
                const buttonFoto = document.querySelector('#buttonSKMA');
                const oFReader = new FileReader();
                oFReader.readAsDataURL(foto.files[0]);
                oFReader.onload = function(oFREvent){
                    modalFoto.src = oFREvent.target.result;
                    buttonFoto.disabled = false;
                }
            }
        }
        
        window.addEventListener("pageshow", function ( event ) {
            var historyTraversal = event.persisted || 
                                    ( typeof window.performance != "undefined" && 
                                        window.performance.navigation.type === 2 );
            if ( historyTraversal ) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
  </body>
</html>