@extends('dashboard')

@section('title')
{{$renter->name}} | {{config('app.name')}}
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
		{{$renter->name}}
	@endslot
	@slot('content')
		<div id="tools">
	
		</div>
		<ul class="table">
			<li><span class="field-title">Name:</span>
			 	<p>{{ $renter->name }}</p>
				<div class="field-form-wrap">
					{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
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

			<li><span class="field-title">Email: </span>
				@if($renter->email)
					
					<p>{{ $renter->email }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'email') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::email('email',old('email')) !!}
							@if ($errors->has('email'))
				                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'email') !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'email') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::email('email',old('email')) !!}
								@if ($errors->has('email'))
					                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add email</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Mobile: </span>
				@if($renter->mobile)
					
					<p>{{ $renter->mobile }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'mobile') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('mobile',old('mobile')) !!}
							@if ($errors->has('mobile'))
				                <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
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

			<li><span class="field-title">Address: </span>
				@if($renter->address)
					
					<p>{{ $renter->address }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'address') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('address',old('address')) !!}
							@if ($errors->has('address'))
				                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
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

			<li><span class="field-title">Company: </span>
				@if($renter->company)
					
					<p>{{ $renter->company }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'company') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('company',old('company')) !!}
							@if ($errors->has('company'))
				                <div class="invalid-feedback">{{ $errors->first('company') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'company') !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'company') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('company',old('company')) !!}
								@if ($errors->has('company'))
					                <div class="invalid-feedback">{{ $errors->first('company') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add company</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Company Contact Person: </span>
				@if($renter->co_person)
					
					<p>{{ $renter->co_person }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'co_person') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('co_person',old('co_person')) !!}
							@if ($errors->has('co_person'))
				                <div class="invalid-feedback">{{ $errors->first('co_person') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'co_person') !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'co_person') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('co_person',old('co_person')) !!}
								@if ($errors->has('co_person'))
					                <div class="invalid-feedback">{{ $errors->first('co_person') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Company Contact Person</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Company Contact Person #: </span>
				@if($renter->co_mobile)
					
					<p>{{ $renter->co_mobile }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'co_mobile') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('co_mobile',old('co_mobile')) !!}
							@if ($errors->has('co_mobile'))
				                <div class="invalid-feedback">{{ $errors->first('co_mobile') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'co_mobile') !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
								{!! Form::hidden('field', 'co_mobile') !!}
								{!! Form::hidden('process', 'add') !!}
								{!! Form::text('co_mobile',old('co_mobile')) !!}
								@if ($errors->has('co_mobile'))
					                <div class="invalid-feedback">{{ $errors->first('co_mobile') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
					</div>
					<div class="field-tool">
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Company Contact Person #</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Company Contact #: </span>
				@if($renter->co_contact)
					
					<p>{{ $renter->co_contact }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'co_contact') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('co_contact',old('co_contact')) !!}
							@if ($errors->has('co_contact'))
				                <div class="invalid-feedback">{{ $errors->first('co_contact') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
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
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Company Contact #</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">Company Address: </span>
				@if($renter->co_address)
					
					<p>{{ $renter->co_address }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'co_address') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::text('co_address',old('co_address')) !!}
							@if ($errors->has('co_address'))
				                <div class="invalid-feedback">{{ $errors->first('co_address') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
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
							{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
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
						<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Company Address</button>
					</div>
				@endif
			</li>

			<li><span class="field-title">QID: </span>
				@if($renter->qid)
					
					<p><a href="{{$renter->qid}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
					<div class="file-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm','files' => true]) !!}
							{!! Form::hidden('field', 'qid') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::file('qid',old('qid')) !!}
							@if ($errors->has('qid'))
				                <div class="invalid-feedback">{{ $errors->first('qid') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'qid') !!}
							{!! Form::hidden('process', 'delete') !!}
							<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
						{!! Form::close() !!}
					</div>
					
				@else
					<p>No file yet. Use the form on the right to add QID.</p>
					<div class="file-form-wrap">
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm','files' => true]) !!}
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

			<li><span class="field-title">Government Contract: </span>
				@if($renter->contract)
					
					<a href="{{$renter->contract}}" target="_blank">Download <i class="fa fa-download"></i></a>
					<div class="file-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm','files' => true]) !!}
							{!! Form::hidden('field', 'contract') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::file('contract',old('contract')) !!}
							@if ($errors->has('contract'))
				                <div class="invalid-feedback">{{ $errors->first('contract') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'contract') !!}
							{!! Form::hidden('process', 'delete') !!}
							<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
						{!! Form::close() !!}
					</div>
					
				@else
					<p>No file yet. Use the form on the right to add QID.</p>
					<div class="file-form-wrap">
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm','files' => true]) !!}
							{!! Form::hidden('field', 'contract') !!}
							{!! Form::hidden('process', 'add') !!}
							{!! Form::file('contract',old('contract')) !!}
							@if ($errors->has('contract'))
				                <div class="invalid-feedback">{{ $errors->first('contract') }}</div>
				            @endif
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
					</div>
					
				@endif
			</li>

			<li><span class="field-title">Renter Contract: </span>
				@if($renter->p_contract)
					
					<a href="{{$renter->p_contract}}" target="_blank">Download <i class="fa fa-download"></i></a>
					<div class="file-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm','files' => true]) !!}
							{!! Form::hidden('field', 'p_contract') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::file('p_contract',old('p_contract')) !!}
							@if ($errors->has('p_contract'))
				                <div class="invalid-feedback">{{ $errors->first('p_contract') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'p_contract') !!}
							{!! Form::hidden('process', 'delete') !!}
							<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
						{!! Form::close() !!}
					</div>
					
				@else
					<p>No file yet. Use the form on the right to add QID.</p>
					<div class="file-form-wrap">
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm','files' => true]) !!}
							{!! Form::hidden('field', 'p_contract') !!}
							{!! Form::hidden('process', 'add') !!}
							{!! Form::file('p_contract',old('p_contract')) !!}
							@if ($errors->has('p_contract'))
				                <div class="invalid-feedback">{{ $errors->first('p_contract') }}</div>
				            @endif
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
					</div>
					
				@endif
			</li>

			<li><span class="field-title">Commercial Registration: </span>
				@if($renter->cr)
					
					<a href="{{$renter->cr}}" target="_blank">Download <i class="fa fa-download"></i></a>
					<div class="file-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm','files' => true]) !!}
							{!! Form::hidden('field', 'cr') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::file('cr',old('cr')) !!}
							@if ($errors->has('cr'))
				                <div class="invalid-feedback">{{ $errors->first('cr') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'cr') !!}
							{!! Form::hidden('process', 'delete') !!}
							<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
						{!! Form::close() !!}
					</div>
					
				@else
					<p>No file yet. Use the form on the right to add QID.</p>
					<div class="file-form-wrap">
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm','files' => true]) !!}
							{!! Form::hidden('field', 'cr') !!}
							{!! Form::hidden('process', 'add') !!}
							{!! Form::file('cr',old('cr')) !!}
							@if ($errors->has('cr'))
				                <div class="invalid-feedback">{{ $errors->first('cr') }}</div>
				            @endif
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
					</div>
					
				@endif
			</li>

			<li><span class="field-title">Building Permit: </span>
				@if($renter->permit)
					
					<a href="{{$renter->permit}}" target="_blank">Download <i class="fa fa-download"></i></a>
					<div class="file-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm','files' => true]) !!}
							{!! Form::hidden('field', 'permit') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::file('permit',old('permit')) !!}
							@if ($errors->has('permit'))
				                <div class="invalid-feedback">{{ $errors->first('permit') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
							{!! Form::hidden('field', 'permit') !!}
							{!! Form::hidden('process', 'delete') !!}
							<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
						{!! Form::close() !!}
					</div>
					
				@else
					<p>No file yet. Use the form on the right to add QID.</p>
					<div class="file-form-wrap">
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm','files' => true]) !!}
							{!! Form::hidden('field', 'permit') !!}
							{!! Form::hidden('process', 'add') !!}
							{!! Form::file('permit',old('permit')) !!}
							@if ($errors->has('permit'))
				                <div class="invalid-feedback">{{ $errors->first('permit') }}</div>
				            @endif
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
					</div>
					
				@endif
			</li>

			<li><span class="field-title">Bldg of Occupancy: </span>
				@if($renter->property()->first())
					<p>{{ $renter->property()->first()->name }}</p>
					<div class="field-form-wrap">
						{!! Form::model($renter,['route' => ['renter-update', $renter->id],'class' => 'editForm']) !!}
							{!! Form::hidden('field', 'property') !!}
							{!! Form::hidden('process', 'update') !!}
							{!! Form::select('property',$propOpt) !!}
							@if ($errors->has('property'))
				                <div class="invalid-feedback">{{ $errors->first('property') }}</div>
				            @endif
							<button class="btn btn-primary">Update</button>
						{!! Form::close() !!}
						<button class="btn btn-danger btn-cancel">cancel</button>
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'deleteForm']) !!}
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
						{!! Form::open(['route' => ['renter-update', $renter->id],'class' => 'addForm']) !!}
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

	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection
