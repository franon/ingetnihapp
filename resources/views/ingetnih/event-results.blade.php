@extends('layouts.dashboard')

{{-- @section('title')
    Ingetnih!
@stop --}}

@section('content')

<section class="py-5 mt-10">
  {{-- <div class="container"> --}}
    <div class="search-container container">
    <h2 class="font-weight-light">Daftar Event</h2>
    <p> hasil pencarian untuk '{{request()->input('search')}}'</p>
    <div class="row">
      @foreach ($eventData as $event)
      <div class="col-sm-6 mt-2">
        <div class="card">
          <div class="card-body">
            <a href="{{'/acara/'.$event->event_id}}"><h5 class="card-title">{{$event->event_name}} </h5></a>
            <p class="card-text">{{$event->event_detail}}.</p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Tanggal Mulai {{$event->event_date}} @if(!empty($event->event_date_end)) || Tanggal Akhir {{$event->event_date_end}} @endif</li>
          </ul>
        </div>
      </div>
      @endforeach
    </div>
  {{-- </div> --}}
  </div>
  </section>
  {{-- {{dd($dosen)}} --}}
@stop