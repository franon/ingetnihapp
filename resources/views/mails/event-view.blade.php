@component('mail::message')
    Hi <strong>{{$user->name}}</strong>, 

    Jangan sampai lupa ya, kalau ada Agenda : <strong> {{$event['event_name']}} </strong> yang akan dimulai hari ini.
    
    Info Detailnya, 
    Hari    : {{$event["event_date"]}}
    @if(!empty($event_time)) di Jam :  {{$event["event_time"]}}@endif
    @if(!empty($event_date_end))Dan hanya mengingatkan, Bahwa Agenda ini berakhir pada :  {{$event["event_date_end"]}}@endif
    
    Jangan sampai terlewatkan ya!

    Terimakasih,
    

    {{config('app.name')}} Team.
@endcomponent