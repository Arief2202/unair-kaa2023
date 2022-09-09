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

<body onmousedown='return false;' onselectstart='return false;' oncontextmenu="return false;">
    @include('../../layouts/navbar')
    <div class="container" style="width: 50%">
        <div class="alert alert-warning mt-3" role="alert">
            <p id="babak" style="display:inline;">{{$time->babak}}</p> akan selesai pada :
            <p id="time" style="display:inline;">
                {{$interval->d}} Hari {{$interval->h}} Jam {{$interval->i}} Menit {{$interval->s}} Detik
            </p>
        </div>
        <div class="card p-4">
            <h5><b>SOAL</b></h5>
            @if($time->babak == "Penyisihan 2")
                <a class="btn btn-primary" href="/storage/soal/Soal Penyisihan II.docx">Unduh Soal</a>
            @else
                <a class="btn btn-primary" href="/storage/soal/Soal Simulasi.docx">Unduh Soal</a>
            @endif
            <h5 class="mt-5"><b>Lembar Jawaban</b></h5>

            @if($time->babak == "Penyisihan 2")
                <a class="btn btn-primary" href="/storage/soal/LJK Penyisihan 2.xlsx">Unduh LJK</a>
            @else
                <a class="btn btn-primary" href="/storage/soal/LJK Simulasi.xlsx">Unduh LJK</a>
            @endif
            <h5 class="mt-5"><b>Upload Jawaban</b></h5>
            <form action="/uploadSesi2" method="post" enctype="multipart/form-data"> @csrf
                <input type="hidden" name="babak" value="{{$time->babak}}">
                <input type="hidden" name="uri" value="{{$_SERVER['REQUEST_URI']}}">
                <div class="input-group ">
                    <input required type="file" class="form-control" name="jawaban" placeholder="Recipient's username" aria-label="Recipient's username with two button addons">
                    <button class="btn btn-outline-secondary" type="submit">Upload</button>
                </div>
            </form>
            <div class="col mt-4">
                <h5><b>Preview Jawaban Peserta</b></h5>
                {{-- <a class="btn btn-primary" href="/storage/soal/LJK Simulasi.xlsx" disabled>Unduh Jawaban</a> --}}
                @if($answer)
                    <a type="button" class="btn btn-primary" href="/storage/{{$answer->jawaban}}">Unduh Jawaban</a>
                @else
                    <button type="button" class="btn btn-primary" disabled>Unduh Jawaban</button>
                @endif
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

        function printTime(time) {
            var days = Math.floor(time / (1000 * 60 * 60 * 24));
            var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((time % (1000 * 60)) / 1000);
            return days + " Hari " + hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
        }

        // var lastBabak = "";
        // var first = true;
        var x = setInterval(function() {
            var httpxml = new XMLHttpRequest();
            function stateck() {
                if (httpxml.readyState == 4) {
                    const obj = JSON.parse(httpxml.responseText);

                    if(Object.keys(obj.time).length > 0){
                        // if(obj.time.babak != lastBabak && !first) window.location.reload();
                        // lastBabak = obj.time.babak;
                        // first = false;
                        if(obj.time.babak == "Simulasi" || obj.time.babak == "Preliminary" || obj.time.babak == "Penyisihan 1")window.location.reload();
                        var now = new Date().getTime();
                        var time = new Date(obj.time.startTime).getTime();
                        time -= now;
                        document.getElementById("babak").innerHTML = obj.time.babak;
                        document.getElementById("time").innerHTML = "" + printTime(time);

                        distanceEnd = new Date(obj.time.endTime).getTime();
                        distanceEnd -= now;
                        if (time > 0 && distanceEnd > 0) {
                            window.location.reload();
                        } else if (time < 0 && distanceEnd > 0) {
                            document.getElementById("time").innerHTML = "" + printTime(distanceEnd);
                        } else if (distanceEnd < 0) {
                            document.getElementById("time").innerHTML = " ENDED";
                            window.location.replace("https://kaasemnasunair2022.com/dashboard");
                            a++;
                        }
                    }
                    else window.location.reload();

                }
            }
            httpxml.onreadystatechange = stateck;
            httpxml.open("POST", "/getTime", true);
            httpxml.send(null);
        }, 1000);
    </script>
</body>

</html>
