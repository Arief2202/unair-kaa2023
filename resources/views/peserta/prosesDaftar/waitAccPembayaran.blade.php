<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    Bukti Pembayaran telah di Upload, Menunggu Konfirmasi dari Panitia
                </div>
                <h4>Bukti Pembayaran ({{Auth::user()->email}})</h4>
                <img src="{{env('APP_URL')}}/storage/{{Auth::user()->bukti_pembayaran}}" alt="Bukti Pembayaran" height="200">
                
                <div class="mb-3">
                  <form method="POST" action="/updateBuktiBayar" enctype="multipart/form-data">@csrf
                      <div class="col mb-3 mt-5">
                          <label for="file" class="form-label"><h5>Jika ingin melakukan update, Silahkan upload bukti pembayaran dibawah ini (Max 1mb)</h5></label>
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