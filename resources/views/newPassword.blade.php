<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulasi Sesi 2</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .soal {
            cursor: context-menu;
        }

        .soal:hover {
            cursor: context-menu;
        }
    </style>
</head>

<body>
    @include('../../layouts/navbar')
    <div class="container mt-4">
        <div class="card p-4">
            <form action="/changePassword" method="POST">@csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input type="password" class="form-control @if($errors->first('password')) is-invalid @endif" name="password" id="exampleFormControlInput1" required>
                    @if($errors->first('password')) <div style="color:red;">{{$errors->first('password')}}</div> @endif
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control @if($errors->first('confirm_password')) is-invalid @endif" name="confirm_password" id="exampleFormControlInput1" required>
                    @if($errors->first('confirm_password')) <div style="color:red;">{{$errors->first('confirm_password')}}</div> @endif
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
</body>

</html>
