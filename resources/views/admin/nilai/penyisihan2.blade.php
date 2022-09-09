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
                <h4><b>Nilai Babak {{ $babak }}</b></h4>
                <div class="row">
                    <div class="card-body p-4">
                        <table class="table" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">No Telp</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Jawaban</th>
                                    <th scope="col">Nilai (Input)</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Nilai (Tampil)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <?php $dataAnswer = $answers->where('user_id', $user->id)->first(); ?>
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{$user->nama}}</td>
                                        <td>{{$user->telp}}</td>
                                        <td>{{$user->email}}</td>

                                        @if($dataAnswer)
                                            <td><a type="button" class="btn btn-primary" href="/storage/{{$dataAnswer->jawaban}}">Unduh Jawaban</a></td>
                                        @else
                                            <td><button type="button" class="btn btn-outline-danger" disabled>Unduh Jawaban</button></td>
                                        @endif

                                        <form action="/updateNilaiFile" method="post">@csrf

                                            @if($dataAnswer)
                                                <td><input type="number" name="nilai" value="{{$dataAnswer->score}}" id=""></td>
                                                    <input type="hidden" name="answer_id" value="{{$dataAnswer->id}}">
                                                    <input type="hidden" name="uri" value="{{$_SERVER['REQUEST_URI']}}">
                                                <td><button type="submit" class="btn btn-success">Update Nilai</button></td>
                                                <td>{{$dataAnswer->score}}</td>
                                            @else
                                                <td><input type="number" name="nilai" value="0" id=""></td>
                                                <td><button type="button" class="btn btn-outline-danger" disabled>Update Nilai</button></td>
                                                <td>0</td>
                                            @endif
                                        </form>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================ LETAK JAVA SCRIPT =============================================== --}}

    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').dataTable({
                "scrollX": true
            });
        });
    </script>
</body>

</html>
