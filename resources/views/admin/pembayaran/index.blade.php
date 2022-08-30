<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Pembayaran</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
              <div class="row flex-row flex-nowrap">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">No Telp</th>
                        <th scope="col">Email</th>
                        <th scope="col">Bukti Pembayaran</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{$loop->index+1}}</th>
                            <td>{{$user->nama}}</td>
                            <td>{{$user->telp}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                              
                              @if($user->status == 0)
                                <button type="button" class="btn btn-primary" disabled>
                                    Lihat Bukti Pembayaran
                                </button>                              
                              @else
                                <a type="button" class="btn btn-primary"  href="/pembayaran?id_user={{$user->id}}">
                                    Lihat Bukti Pembayaran
                                </a>
                              @endif
                            </td>

                            <td>
                                @if($user->status == 1)
                                    <form action="/accPembayaran" method="POST"> @csrf
                                      <input type="hidden" name="user_id" value="{{$user->id}}">
                                      <button type="submit" class="btn btn-warning">
                                          Terima Pembayaran
                                      </button>
                                    </form>
                                @elseif($user->status >= 2)
                                <button class="btn btn-success" disabled>
                                    Pembayaran Diterima
                                </button>
                                @elseif($user->status == 0)
                                <button class="btn btn-danger" disabled>
                                    Menunggu Pembayaran
                                </button>
                                @endif
                            </td>                            
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            @if(isset($request->id_user))
              <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran {{$users->where('id', '=', $request->id_user)->first()->email}}</h5>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @if(isset($request->id_user))
              <div class="d-flex justify-content-center">
                <img src="{{env('APP_URL')}}/storage/{{$users->where('id', '=', $request->id_user)->first()->bukti_pembayaran}}" alt="Bukti Pembayaran" width="80%">
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
    @if(isset($_GET['id_user']))
    <?php
    echo '
        <script>
        $(window).on(\'load\',function(){$(\'#exampleModal\').modal(\'show\');});
        $(\'#exampleModal\').on(\'hidden.bs.modal\', function () {
            window.location.replace(\'';
    echo env('APP_URL').'/pembayaran';
    echo '\');
        })
        </script>
    ';
    ?>            
@endif    
  </body>
</html>