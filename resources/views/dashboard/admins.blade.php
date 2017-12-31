@extends('dashboard')

@section('title')
Administration | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		user-circle
	@endslot
	@slot('headerTitle')
		Administration
	@endslot
	@slot('content')
		{!! Form::open(['route'=>'admin-store', 'files' => true]) !!}
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

			<div class="form-group admin-form">
				<select class="form-control" name="role">
					<option value="">--Select Role--</option>
					<option value="admin">Administrator</option>
				  	<option value="power">Power User</option>
				  	<option value="spec">Spectator</option>
				</select>
			</div>

			<button class="btn btn-primary">Add Administrator</button>
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
							{!! Form::hidden('field', 'god') !!}
							{!! Form::hidden('process', 'update') !!}

						<div class="form-group" {{ $admin->admin == 'no'?'style=display:none':'' }}>
							<select class="form-control" name="role">
								<option value="">--Select Role--</option>
								<option {{ $admin->role == 'admin'?'selected="selected"':'' }} value="admin">Administrator</option>
							  	<option {{ $admin->role == 'power'?'selected="selected"':'' }} value="power">Power User</option>
							  	<option {{ $admin->role == 'spec'?'selected="selected"':'' }} value="spec">Spectator</option>
							</select>
						</div>
						<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $admin->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'god') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
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
							{!! Form::hidden('field', 'admin') !!}
							{!! Form::hidden('process', 'update') !!}
						<div>
							<input id="admin" name="admin" type="checkbox" {{ $owner->admin == 'yes'?'checked':'' }}>
							<label for="admin">Owner is an administrator</label>			
							@if ($errors->has('admin'))
				                <span class="error">
				                    <strong>{{ $errors->first('admin') }}</strong>
				                </span>
				            @endif
						</div>

						<div class="form-group admin-form" {{ $owner->admin == 'no'?'style=display:none':'' }}>
							<select class="form-control" name="role">
								<option value="">--Select Role--</option>
								<option {{ $owner->role == 'admin'?'selected="selected"':'' }} value="admin">Administrator</option>
							  	<option {{ $owner->role == 'power'?'selected="selected"':'' }} value="power">Power User</option>
							  	<option {{ $owner->role == 'spec'?'selected="selected"':'' }} value="spec">Spectator</option>
							</select>
						</div>
						<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $owner->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'admin') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
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