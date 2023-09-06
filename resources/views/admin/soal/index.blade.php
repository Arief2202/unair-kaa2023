<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Bank Soal</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css">
    <link href='/vendor/boxicons/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body p-4">
                <div class="row p-2">
                    <div class="col">
                        <h4><b>Bank Soal Babak {{ $babak }}</b></h4>
                    </div>
                    <div class="col d-flex justify-content-end">
                        {{-- <button class="btn btn-primary">Tambahkan Soal Gambar</button>
                        <button class="btn btn-primary">Tambahkan Soal Text</button> --}}
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Tambahkan Soal
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#addSoalGambar">Soal Gambar</button></li>
                                <li><button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#addSoalText">Soal Text</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-body p-4">
                        <table class="table" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Soal</th>
                                    <th scope="col">Jawaban A</th>
                                    <th scope="col">Jawaban B</th>
                                    <th scope="col">Jawaban C</th>
                                    <th scope="col">Jawaban D</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($soals as $soal)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $soal->jenis_soal}}</td>
                                        <td><a class="btn btn-outline-primary" href="{{strtok($_SERVER['REQUEST_URI'], '?')}}?soal_id={{$soal->id}}">Preview Soal</a></td>

                                        @foreach ($soal->jawaban() as $jawaban)
                                            @if($jawaban->is_correct)
                                                <td><b>{{$jawaban->jawaban}} <i class='bx bx-check'></i></b></td>
                                            @else
                                                <td>{{$jawaban->jawaban}} <i class='bx bx-x'></i></td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <form method="POST" action="/deleteSoal">@csrf
                                                <input type="hidden" name="soal_id" value="{{$soal->id}}">
                                                <input type="hidden" name="uri" value="{{$_SERVER['REQUEST_URI']}}">
                                                <button type="submit" style="background-color:transparent;padding:none;margin:none;border:none;font-size:2rem;">
                                                    {{-- <i class='bx bx-edit'></i> --}}
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================ MODAL UNTUK MENAMBAHKAN SOAL GAMBAR =============================================== --}}

    <div class="modal fade" id="addSoalGambar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/createSoal" method="POST" enctype="multipart/form-data">@csrf
                    <input type="hidden" name="babak" value="{{$babak}}">
                    <input type="hidden" name="uri" value="{{$_SERVER['REQUEST_URI']}}">
                    <input type="hidden" name="jenis" value="gambar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Soal Gambar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="soalGambar" class="form-label"><b>Soal</b></label>
                            <input class="form-control" type="file" id="soalGambar" name="soalGambar" onchange="updateFoto()" required>
                            <img class="p-1 mt-2" id="modalIMGFoto" alt="Foto Soal" width="100%" style="display: none;">
                        </div>

                        <label for="formFile" class="form-label"><b>Jawaban</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="A" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanA" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="B" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanB" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="C" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanC" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="D" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanD" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================ MODAL UNTUK MENAMBAHKAN SOAL TEXT =============================================== --}}

    <div class="modal fade" id="addSoalText" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/createSoal" method="POST">@csrf
                    <input type="hidden" name="babak" value="{{$babak}}">
                    <input type="hidden" name="uri" value="{{$_SERVER['REQUEST_URI']}}">
                    <input type="hidden" name="jenis" value="text">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Soal Text</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label"><b>Soal</b></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="soalText" required></textarea>
                        </div>

                        <label for="formFile" class="form-label"><b>Jawaban</b></label>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="A" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanA" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="B" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanB" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="C" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanC" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" value="D" name="valueTrue" aria-label="Radio button for following text input" required>
                            </div>
                            <input type="text" class="form-control" name="jawabanD" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================ MODAL UNTUK PREVIEW SOAL =============================================== --}}

    @if(isset($_GET['soal_id']))
        <div class="modal fade" id="previewSoal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Preview Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label"><b>Soal</b></label><br>
                            @if($soalDetail->jenis_soal == 'text')
                                {{$soalDetail->soal}}
                            @elseif($soalDetail->jenis_soal == 'gambar')
                                <img class="p-1 mt-2" alt="Foto Soal" width="100%" src="/{{$soalDetail->soal}}">
                            @endif
                        </div>

                        <label for="formFile" class="form-label"><b>Jawaban</b></label>
                        @foreach($soalDetail->jawaban() as $jawaban)
                            <div class="input-group mb-3">

                                <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" aria-label="Radio button for following text input" @if($jawaban->is_correct) checked @endif disabled>
                                </div>
                                <input type="text" class="form-control" value="{{$jawaban->jawaban}}" disabled>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ================================================ LETAK JAVA SCRIPT =============================================== --}}

    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.js"></script>
    <script>
        function updateFoto(){
            const foto = document.querySelector('#soalGambar');
            const modalFoto = document.querySelector('#modalIMGFoto');
            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);
            oFReader.onload = function(oFREvent){
                modalFoto.style.display = "block";
                modalFoto.src = oFREvent.target.result;
            }
        }
        $(document).ready(function() {
            $('#table').dataTable({
                "scrollX": true
            });
        });
    </script>
    @if (isset($_GET['soal_id']))
        <?php
        echo '
                <script>
                $(window).on(\'load\',function(){$(\'#previewSoal\').modal(\'show\');});
                $(\'#previewSoal\').on(\'hidden.bs.modal\', function () {
                    window.location.replace(\'';
        echo env('APP_URL') . strtok($_SERVER['REQUEST_URI'], '?');
        echo '\');
                })
                </script>
            ';
        ?>
    @endif
</body>

</html>
