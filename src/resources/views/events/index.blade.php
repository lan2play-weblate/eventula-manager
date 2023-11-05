@extends ('layouts.default')

@section ('page_title', Settings::getOrgName() . ' - Events')

@section ('content')
<!-- I know, this card under a card is not cool, but i wont duplicate the information-card for a unused index page of events ;-) -->
<div class="container pt-1">
	<div class="pb-2 mt-4 mb-4 border-bottom">
		<h1>
			Events
		</h1>
	</div>
	@foreach ($events as $event)	
	<div class="card card-header">
	<strong><h2 href="/events/{{ $event->slug }}">{{ $event->display_name }}</h2></strong>
	</div>
	@include ('layouts._partials._events.information-card')
	@endforeach
</div>

@endsection
