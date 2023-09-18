<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KAA2023 | Waiting Room</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="alert alert-primary mt-3" role="alert">
            <p id="babak" style="display:inline;">{{ $time->babak }}</p> akan dimulai pada :
            <p id="time" style="display:inline;">
                0 Hari 0 Jam 0 Menit 0 Detik
            </p>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                TATA CARA PENGERJAAN KAA 2O23<br><br>

                1. Peserta mengakses web perlombaan di <a href = "https://kaa.unair.tech/">https://kaa.unair.tech/</a> <br>
                2. Peserta melakukan login dengan username dan password yang diberi oleh panitia.<br>
                3. Soal akan otomatis muncul ketika waktu pengerjaan telah dimulai.<br>
                4. Pilih Jawaban, Kemudian Tekan tombol Ragu-Ragu / Selanjutnya / Selesai (Soal Terakhir), jika menekan tombol back pada browser maka jawaban tidak akan tersimpan!.<br>
                5. Apabila semua soal telah terjawab, peserta menunggu hingga waktu pengerjaan selesai.<br>
                6. Jika waktu pengerjaan telah selesai, peserta akan diarahkan ke halaman Waiting Room dan jawaban akan otomatis tersimpan.<br>

                <br><br><b>Penting!!!</b><br>
                - Apabila terjadi error, tekan tombol back pada browser

                <br><br>
                <div style="display: inline;color:red;">* Dilarang melakukan kecurangan dalam bentuk apapun !!!</div>
            </div>
        </div>
    </div>
    <script src="/bootstrap-5.2.0-beta1/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
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
        var sesi = ["Simulasi", "Kompetisi"];

        function printTime(time) {
            var days = Math.floor(time / (1000 * 60 * 60 * 24));
            var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((time % (1000 * 60)) / 1000);
            return days + " Hari " + hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
        }
        var lastState = true;
        var x = setInterval(function() {
            var httpxml = new XMLHttpRequest();

            function stateck() {
                if (httpxml.readyState == 4) {
                    const obj = JSON.parse(httpxml.responseText);
                    var now = new Date().getTime();
                    var time = new Date(obj.time.startTime).getTime();
                    time -= now;

                    distanceEnd = new Date(obj.time.endTime).getTime();
                    distanceEnd -= now;
                    var state = obj.time.startTime ? true : false;
                    if ((time < 0 && distanceEnd > 0) || state != lastState) {
                        window.location.reload();
                    } else {
                        document.getElementById("babak").innerHTML = obj.time.babak;
                        document.getElementById("time").innerHTML = "" + printTime(time);
                    }

                }
            }
            httpxml.onreadystatechange = stateck;
            httpxml.open("POST", "/getTime", true);
            httpxml.send(null);
        }, 1000);
    </script>
</body>

</html>
