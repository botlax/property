@extends('dashboard')

@section('title')
Error 404 | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		times
	@endslot
	@slot('headerTitle')
		Error 404
	@endslot
	@slot('content')

	
	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){
		window.location.href = '{{url('/')}}';
	});
@endsection