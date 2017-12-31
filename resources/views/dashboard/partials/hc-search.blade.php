@extends('dashboard')

@section('title')
Health Card Expiry | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('hcClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		file
	@endslot
	@slot('headerTitle')
		Health Card Expiry
	@endslot
	@slot('content')
		{!! Form::open(['route' => 'hc-search','id' => 'searchForm']) !!}
			{!! Form::label('from','From') !!}
			{!! Form::text('from') !!}
			@if ($errors->has('from'))
                <span class="error">
                    <strong>{{ $errors->first('from') }}</strong>
                </span>
            @endif
			{!! Form::label('to','To') !!}
			{!! Form::text('to') !!}
			@if ($errors->has('to'))
                <span class="error">
                    <strong>{{ $errors->first('to') }}</strong>
                </span>
            @endif
			{!! Form::submit('search') !!}
		{!! Form::close() !!}

		<a href="{{url('hc-expiry')}}">Summary</a>


		@if(!empty($emps->toArray()))
			<h4>Health Cards Expiring between {{$from->format('F d, Y')}} to {{$to->format('F d, Y')}}</h4>
			@foreach($emps as $e)
			<p><a href="{{url('employees/'.$e->id)}}">{{$e->emp_id}} - {{$e->name}} ({{$e->health_card}} - {{$e->hc_expiry->format('F d, Y')}})</a></p>
			@endforeach
		@else
		<p>No Health Card will expire between {{$from->format('F d, Y')}} to {{$to->format('F d, Y')}}</p>
		@endif

	@endslot
@endcomponent

@endsection

@section('modal')

@endsection

@section('script')
	$(document).ready(function(){
		$('#from,#to').datepicker();
		$('#from,#to').datepicker("option", "dateFormat", "yy-mm-dd");

		if($('#from').attr('value') != undefined){
			$('#from').val($('#from').attr('value').replace(' 00:00:00',''));
		}
		if($('#to').attr('value') != undefined){
			$('#to').val($('#to').attr('value').replace(' 00:00:00',''));
		}
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection