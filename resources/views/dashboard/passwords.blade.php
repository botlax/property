@extends('dashboard')

@section('title')
Passwords | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		lock
	@endslot
	@slot('headerTitle')
		Passwords
	@endslot
	@slot('content')
		{!! Form::open(['route' => ['user-update', $self->id],'class' => 'editForm']) !!}
			{!! Form::hidden('field', 'passcode') !!}
			{!! Form::hidden('process', 'update') !!}
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

			<button class="btn btn-primary">Change Password</button>
		{!! Form::close() !!}

		<hr>

		@if(!empty($admins->toArray()))
		<div class="list-wrap">
			<h4>Administrators</h4>
			<ul class="table">
				@foreach($admins as $admin)
				<li><span class="field-title">{{ $admin->name }}</span>
					<p>{{ $admin->email }} ({{ $admin->role }})</p>
					<div class="field-form-wrap">
						
						{!! Form::open(['route' => ['user-update', $admin->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'passcode') !!}
							{!! Form::hidden('process', 'update') !!}

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
						<button class="btn btn-primary">Change Password</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
					</div>
				</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if(!empty($owners->toArray()))
		<div class="list-wrap">
			<h4>Owners</h4>
			<ul class="table">
				@foreach($owners as $owner)
				<li><span class="field-title">{{ $owner->name }}</span>
					<p>{{ $owner->email }} ({{ $owner->role }})</p>
					<div class="field-form-wrap">
						
						{!! Form::open(['route' => ['user-update', $owner->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'passcode') !!}
							{!! Form::hidden('process', 'update') !!}
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
						<button class="btn btn-primary">Change Password</button>
						<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						
					</div>
				</li>
				@endforeach
			</ul>
		</div>
		@endif

	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){

		$('.field-form-wrap').hide();

		$('.btn-delete').click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to delete this entry?")){
				$(this).parent().parent().find('.deleteForm').submit();
			}
		});

		$('.btn-form').click(function(){
			$(this).parent().parent().children().hide();
			$(this).parent().parent().find('span').show();
			$(this).parent().parent().find('.field-form-wrap').show();
		});

		$('.btn-cancel').click(function(){
			$(this).parent().parent().children().show();
			$(this).parent().parent().find('.field-form-wrap').hide();
		});
		
	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection