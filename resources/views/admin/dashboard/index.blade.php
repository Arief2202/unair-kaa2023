<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Dashboard</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* input#modified::-webkit-calendar-picker-indicator {
            width: 100%;
            margin: 0;
            background: transparent;
        } */
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            background: transparent;
            bottom: 0;
            color: transparent;
            cursor: pointer;
            height: auto;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            width: auto;
        }
    </style>
</head>

<body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <h4><b>Set Waktu</b></h4>
                <label for="basic-url" class="form-label"><b>Simulasi</b> <br>( Durasi : <p id="durasi1" style="display:inline;"></p>)<br>( <p id="simulasi" style="display: inline;"></p>)</label>
                @if ($data = $times->where('babak', 'Simulasi')->first())
                    <form action="/updateTime/Simulasi" method="post">@csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Start</span>
                            <input type="datetime-local" class="form-control" name="startTime"
                                value="{{ $data->startTime }}" required>
                            <span class="input-group-text" id="basic-addon3">End</span>
                            <input type="datetime-local" class="form-control" name="endTime"
                                value="{{ $data->endTime }}" required>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Update</button>
                        </div>
                    </form>
                @else
                    <form action="/setTime/Simulasi" method="post">@csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Start</span>
                            <input type="datetime-local" class="form-control" name="startTime" required>
                            <span class="input-group-text" id="basic-addon3">End</span>
                            <input type="datetime-local" class="form-control" name="endTime" required>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Submit</button>
                        </div>
                    </form>
                @endif
                <label for="basic-url" class="form-label"><b>Kompetisi</b> <br>( Durasi : <p id="durasi2" style="display:inline;"></p>) <br>( <p id="kompetisi" style="display: inline;"></p>)</label>
                @if ($data = $times->where('babak', 'Kompetisi')->first())
                    <form action="/updateTime/Kompetisi" method="post">@csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Start</span>
                            <input type="datetime-local" class="form-control" name="startTime"
                                value="{{ $data->startTime }}" required>
                            <span class="input-group-text" id="basic-addon3">End</span>
                            <input type="datetime-local" class="form-control" name="endTime"
                                value="{{ $data->endTime }}" required>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Update</button>
                        </div>
                    </form>
                @else
                    <form action="/setTime/Kompetisi" method="post">@csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Start</span>
                            <input type="datetime-local" class="form-control" name="startTime" required>
                            <span class="input-group-text" id="basic-addon3">End</span>
                            <input type="datetime-local" class="form-control" name="endTime" required>
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Submit</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        var sesi = ["simulasi", "kompetisi"];

        function printTime(time) {
            var days = Math.floor(time / (1000 * 60 * 60 * 24));
            var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((time % (1000 * 60)) / 1000);
            return days + " Hari " + hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
        }
        function printTimeNHS(time) {
            var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            return hours + " Jam " + minutes + " Menit ";
        }
        var x = setInterval(function() {
            var httpxml = new XMLHttpRequest();

            function stateck() {
                if (httpxml.readyState == 4) {
                    console.log(httpxml.responseText);
                    const obj = JSON.parse(httpxml.responseText);
                    var now = new Date().getTime();
                    for (var a = 0; a < 2; a++) {
                        var time = new Date(obj.time[a].startTime).getTime();
                        var distanceEnd = new Date(obj.time[a].endTime).getTime();
                        document.getElementById("durasi"+((a)+1)).innerHTML = "" + printTimeNHS(distanceEnd-time);

                        time -= now;
                        document.getElementById(sesi[a]).innerHTML = "" + printTime(time);

                        distanceEnd -= now;
                        if (time < 0 && distanceEnd > 0) {
                            document.getElementById(sesi[a]).innerHTML = " STARTED ";
                        } else if (distanceEnd < 0) {
                            document.getElementById(sesi[a]).innerHTML = " ENDED ";
                        }
                    }
                }
            }
            httpxml.onreadystatechange = stateck;
            httpxml.open("POST", "/getTimes", true);
            httpxml.send(null);
        }, 500);
    </script>
</body>

</html>
