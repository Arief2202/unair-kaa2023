<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .soal {
            cursor: context-menu;
        }

        .soal:hover {
            cursor: context-menu;
        }
    </style>
    <script type="text/javascript">
        var httpxml = new XMLHttpRequest();

        function stateck() {
            if (httpxml.readyState == 4) {
                const obj = JSON.parse(httpxml.responseText);
                var now = new Date().getTime();
                var time = new Date(obj.time[a].startTime).getTime();
                time -= now;
                document.getElementById("babak").innerHTML = sesi[a];
                document.getElementById("time").innerHTML = "" + printTime(time);

                distanceEnd = new Date(obj.time[a].endTime).getTime();
                distanceEnd -= now;
                if (time > 0 && distanceEnd > 0) {
                    window.location.replace("https://kaasemnasunair2022.com/dashboard");
                } else if (time < 0 && distanceEnd > 0) {
                    document.getElementById("time").innerHTML = "" + printTime(distanceEnd);
                } else if (distanceEnd < 0) {
                    document.getElementById("time").innerHTML = " ENDED";
                    window.location.replace("https://kaasemnasunair2022.com/dashboard");
                    a++;
                }

            }
        }
        httpxml.onreadystatechange = stateck;
        httpxml.open("GET", "/getTime", true);
        httpxml.send(null);
    </script>
</head>

<body onmousedown='return false;' onselectstart='return false;' oncontextmenu="return false;">
    @include('../../layouts/navbar')
    <div class="container">
        <div class="alert alert-warning mt-3" role="alert">
            <p id="babak" style="display:inline;"></p> akan berakhir pada : <p id="time" style="display:inline;">
            </p>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mt-2">
                    <div class="card-body">
                        @foreach (range(1, $soals->count()) as $key => $i)
                            <a type="button"
                                class="btn @if ($req->soal == $key + 1) btn-danger @else btn-outline-danger @endif mb-1 "
                                href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $key + 1 }}">{{ $key + 1 < 10 ? '0' : '' }}{{ $key + 1 }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mt-2">
                    <div class="card-body">

                        <form action="" method="POST">@csrf
                            {{-- <input type="hidden" name="babak" value="{{ $babak }}">
                            <input type="hidden" name="uri" value="{{ $_SERVER['REQUEST_URI'] }}">
                            <input type="hidden" name="jenis" value="gambar"> --}}
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label"><b>Soal</b></label><br>
                                @if ($soal->jenis_soal == 'text')
                                    <div class="soal">{{ $soal->soal }}</div>
                                @elseif($soal->jenis_soal == 'gambar')
                                    <img class="p-1 mt-2" alt="Foto Soal" width="100%"
                                        src="/storage/{{ $soal->soal }}">
                                @endif
                            </div>


                            <label for="formFile" class="form-label"><b>Jawaban</b></label>
                            @foreach ($soal->jawaban() as $jawaban)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answer"
                                        id="flexRadioDefault{{ $loop->index }}">
                                    <label class="form-check-label" for="flexRadioDefault{{ $loop->index }}">
                                        {{ $jawaban->jawaban }}
                                    </label>
                                </div>
                            @endforeach

                            <div class="row mt-3">

                                <div class="col">
                                    @if ($req->soal != 1)
                                        <a type="button" class="btn btn-success"
                                            href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $req->soal - 1 }}">Kembali</a>
                                    @endif
                                </div>
                                <div class="col d-flex justify-content-end">
                                    @if ($req->soal == $soals->count())
                                        <button type="button" class="btn btn-success">Selesai</button>
                                    @else
                                        <a type="button" class="btn btn-warning me-3"
                                            href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $req->soal + 1 }}">Ragu-Ragu</a>
                                        <a type="button" class="btn btn-success"
                                            href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $req->soal + 1 }}">Selanjutnya</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.onkeydown = function(e) {
            if (event.keyCode == 123) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
        }

        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
        var a = 0;


        var sesi = ["Simulasi", "Preliminary", "Penyisihan Babak 1", "Penyisihan Babak 2"];

        function printTime(time) {
            var days = Math.floor(time / (1000 * 60 * 60 * 24));
            var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((time % (1000 * 60)) / 1000);
            return days + " Hari " + hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
        }

        var x = setInterval(function() {
            var httpxml = new XMLHttpRequest();

            function stateck() {
                if (httpxml.readyState == 4) {
                    const obj = JSON.parse(httpxml.responseText);
                    var now = new Date().getTime();
                    var time = new Date(obj.time[a].startTime).getTime();
                    time -= now;
                    document.getElementById("babak").innerHTML = sesi[a];
                    document.getElementById("time").innerHTML = "" + printTime(time);

                    distanceEnd = new Date(obj.time[a].endTime).getTime();
                    distanceEnd -= now;
                    if (time > 0 && distanceEnd > 0) {
                        window.location.replace("https://kaasemnasunair2022.com/dashboard");
                    } else if (time < 0 && distanceEnd > 0) {
                        document.getElementById("time").innerHTML = "" + printTime(distanceEnd);
                    } else if (distanceEnd < 0) {
                        document.getElementById("time").innerHTML = " ENDED";
                        window.location.replace("https://kaasemnasunair2022.com/dashboard");
                        a++;
                    }

                }
            }
            httpxml.onreadystatechange = stateck;
            httpxml.open("GET", "/getTime", true);
            httpxml.send(null);
        }, 500);
    </script>
</body>

</html>
