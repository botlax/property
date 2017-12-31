@extends('dashboard')

@section('title')
Add Renter | {{config('app.name')}}
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
		user-plus
	@endslot
	@slot('headerTitle')
		Add Renter
	@endslot
	@slot('content')

		{!! Form::open(['route'=>'renter-store', 'files' => true]) !!}
			<div class="form-group">
			    {!! Form::label('name','Name') !!}
			    {!! Form::text('name',old('name'),['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
			    @if ($errors->has('name'))
	                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('email','Email') !!}
			    {!! Form::email('email',old('email'),['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
			    @if ($errors->has('email'))
	                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('mobile','Mobile') !!}
			    {!! Form::text('mobile',old('mobile'),['class' => 'form-control', 'placeholder' => 'Enter mobile']) !!}
			    @if ($errors->has('mobile'))
	                <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('address','Address') !!}
			    {!! Form::text('address',old('address'),['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
			    @if ($errors->has('address'))
	                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('company','Company') !!}
			    {!! Form::text('company',old('company'),['class' => 'form-control', 'placeholder' => 'Enter company']) !!}
			    @if ($errors->has('company'))
	                <div class="invalid-feedback">{{ $errors->first('company') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('co_address','Company Address') !!}
			    {!! Form::text('co_address',old('co_address'),['class' => 'form-control', 'placeholder' => 'Enter company address']) !!}
			    @if ($errors->has('co_address'))
	                <div class="invalid-feedback">{{ $errors->first('co_address') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('co_contact','Company Contact') !!}
			    {!! Form::text('co_contact',old('co_contact'),['class' => 'form-control', 'placeholder' => 'Enter company contact']) !!}
			    @if ($errors->has('co_contact'))
	                <div class="invalid-feedback">{{ $errors->first('co_contact') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('co_person','Contact Person') !!}
			    {!! Form::text('co_person',old('co_person'),['class' => 'form-control', 'placeholder' => 'Enter Contact Person']) !!}
			    @if ($errors->has('co_person'))
	                <div class="invalid-feedback">{{ $errors->first('co_person') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('co_mobile','Contact Person #') !!}
			    {!! Form::text('co_mobile',old('co_mobile'),['class' => 'form-control', 'placeholder' => 'Enter Contact Person #']) !!}
			    @if ($errors->has('co_mobile'))
	                <div class="invalid-feedback">{{ $errors->first('co_mobile') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('qid','QID') !!}
			    {!! Form::file('qid',old('qid'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('qid'))
	                <div class="invalid-feedback">{{ $errors->first('qid') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('contract','Contract') !!}
			    {!! Form::file('contract',old('contract'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('contract'))
	                <div class="invalid-feedback">{{ $errors->first('contract') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('cr','Commercial Registration') !!}
			    {!! Form::file('cr',old('cr'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('cr'))
	                <div class="invalid-feedback">{{ $errors->first('cr') }}</div>
	            @endif
			</div>

			<div class="form-group">
				{!! Form::label('permit','Commercial Permit') !!}
			    {!! Form::file('permit',old('permit'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('permit'))
	                <div class="invalid-feedback">{{ $errors->first('permit') }}</div>
	            @endif
			</div>

			<div class="form-group">
				@if(!empty($properties))
				<select class="form-control" name="properties">
					<option value="">--Select Property--</option>
					@foreach($properties as $id => $name)
				  	<option value="{{$id}}">{{$name}}</option>
				  	@endforeach
				</select>
				@endif
			</div>

			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
	@endslot
@endcomponent

@endsection
