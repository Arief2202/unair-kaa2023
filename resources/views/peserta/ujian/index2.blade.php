<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waiting Room</title>
    <link href="/bootstrap-5.2.0-beta1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('../../layouts/navbar')
    <div class="container">
        <div class="alert alert-primary mt-3" role="alert">
            <p id="babak" style="display:inline;">{{ $time->babak }}</p> akan dimulai pada :
            <p id="time" style="display:inline;">
                {{ $interval->d }} Hari {{ $interval->h }} Jam {{ $interval->i }} Menit {{ $interval->s }} Detik
            </p>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab aut velit distinctio unde? Dicta libero
                corporis, molestiae voluptates sint quasi reprehenderit repellendus perspiciatis minus architecto quos
                porro, dignissimos neque aperiam vero facilis? Facilis dolor iusto aut magni placeat nam laborum minima
                distinctio voluptas molestiae nobis asperiores doloribus, laudantium natus fuga<br>
                - Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut, corporis!<br>
                - Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magnam, sunt.<br>
                - Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur, id.<br>
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
                    var time = new Date(obj.time.startTime).getTime();
                    time -= now;

                    distanceEnd = new Date(obj.time.endTime).getTime();
                    distanceEnd -= now;

                    if (time < 0 && distanceEnd > 0) {
                        window.location.reload();
                    } else {
                        document.getElementById("babak").innerHTML = obj.time.babak;
                        document.getElementById("time").innerHTML = "" + printTime(time);
                    }

                }
            }
            httpxml.onreadystatechange = stateck;
            httpxml.open("GET", "/getTime", true);
            httpxml.send(null);
        }, 1000);
    </script>
</body>

</html>
