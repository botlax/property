@extends('dashboard')

@section('title')
Add Owner | {{config('app.name')}}
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
		user-plus
	@endslot
	@slot('headerTitle')
		Add Owner
	@endslot
	@slot('content')

		{!! Form::open(['route'=>'user-store', 'files' => true]) !!}
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
			    {!! Form::label('password','Password') !!}
			    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password']) !!}
			    @if ($errors->has('password'))
	                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('password_confirmation','Repeat Password') !!}
			    {!! Form::password('password_confirmation',['class' => 'form-control', 'placeholder' => 'Repeat Password']) !!}
			    @if ($errors->has('password_confirmation'))
	                <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
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
			    {!! Form::label('job','Job Title') !!}
			    {!! Form::text('job',old('job'),['class' => 'form-control', 'placeholder' => 'Enter job title']) !!}
			    @if ($errors->has('job'))
	                <div class="invalid-feedback">{{ $errors->first('job') }}</div>
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

			<div>
				{!! Form::checkbox('admin','yes',true,['id' => 'admin']) !!}
				{!! Form::label('admin','Owner is an administrator') !!}
				@if ($errors->has('admin'))
	                <span class="error">
	                    <strong>{{ $errors->first('admin') }}</strong>
	                </span>
	            @endif
			</div>

			<div class="form-group admin-form">
				<select class="form-control" name="role">
					<option value="">--Select Role--</option>
					<option value="admin">Administrator</option>
				  	<option value="power">Power User</option>
				  	<option value="spec">Spectator</option>
				</select>
			</div>

			<div class="form-group">
				{!! Form::label('qid','QID') !!}
			    {!! Form::file('qid',old('qid'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('qid'))
	                <div class="invalid-feedback">{{ $errors->first('qid') }}</div>
	            @endif
			</div>

			<div class="form-group">
				@if(!empty($properties))
				<select class="form-control" name="properties">
					<option value="">-- Select Bldg of Residence --</option>
					@foreach($properties as $id => $name)
				  	<option value="{{$id}}">{{$name}}</option>
				  	@endforeach
				</select>
				@endif
			</div>

			<div class="form-group">
				@if(!empty($assets))
				<label for="asset">Owned Property</label>
				<select class="form-control" name="asset[]" multiple id="asset">
					@foreach($assets as $id => $name)
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

@section('script')
	$(document).ready(function(){

		$('#admin').change(function(){
			if($(this).is(':checked')){
				$('.admin-form').show();
			}
			else{
				$('.admin-form select').val('');
				$('.admin-form').hide();
			}
		});

	});
@endsection