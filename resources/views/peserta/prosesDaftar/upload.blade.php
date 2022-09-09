<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                @if(Auth::user()->bukti_pembayaran == NULL)
                <div class="alert alert-danger" role="alert">
                    Belum Melakukan Pembayaran !
                </div>
                <div class="mb-3">
                    {{-- <h3>Upload Bukti Pembayaran</h3> --}}
                    Silahkan melakukan pembayaran terlebih dahulu Melalui :<br>
                    <b>Bank Mandiri</b> <br>
                    1410022241582<br>
                    a.n. ANDHINI IZHATURRACHMANIA<br>
                    <br>
                    <b>Shopeepay</b><br>
                    0881026853017<br>
                    a.n. NADIA AMANDA HAKIM
                </div>
                <div class="mb-3">
                    <form method="POST" action="/uploadBuktiBayar" enctype="multipart/form-data">@csrf
                        <div class="col mb-3">
                            <label for="file" class="form-label"><h5>Upload bukti pembayaran dibawah ini (Max 1mb)</h5></label>
                            <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file" required>
                            @error('file')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="col d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                @else
                <div class="alert alert-warning" role="alert">
                    Bukti Pembayaran telah di Upload, Menunggu Konfirmasi dari Panitia
                </div>
                @endif
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
