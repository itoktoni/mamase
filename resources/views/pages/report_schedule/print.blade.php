@extends('layouts.print')

@section('content')

<div class="row">
	<div class="col-md-12">
		<h1 class="text-left ml-5 mt-5">{{ __('Schedule Report') }}</h1>
		<div class="header-action">
			<nav>
				<a onclick="window.print()" href="{{ route(SharedData::get('route').'.getPrint') }}">Print PDF</a>
			</nav>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="calendar"></div>
	</div>
</div>
@endsection

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	// pass _token in all ajax
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// initialize calendar in all events
	var calendar = $('#calendar').fullCalendar({
		editable: true,
		header: {
			left: 'prev, next today',
			center: 'title',
			right: 'month, agendaWeek, agendaDay'
		},
		defaultView: 'month',
		events: "{{ route('calendar') }}",
		displayEventTime: true,
		eventRender: function(event, element, view) {
			if (event.allDay === 'true') {
				event.allDay = true;
			} else {
				event.allDay = false;
			}
		},
		selectable: true,
		selectHelper: true,
	});
});
</script>

<style>
#calendar {
	margin: 50px;
	margin-top: 0px;
}
</style>