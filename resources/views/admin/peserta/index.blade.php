<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Pembayaran</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css">
</head>

<body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body p-4">
                <table class="table" id="table" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">No Telp</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ketua</th>
                            <th scope="col">Anggota 1</th>
                            <th scope="col">Anggota 2</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->telp }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a type="button" class="btn btn-<?php if (
                                        $pesertaAll
                                            ->where('role', '=', 'Ketua')
                                            ->where('user_id', '=', $user->id)
                                            ->first()
                                    ) {
                                        echo 'primary';
                                    } else {
                                        echo 'danger';
                                    } ?>"
                                        href="/peserta?id_user={{ $user->id }}&role=ketua">
                                        Ketua
                                    </a>
                                </td>

                                <td>
                                    <a type="button" class="btn btn-<?php if (
                                        $pesertaAll
                                            ->where('role', '=', 'Anggota 1')
                                            ->where('user_id', '=', $user->id)
                                            ->first()
                                    ) {
                                        echo 'primary';
                                    } else {
                                        echo 'danger';
                                    } ?>"
                                        href="/peserta?id_user={{ $user->id }}&role=anggota1">
                                        Anggota 1
                                    </a>
                                </td>

                                <td>
                                    <a type="button" class="btn btn-<?php if (
                                        $pesertaAll
                                            ->where('role', '=', 'Anggota 2')
                                            ->where('user_id', '=', $user->id)
                                            ->first()
                                    ) {
                                        echo 'primary';
                                    } else {
                                        echo 'danger';
                                    } ?>"
                                        href="/peserta?id_user={{ $user->id }}&role=anggota2">
                                        Anggota 2
                                    </a>
                                </td>
                                <td>
                                    @if ($user->status == 5)
                                        <button type="button" class="btn btn-success" disabled>
                                            Confirmed
                                        </button>
                                    @elseif($user->status != 4)
                                        <button type="button" class="btn btn-warning" disabled>
                                            Terima
                                        </button>
                                    @else
                                        <form action="/accPeserta" method="post">@csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-warning">
                                                Terima
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if (isset($request->id_user))
                            @if ($request->role == 'ketua')
                                Ketua
                            @elseif($request->role == 'anggota1')
                                Anggota 1
                            @elseif($request->role == 'anggota2')
                                Anggota 2
                            @endif
                            ({{ $users->where('id', '=', $request->id_user)->first()->email }})
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (isset($_GET['id_user']) && isset($peserta->id))
                        <span><b>Asal Instansi</b><br>{{ $peserta->asal_instansi }}</span><br><br>
                        <span><b>Nama</b><br>{{ $peserta->nama }}</span><br><br>
                        <span><b>No Telpon</b><br>{{ $peserta->no_telpon }}</span><br><br>
                        <span><b>Email</b><br>{{ $peserta->email }}</span><br><br>
                        <span><b>Foto</b><br><img src="{{ env('APP_URL') }}/storage/{{ $peserta->foto }}"
                                alt="Foto 3x4" width="50%"></span><br><br>
                        <span><b>Foto KTM</b><br><img src="{{ env('APP_URL') }}/storage/{{ $peserta->fotoKTM }}"
                                alt="Foto KTM" width="100%"></span><br><br>
                        <span><b>Surat Keterangan Mahasiswa Aktif</b><br>
                            @if ($peserta->fotoSKMA)
                                <img src="{{ env('APP_URL') }}/storage/{{ $peserta->fotoSKMA }}" alt="Foto KTM"
                                    width="100%">
                            @else
                                -
                            @endif
                        </span><br><br>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Data belum di isi !!!
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function(){
            $('#table').dataTable({
                "scrollX": true
            });
        });
    </script>
    @if (isset($_GET['id_user']))
        <?php
        echo '
                <script>
                $(window).on(\'load\',function(){$(\'#exampleModal\').modal(\'show\');});
                $(\'#exampleModal\').on(\'hidden.bs.modal\', function () {
                    window.location.replace(\'';
        echo env('APP_URL') . '/peserta';
        echo '\');
                })
                </script>
            ';
        ?>
    @endif
</body>

</html>
