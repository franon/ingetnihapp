@extends('layouts.dashboard')

@section('title')
    BL-Kalender - Detail Berita
@stop

@section('content')

<section class="py-5 mt-10">
  {{-- <div class="container"> --}}
    <div class="search-container container">
      <div class="card text-center">
        <div class="card-header">
          Acara 
        </div>
        <div class="card-body">
          <h5 class="card-title">{{$berita->berita_judul}}</h5>
          {{base64_decode($berita->berita_isi)}}
          {{-- @if (!empty($berita->berita_isi)) <p class="card-text">{{base64_decode($berita->berita_isi)}}</p>@endif --}}
        </div>
        <a href="{{base64_decode($berita->berita_link)}}" class="btn btn-primary">Sumber</a>
        <div class="card-footer text-muted">
          {{$berita->berita_tanggal}}
        </div>
      </div>
    
  </div>
  </section>
  {{-- {{dd($dosen)}} --}}
@stop