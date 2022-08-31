<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">KAA SemNas 2022</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @if(Auth::user()->role == 0)

        @elseif(Auth::user()->role == 1)
        <li class="nav-item">
          <a class="nav-link {{Request::segment(1) == 'dashboard'? 'active' : ''}}" href="/">Home</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{Request::segment(1) == 'banksoal'? 'active' : ''}}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bank Soal
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item {{Request::segment(2) == 'preline'? 'active' : ''}}" href="/banksoal/preline">Preline</a></li>
              <li><a class="dropdown-item {{Request::segment(2) == 'penyisihan1'? 'active' : ''}}" href="/banksoal/penyisihan1">Penyisihan 1</a></li>
              <li><a class="dropdown-item {{Request::segment(2) == 'penyisihan2'? 'active' : ''}}" href="/banksoal/penyisihan2">Penyisihan 2</a></li>
            </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link {{Request::segment(1) == 'peserta'? 'active' : ''}}" aria-current="page" href="/peserta">Peserta</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{Request::segment(1) == 'pembayaran'? 'active' : ''}}" aria-current="page" href="/pembayaran">Pembayaran</a>
        </li>
        @endif
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="nav-link" style="background: none; border:none;">Logout</button>
            </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
