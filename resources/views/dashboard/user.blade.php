@extends('dashboard')

@section('title')
{{$user->name}} | {{config('app.name')}}
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
		{{$user->name}}
	@endslot
	@slot('content')
		<div id="tools">
	
		</div>
		<ul class="table">
			<li><span class="field-title">Name:</span> <p>{{ $user->name }}</p>
				<div class="field-form-wrap">
					{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
						{!! Form::hidden('field', 'name') !!}
						{!! Form::hidden('process', 'update') !!}
						{!! Form::text('name',old('name')) !!}
						@if ($errors->has('name'))
			                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
			            @endif
						<button class="btn btn-primary">Update</button>
					{!! Form::close() !!}
					<button class="btn btn-danger btn-cancel">cancel</button>
				</div>
				
				<div class="field-tool">
					<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
				</div>
			</li>

			<li><span class="field-title">Email:</span> <p>{{ $user->email }}</p>
				<div class="field-form-wrap">
					{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
						{!! Form::hidden('field', 'email') !!}
						{!! Form::hidden('process', 'update') !!}
						{!! Form::text('email',old('email')) !!}
						@if ($errors->has('email'))
			                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
			            @endif
						<button class="btn btn-primary">Update</button>
					{!! Form::close() !!}
					<button class="btn btn-danger btn-cancel">cancel</button>
				</div>
				
				<div class="field-tool">
					<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
				</div>
			</li>

			<li><span class="field-title">Status:</span>
				<div class="single-form-wrap">
					{!! Form::open(['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
						{!! Form::hidden('field', 'admin') !!}
						{!! Form::hidden('process', 'update') !!}
					<div>
						<input id="admin" name="admin" type="checkbox" {{ $user->admin == 'yes'?'checked':'' }}>
						<label for="admin">Owner is an administrator</label>			
						@if ($errors->has('admin'))
			                <span class="error">
			                    <strong>{{ $errors->first('admin') }}</strong>
			                </span>
			            @endif
					</div>

					<div class="form-group admin-form" {{ $user->admin == 'no'?'style=display:none':'' }}>
						<select class="form-control" name="role">
							<option value="">--Select Role--</option>
							<option {{ $user->role == 'admin'?'selected="selected"':'' }} value="admin">Administrator</option>
						  	<option {{ $user->role == 'power'?'selected="selected"':'' }} value="power">Power User</option>
						  	<option {{ $user->role == 'spec'?'selected="selected"':'' }} value="spec">Spectator</option>
						</select>
					</div>
					<button class="btn btn-primary">Update</button>
					{!! Form::close() !!}
				</div>
			</li>

			<li><span class="field-title">Password:</span>
				<div class="single-form-wrap">
					{!! Form::open(['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
						{!! Form::hidden('field', 'password') !!}
						{!! Form::hidden('process', 'update') !!}
						{!! Form::password('current_password',['placeholder' => 'Enter Current Password']) !!}
						@if ($errors->has('current_password'))
			                <div class="invalid-feedback">{{ $errors->first('current_password') }}</div>
			            @endif
			            {!! Form::password('password',['placeholder' => 'Enter New Password']) !!}
						@if ($errors->has('password'))
			                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
			            @endif
			            {!! Form::password('password_confirmation',['placeholder' => 'Repeat New Password']) !!}
						@if ($errors->has('password_confirmation'))
			                <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
			            @endif
						<button class="btn btn-primary">Update</button>
					{!! Form::close() !!}
				</div>
			</li>

			<li><span class="field-title">Mobile:</span>
				@if($user->mobile)
					
					<p>{{ $user->mobile }}</p>
					<div class="field-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'mobile') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('mobile',old('mobile')) !!}
							@if ($errors->has('mobile'))
				                <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'mobile') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
				@else
					<p>--</p>
					<div class="field-form-wrap">
							{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'mobile') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('mobile',old('mobile')) !!}
								@if ($errors->has('mobile'))
					                <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add mobile</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Address:</span>
				@if($user->address)
					
					<p>{{ $user->address }}</p>
					<div class="field-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'address') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('address',old('address')) !!}
							@if ($errors->has('address'))
				                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'address') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
				@else
					<p>--</p>
					<div class="field-form-wrap">
							{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'address') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('address',old('address')) !!}
								@if ($errors->has('address'))
					                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add address</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Job Title:</span>
				@if($user->job)
					
					<p>{{ $user->job }}</p>
					<div class="field-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'job') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('job',old('job')) !!}
							@if ($errors->has('job'))
				                <div class="invalid-feedback">{{ $errors->first('job') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'job') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
				@else
					<p>--</p>
					<div class="field-form-wrap">
							{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'job') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('job',old('job')) !!}
								@if ($errors->has('job'))
					                <div class="invalid-feedback">{{ $errors->first('job') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add job title</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Company Address:</span>
				@if($user->co_address)
					
					<p>{{ $user->co_address }}</p>
					<div class="field-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'co_address') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('co_address',old('co_address')) !!}
							@if ($errors->has('co_address'))
				                <div class="invalid-feedback">{{ $errors->first('co_address') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'co_address') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
				@else
					<p>--</p>
					<div class="field-form-wrap">
							{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'co_address') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('co_address',old('co_address')) !!}
								@if ($errors->has('co_address'))
					                <div class="invalid-feedback">{{ $errors->first('co_address') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add company address</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Company Contact:</span>
				@if($user->co_contact)
					
					<p>{{ $user->co_contact }}</p>
					<div class="field-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'co_contact') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('co_contact',old('co_contact')) !!}
							@if ($errors->has('co_contact'))
				                <div class="invalid-feedback">{{ $errors->first('co_contact') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'co_contact') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
				@else
					<p>--</p>
					<div class="field-form-wrap">
							{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'co_contact') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('co_contact',old('co_contact')) !!}
								@if ($errors->has('co_contact'))
					                <div class="invalid-feedback">{{ $errors->first('co_contact') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add company contact</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">QID: </span>
				@if($user->qid)
					
					<p><a href="{{$user->qid}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
					<div class="file-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm','files' => true]) !!}
							{!! Form::hidden('field', 'qid') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::file('qid',old('qid')) !!}
							@if ($errors->has('qid'))
				                <div class="invalid-feedback">{{ $errors->first('qid') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'qid') !!}
							{!! Form::hidden('process', 'delete') !!}
							<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
						{!! Form::close() !!}
					</div>
					
				@else
					<p>No file yet. Use the form below to add QID.</p>
					<div class="file-form-wrap">
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm','files' => true]) !!}
							{!! Form::hidden('field', 'qid') !!}
							{!! Form::hidden('process', 'add') !!}
							{!! Form::file('qid',old('qid')) !!}
							@if ($errors->has('qid'))
				                <div class="invalid-feedback">{{ $errors->first('qid') }}</div>
				            @endif
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
					</div>
					
				@endif
			</li>

			<li><span class="field-title">Bldg of Occupancy: </span>
				@if($user->property()->first())
					<p>{{ $user->property()->first()->name }}</p>
					<div class="field-form-wrap">
						{!! Form::model($user,['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'property') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::select('property',$propOpt) !!}
							@if ($errors->has('property'))
				                <div class="invalid-feedback">{{ $errors->first('property') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'property') !!}
							{!! Form::hidden('process', 'delete') !!}
						{!! Form::close() !!}
					</div>
					
					<div class="field-tool">
						<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
				@else
					<p>--</p>
					<div class="field-form-wrap">
						{!! Form::open(['route' => ['user-update', $user->id],'class' => 'addForm']) !!}
							{!! Form::hidden('field', 'property') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::select('property',$propOpt) !!}
							@if ($errors->has('property'))
				                <div class="invalid-feedback">{{ $errors->first('property') }}</div>
				            @endif
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="edit"><i class="fa fa-plus"></i> Add Bldg of Occupancy</button>
					</div>
				@endif
					
			</li>

			<li><span class="field-title">Properties Owned: </span>
				<ul>
				@if($user->asset()->first())
					@foreach($user->asset()->get() as $asset)
					<li>{{ $asset->name }}
					{!! Form::open(['route' => ['user-update', $user->id],'class' => 'deleteForm']) !!}
						{!! Form::hidden('field', 'asset') !!}
						{!! Form::hidden('process', 'delete') !!}
						{!! Form::hidden('asset', $asset->id) !!}
					{!! Form::close() !!}
					<div class="entry-tool">
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
					</div>
					</li>
					@endforeach
				@endif
				</ul>
				<div class="field-form-wrap">
					{!! Form::open(['route' => ['user-update', $user->id],'class' => 'editForm']) !!}
						{!! Form::hidden('field', 'asset') !!}
						{!! Form::hidden('process', 'update') !!}
						{!! Form::select('asset',$assetOpt) !!}
						@if ($errors->has('asset'))
			                <div class="invalid-feedback">{{ $errors->first('asset') }}</div>
			            @endif
						<button class="btn btn-primary">Add</button>
					{!! Form::close() !!}
					<button class="btn btn-danger btn-cancel">cancel</button>
				</div>
				<div class="field-tool">
					<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Properties Owned</button>
				</div>
			</li>

		</ul>


	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){

		var month = [];
		month[1] = 'January';
		month[2] = 'February';
		month[3] = 'March';
		month[4] = 'April';
		month[5] = 'May';
		month[6] = 'June';
		month[7] = 'July';
		month[8] = 'August';
		month[9] = 'September';
		month[10] = 'October';
		month[11] = 'November';
		month[12] = 'December';

		var rentProceed = false;

		$.ajaxSetup({
	    	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	  	});

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

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection