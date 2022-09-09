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
                                    <th scope="col">Betul</th>
                                    <th scope="col">Salah</th>
                                    <th scope="col">Kosong</th>
                                    <th scope="col">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scores as $score)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $score->user->nama}}</td>
                                        <td>{{ $score->user->telp}}</td>
                                        <td>{{ $score->user->email}}</td>
                                        <td>{{ $score->true}}</td>
                                        <td>{{ $score->false}}</td>
                                        <td>{{ $score->empty}}</td>
                                        <td>{{ $score->score}}</td>
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
