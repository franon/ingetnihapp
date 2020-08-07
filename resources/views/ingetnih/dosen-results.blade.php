@extends('layouts.dashboard')

{{-- @section('title')
    Ingetnih!
@stop --}}

@section('content')

<section class="py-5 mt-10">
  <div class="container">
    <h2 class="font-weight-light">Daftar Dosen</h2>
    <form method="POST" action="{{'/search/dosen/data'}}">
      @csrf
          <div class="md-form active-cyan-2 mb-3">
            <input class="form-control" type="text" aria-label="Search" name="search" placeholder="Cari Nama Dosen ...">
          </div>
          <button type="submit" class="btn btn-success">Cari</button>
        </form>
      </br>
      @if (isset($dosenData))
      <div class="card-deck">
        @foreach ($dosenData as $dosen)
        <div class="card" style="width: 18rem;">
          <a href="/profile/dosen/{{$dosen->user_id}}"><img src="https://widgetwhats.com/app/uploads/2019/11/free-profile-photo-whatsapp-4-300x300.png" class="card-img-top" alt="..."></a>
          <h5 class="card-title">{{$dosen->name}}</h5>
          <div class="card-body">
            <p class="card-text">Untuk lihat jadwal Dosen {{$dosen->name}}, klik Profilenya.</p>
            {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
          </div>
        </div>
        @endforeach          
      @endif

        </div>
  </section>
  {{-- {{dd($dosen)}} --}}
@stop