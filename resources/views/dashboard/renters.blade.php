@extends('dashboard')

@section('title')
Renters | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('renterClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		users
	@endslot
	@slot('headerTitle')
		Renters
	@endslot
	@slot('content')

	@if(!empty($renters->toArray()))
		<table>
			<thead>
				<th>Name</th>
				<th>Email</th>
				<th>mobile</th>
				<th>Property</th>
				<th>tools</th>
			</head>
		@foreach($renters as $renter)
			<tr>
				<td><a href="{{ url('renters').'/'.$renter->id }}">{{$renter->name}}</a></td>
				<td>{{$renter->email?$renter->email:'--'}}</td>
				<td>{{$renter->mobile?$renter->mobile:'--'}}</td>
				<td>{{$renter->property()->first()?$renter->property()->first()->name:'--'}}</td>
				<td>{!! Form::open(['route' => ['renter-delete',$renter->id]]) !!} <button class="btn btn-danger btn-delete"> <i class="fa fa-close"></i> </button> {!! Form::close() !!}</td>
			</tr>
		@endforeach
		</table>
		@else
		<p>List Empty</p>
	@endif
		
	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){
		$('.btn-delete').click(function(){
			if(confirm("Are you sure you want to delete this entry?")){
				$(this).parent().submit();
			}
		});
	});
@endsection