@extends('dashboard')

@section('title')
Owners | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('userClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		user-circle
	@endslot
	@slot('headerTitle')
		Owners
	@endslot
	@slot('content')

	@if(!empty($owners->toArray()))
		<table>
			<thead>
				<th>Name</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>Property</th>
				<th>tools</th>
			</head>
		@foreach($owners as $owner)
			<tr>
				<td><a href="{{ url('users').'/'.$owner->id }}">{{$owner->name}}</a></td>
				<td>{{$owner->email?$owner->email:'--'}}</td>
				<td>{{$owner->mobile?$owner->mobile:'--'}}</td>
				<td>{{$owner->property()->first()?$owner->property()->first()->name:'--'}}</td>
				<td>{!! Form::open(['route' => ['user-delete',$owner->id]]) !!} <button class="btn btn-danger btn-delete"> <i class="fa fa-close"></i> </button> {!! Form::close() !!}</td>
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