<nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{'/'}}">BLINFO!</a>
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
            <a class="nav-link" href="budiluhur.ac.id">BAAK</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/search/dosen">Jadwal Dosen</a>
          </li>
          <!-- Notification -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span><i data-feather="bell" class="svg-icon"></i>Notifications</span>
              <span class="badge badge-primary notify-no rounded-circle">{{count($notifikasi)}}</span>
              </a>
              {{-- {{dd($notifikasi)}} --}}
            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                <ul class="list-style-none">
                    <li>
                        <div class="message-center notifications position-relative">
                            @foreach ($notifikasi as $notif)
                            <a href="javascript:void(0)"
                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                <span class="btn btn-success text-white rounded-circle btn-circle"><i
                                        data-feather="calendar" class="text-white"></i></span>
                                <div class="w-75 d-inline-block v-middle pl-2">
                                  @if(!empty($notif["event_name"])) <h6 class="message-title mb-0 mt-1">{{$notif["event_name"]}}</h6>@endif
                                  @if(!empty($notif["berita_judul"])) <h6 class="message-title mb-0 mt-1">{{$notif["berita_judul"]}}</h6>@endif
                                  @if(!empty($notif["group"])) <h6 class="message-title mb-0 mt-1">{{$notif["group"]}}</h6>@endif
                                  @if(!empty($notif["message"])) <span class="font-12 text-nowrap d-block text-muted text-truncate">{{$notif["message"]}}</span>@endif  
                                  @if (!empty($notif["date_notified"])) <span class="font-12 text-nowrap d-block text-muted">{{$notif["date_notified"]}}</span> @endif
                                  
                                </div>
                            </a>    
                            @endforeach
                            
                    <li>
                        <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);">
                            <strong>Check all notifications</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <!-- End Notification -->
        <!-- ============================================================== -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">{{session()->get('data')->name}}
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class =" nav-link" href="{{'/users/profile'}}">Profile</a></li>
              <li><a class="nav-link" href="{{'/users/logout'}}">Keluar</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
</nav>