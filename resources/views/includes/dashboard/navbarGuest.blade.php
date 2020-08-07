<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{'/'}}">BLINFO</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <form method="get" action="{{ route('search-event')}}" class="form-inline my-2 my-lg-0">
              <input type="text" name="cariacara" id="cariacara" value="{{ request()->input('cariacara')}}" class="form-control mr-sm-2" type="cariacara" placeholder="Cari acara ..." aria-label="Search">
              {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari Acara</button> --}}
            </form>
          <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">BAAK</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/search/dosen">Jadwal Dosen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{'/users/login'}}">Masuk/Daftar</a>
          </li>
        </ul>
      </div>
    </div>
</nav>