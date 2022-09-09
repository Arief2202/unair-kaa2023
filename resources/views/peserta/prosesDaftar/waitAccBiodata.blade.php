<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    Data Peserta telah di Submit, Menunggu Konfirmasi dari panitia
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
