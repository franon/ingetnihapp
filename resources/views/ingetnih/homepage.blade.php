@extends('layouts.dashboard')

{{-- @section('title')
    Ingetnih! 
@stop --}}

@section('content')
<section class="py-5 mt-10">
    <div class="container">
    <div id="calendar"></div>
      <h2 class="font-weight-light">Daftar Event</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus ab nulla dolorum autem nisi officiis blanditiis voluptatem hic, assumenda aspernatur facere ipsam nemo ratione cumque magnam enim fugiat reprehenderit expedita.</p>
    </div>
  </section>
@stop

@section('customjs')

<script src="{{asset('js/firebase.js')}}"></script>


{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
<script>
  $(document).ready(function() { 
      // init page
      $('#calendar').fullCalendar({
          defaultView: 'month',
          
          events : [
              @foreach ($event as $evt)
              {
                  title: '{{$evt['event_name']}}',
                  start: '{{$evt['event_date']}}',
                  @if($evt['event_date_end'])
                  end: '{{$evt['event_date_end']}}',
                  @endif
              },
              @endforeach 
          ],
      });
  });
</script>
@stop