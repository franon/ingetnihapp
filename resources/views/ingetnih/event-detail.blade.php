@extends('layouts.dashboard')

{{-- @section('title')
    Ingetnih!
@stop --}}

@section('content')

<section class="py-5 mt-10">
  {{-- <div class="container"> --}}
    <div class="search-container container">
      <div class="card text-center">
        <div class="card-header">
          Acara 
        </div>
        <div class="card-body">
          <h5 class="card-title">{{$event->event_name}}</h5>
          @if (!empty($event->event_detail)) <p class="card-text">{{$event->event_detail}}</p>@endif
        </div>
        <div class="card-footer text-muted">
          {{$event->event_date}}
        </div>
      </div>
    
  </div>
  </section>
  {{-- {{dd($dosen)}} --}}
@stop