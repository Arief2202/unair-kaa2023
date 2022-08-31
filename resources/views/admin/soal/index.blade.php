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
                        <h4><b>Bank Soal Babak {{$babak}}</b></h4>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary">Tambahkan Soal</button>
                    </div>
                </div>
                <div class="row">
                    <div class="card-body p-4">
                        <table class="table" id="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Soal</th>
                                    <th scope="col">Jawaban A</th>
                                    <th scope="col">Jawaban B</th>
                                    <th scope="col">Jawaban C</th>
                                    <th scope="col">Jawaban D</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($a=0;$a<70;$a++)
                                    <tr>
                                        <th scope="row">{{$a+1}}</th>
                                        <td><button class="btn btn-outline-primary">Preview Soal</button></td>
                                        <td><b>Test Jawaban A <i class='bx bx-check'></i></b></td>
                                        <td>Test Jawaban B <i class='bx bx-x'></i></td>
                                        <td>Test Jawaban C <i class='bx bx-x'></i></td>
                                        <td>Test Jawaban D <i class='bx bx-x'></i></td>
                                        <td><button style="background-color:transparent;padding:none;margin:none;border:none;font-size:2rem;"><i class='bx bx-edit'></i></button></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
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
