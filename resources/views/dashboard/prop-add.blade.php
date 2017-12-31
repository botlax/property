@extends('dashboard')

@section('title')
Properties | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('propClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		building
	@endslot
	@slot('headerTitle')
		Properties
	@endslot
	@slot('content')

		{!! Form::open(['route' => 'prop-store','files'=>true]) !!}
			<div class="form-group">
			    {!! Form::label('name','Name') !!}
			    {!! Form::text('name',old('name'),['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
			    @if ($errors->has('name'))
	                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control', 'placeholder' => 'Enter description']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('location','Location') !!}
			    {!! Form::text('location',old('location'),['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
			    @if ($errors->has('location'))
	                <div class="invalid-feedback">{{ $errors->first('location') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('loc_lat','Latitude') !!}
			    {!! Form::text('loc_lat',old('loc_lat'),['class' => 'form-control', 'placeholder' => 'Enter latitude']) !!}
			    @if ($errors->has('loc_lat'))
	                <div class="invalid-feedback">{{ $errors->first('loc_lat') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('loc_long','Longitude') !!}
			    {!! Form::text('loc_long',old('loc_long'),['class' => 'form-control', 'placeholder' => 'Enter longitude']) !!}
			    @if ($errors->has('loc_long'))
	                <div class="invalid-feedback">{{ $errors->first('loc_long') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('elec','Electricity Number') !!}
			    {!! Form::text('elec',old('elec'),['class' => 'form-control', 'placeholder' => 'Enter Electricity Number']) !!}
			    @if ($errors->has('elec'))
	                <div class="invalid-feedback">{{ $errors->first('elec') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('water','Water Number') !!}
			    {!! Form::text('water',old('water'),['class' => 'form-control', 'placeholder' => 'Enter Water Number']) !!}
			    @if ($errors->has('water'))
	                <div class="invalid-feedback">{{ $errors->first('water') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('p_area','Plot Area') !!}
			    {!! Form::text('p_area',old('p_area'),['class' => 'form-control', 'placeholder' => 'Enter Plot Area']) !!}
			    @if ($errors->has('p_area'))
	                <div class="invalid-feedback">{{ $errors->first('p_area') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('b_area','Built-up Area') !!}
			    {!! Form::text('b_area',old('b_area'),['class' => 'form-control', 'placeholder' => 'Enter Built-up Area']) !!}
			    @if ($errors->has('b_area'))
	                <div class="invalid-feedback">{{ $errors->first('b_area') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('bldg_permit','Building Permit') !!}
			    {!! Form::file('bldg_permit',old('bldg_permit'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('bldg_permit'))
	                <div class="invalid-feedback">{{ $errors->first('bldg_permit') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('completion','Completion Certificate') !!}
			    {!! Form::file('completion',old('completion'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('completion'))
	                <div class="invalid-feedback">{{ $errors->first('completion') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('deed','Title Deed') !!}
			    {!! Form::file('deed',old('deed'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('deed'))
	                <div class="invalid-feedback">{{ $errors->first('deed') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('layout','Layout Copy') !!}
			    {!! Form::file('layout',old('layout'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('layout'))
	                <div class="invalid-feedback">{{ $errors->first('layout') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('floor','Floor Plans') !!}
			    {!! Form::file('floor',old('floor'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('floor'))
	                <div class="invalid-feedback">{{ $errors->first('floor') }}</div>
	            @endif
			</div>

			<div class="form-check">
			  	<label class="form-check-label">
			    	<input class="form-check-input" name="for_rent" type="checkbox" value="yes" checked>
			    	This property is for rent
			  	</label>
			</div>

			@if(!empty($owners))
			<div class="form-group">
			    <label for="owner">Owner</label>
			    <select multiple class="form-control" name="owner[]" id="owner">
			    	@foreach($owners as $key=>$value)
			      	<option value="{{ $key }}">{{ $value }}</option>
			      	@endforeach
			    </select>
			</div>
			@endif

			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){



	});
@endsection