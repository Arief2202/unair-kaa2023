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
        <div class="card mt-5">
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                    Kompetisi Belum Dimulai, Menunggu Dimulai oleh panitia
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
      var sesi = ["Simulasi", "Kompetisi"];

      function printTime(time) {
          var days = Math.floor(time / (1000 * 60 * 60 * 24));
          var hours = Math.floor((time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((time % (1000 * 60)) / 1000);
          return days + " Hari " + hours + " Jam " + minutes + " Menit " + seconds + " Detik ";
      }
      var lastState = false;
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