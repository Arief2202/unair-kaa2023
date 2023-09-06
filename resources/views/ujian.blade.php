<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kompetisi</title>
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
    <div class="container">
        <div class="alert alert-warning mt-3" role="alert">
            <p id="babak" style="display:inline;">{{$time->babak}}</p> akan selesai pada :
            <p id="time" style="display:inline;">
                {{$interval->d}} Hari {{$interval->h}} Jam {{$interval->i}} Menit {{$interval->s}} Detik
            </p>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mt-2">
                    <div class="card-body">
                        @foreach ($soals as $s)
                            @if($data = $answers->where('soal_id', $s->id)->first())
                                @if($data->ragu == 1)
                                    <a type="button"
                                        class="btn @if ($req->soal == $loop->index + 1) active @endif btn-warning mb-1"
                                        href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $loop->index + 1 }}">{{ $loop->index + 1 < 10 ? '0' : '' }}{{ $loop->index + 1 }}</a>
                                @else
                                    <a type="button"
                                        class="btn @if ($req->soal == $loop->index + 1) active @endif btn-success mb-1"
                                        href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $loop->index + 1 }}">{{ $loop->index + 1 < 10 ? '0' : '' }}{{ $loop->index + 1 }}</a>
                                @endif
                            @else
                                <a type="button"
                                    class="btn @if ($req->soal == $loop->index + 1) active @endif btn-danger mb-1"
                                    href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $loop->index + 1 }}">{{ $loop->index + 1 < 10 ? '0' : '' }}{{ $loop->index + 1 }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mt-2">
                    <div class="card-body">

                        <form action="/answer" method="POST">@csrf
                            <input type="hidden" name="uri" value="{{ strtok($_SERVER['REQUEST_URI'], '?') }}">
                            <input type="hidden" name="soal_id" value="{{$soal->id}}">
                            <input type="hidden" name="soal_number" value="{{$req->soal}}">
                            <input type="hidden" name="babak" value="{{$time->babak}}">
                            {{-- <input type="hidden" name="babak" value="{{ $babak }}">
                            <input type="hidden" name="uri" value="{{ $_SERVER['REQUEST_URI'] }}">
                            <input type="hidden" name="jenis" value="gambar"> --}}
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label"><b>Soal No. {{$req->soal}}</b></label><br>
                                @if ($soal->jenis_soal == 'text')
                                    <div class="soal">{{ $soal->soal }}</div>
                                @elseif($soal->jenis_soal == 'gambar')
                                    <img class="p-1 mt-2" alt="Foto Soal" width="100%"
                                        src="/{{ $soal->soal }}">
                                @endif
                            </div>


                            <label for="formFile" class="form-label"><b>Jawaban</b></label>
                            @foreach ($soal->jawabanSecure() as $jawaban)
                                <div class="form-check">
                                    @if($data = $answers->where('soal_id', $soal->id)->first())
                                        <input class="form-check-input" type="radio" name="jawaban_id"
                                            id="flexRadioDefault{{ $loop->index }}" value="{{$jawaban->id}}" @if($data->jawaban_id == $jawaban->id) checked @endif>
                                    @else
                                        <input class="form-check-input" type="radio" name="jawaban_id"
                                            id="flexRadioDefault{{ $loop->index }}" value="{{$jawaban->id}}">
                                    @endif
                                    <label class="form-check-label" for="flexRadioDefault{{ $loop->index }}">
                                        {{ $jawaban->jawaban }}
                                    </label>
                                </div>
                            @endforeach

                            <div class="row mt-3">

                                <div class="col">
                                    @if ($req->soal != 1)
                                        <a type="button" class="btn btn-primary"
                                            href="{{ strtok($_SERVER['REQUEST_URI'], '?') }}?soal={{ $req->soal - 1 }}">Kembali</a>
                                    @endif
                                </div>
                                <div class="col d-flex justify-content-end">
                                    @if ($req->soal == $soals->count())
                                        <button type="submit" class="btn btn-warning me-3" name="raguEnd" value="raguEnd">Ragu-Ragu</button>
                                        <button type="submit" class="btn btn-success" name="end" value="end">Selesai</button>
                                    @else
                                        <button type="submit" class="btn btn-warning me-3" name="ragu" value="ragu">Ragu-Ragu</button>
                                        <button type="submit" class="btn btn-primary">Selanjutnya</button>
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
                        if(obj.time.babak == "Simulasi 2" || obj.time.babak == "Penyisihan 2")window.location.reload();
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
