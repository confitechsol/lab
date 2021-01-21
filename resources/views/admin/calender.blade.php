@extends('admin.layout.app')
@section('content')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

<div class="page-wrapper">
     <div class="container">

      {!! $calendar->calendar() !!}
      {!! $calendar->script() !!}
    </div>
</div>
<style>
.fc-basic-view .fc-day-number{
  display:table-cell!important;
}
</style>
@endsection
