<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biodata</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                @if($anggota->count() != 3)
                <div class="alert alert-danger" role="alert">
                    Data Anggota Belum Lengkap, Silahkan Lengkapi data dulu !!!
                </div>
                @else
                <div class="alert alert-danger" role="alert">
                    Apakah anda yakin ingin Submit Data Anggota ? <br>(Data yang telah di submit tidak dapat diubah !!!)
                </div>
                @endif

                <form action="/updatePeserta/{{Request::segment(2)}}" method="post" class=""> @csrf
                <div class="row mt-3">
                    <div class="col">
                        @if(Request::segment(2) == "2" || Request::segment(2) == "3" || Request::segment(2) == "4")
                        <input type="submit" class="btn btn-success" name="action" value="Back">
                        @endif
                    </div>
                    <div class="col d-flex justify-content-end">

                        @if(Request::segment(2) == "1" || Request::segment(2) == "2")
                            <input type="submit" class="btn btn-success" name="action" value="Next">
                        @else
                            @if($anggota->count() != 3)
                            <input type="button" class="btn btn-warning" value="Submit" disabled>
                            @else
                            <input type="submit" class="btn btn-warning" name="action" value="Submit">
                            @endif
                        @endif
                    </div>
                </div>
                </form>
              </div>
            </div>
        </div>
    </div>
    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
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
