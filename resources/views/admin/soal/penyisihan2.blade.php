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
                <div class="alert alert-warning" role="alert">
                    Halaman Soal Penyisihan 2 !
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
  </body>
</html>
