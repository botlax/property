@extends('dashboard')

@section('title')
Logs | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		bars
	@endslot
	@slot('headerTitle')
		logs
	@endslot
	@slot('content')
		@if($logs->toArray()['total'] != 0)
			<ul id="logs">
			@foreach($logs as $log)
				<li>
					<p><i class="fa fa-arrow-right"></i> {{$log->desc}} ({{$log->date->format('F d, Y - g:ia')}})</p>
				</li>
			@endforeach
			</ul>
		@else
			<p>No Logs.</p>
		@endif

		{{ $logs->links() }}
	@endslot
@endcomponent

@endsection

