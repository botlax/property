@extends('dashboard')

@section('title')
{{$property->name}} | {{config('app.name')}}
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
		{{$property->name}}
	@endslot
	@slot('content')
		<div class="header">
			<div class="links">
				<a href="{{url('maintenance').'/'.$property->id}}" class="btn btn-success"><i class="fa fa-wrench"></i> Maintenance Logs</a>
				<a href="{{url('payments').'/'.$property->id}}" class="btn btn-success"><i class="fa fa-money"></i> Payment History</a>
				<a href="{{url('guarantees').'/'.$property->id}}" class="btn btn-success"><i class="fa fa-wrench"></i> Guarantees</a>
				<a href="{{url('expenses').'/'.$property->id}}" class="btn btn-success"><i class="fa fa-wrench"></i> Expenses</a>
			</div>
			<div class="header-tools">
				<button class="btn btn-primary" onclick="printDiv('property-details')"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>

		<div id="property-details">
			<div class="list-wrap">
				<h4>Property Details</h4>
				<ul class="table">
					<li><span class="field-title">Name:</span> <p>{{ $property->name }}</p>
						<div class="field-form-wrap">
							{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
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
					<li><span class="field-title">Description: </span>
						@if($property->desc)
							
							<p>{{ $property->desc }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'desc') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::textarea('desc',old('desc')) !!}
									@if ($errors->has('desc'))
						                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'desc') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'desc') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::textarea('desc',old('desc')) !!}
										@if ($errors->has('desc'))
							                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add description</button>
							</div>
						@endif
					</li>
					<li><span class="field-title">Electricity No: </span>
						@if($property->elec)
							
							<p>{{ $property->elec }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'elec') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::text('elec',old('elec')) !!}
									@if ($errors->has('elec'))
						                <div class="invalid-feedback">{{ $errors->first('elec') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'elec') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'elec') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::text('elec',old('elec')) !!}
										@if ($errors->has('elec'))
							                <div class="invalid-feedback">{{ $errors->first('elec') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Electricity No</button>
							</div>
						@endif
					</li>
					<li><span class="field-title">Water No: </span>
						@if($property->water)
							
							<p>{{ $property->water }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'water') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::text('water',old('water')) !!}
									@if ($errors->has('water'))
						                <div class="invalid-feedback">{{ $errors->first('water') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'water') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'water') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::text('water',old('water')) !!}
										@if ($errors->has('water'))
							                <div class="invalid-feedback">{{ $errors->first('water') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Water No</button>
							</div>
						@endif
					</li>
					<li><span class="field-title">Location: </span>
						@if($property->location)
							
							<p>{{ $property->location }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'location') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::text('location',old('location')) !!}
									@if ($errors->has('location'))
						                <div class="invalid-feedback">{{ $errors->first('location') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'location') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'location') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::text('location',old('location')) !!}
										@if ($errors->has('location'))
							                <div class="invalid-feedback">{{ $errors->first('location') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add location</button>
							</div>
						@endif
					</li>

					@if($property->for_rent == 'yes')
					<li><span class="field-title">Monthly Rent Fee: </span>
						@if($property->fee)
							
							<p>QAR {{ $property->fee }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'fee') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::text('fee',old('fee')) !!}
									@if ($errors->has('fee'))
						                <div class="invalid-feedback">{{ $errors->first('fee') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'fee') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'fee') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::text('fee',old('fee')) !!}
										@if ($errors->has('fee'))
							                <div class="invalid-feedback">{{ $errors->first('fee') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Monthly Rent Fee</button>
							</div>
						@endif
					</li>
					@endif

					<li><span class="field-title">Plot Area: </span>
						@if($property->p_area)
							
							<p>{{ $property->p_area }} m<sup>2</sup></p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'p_area') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::text('p_area',old('p_area')) !!}
									@if ($errors->has('p_area'))
						                <div class="invalid-feedback">{{ $errors->first('p_area') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'p_area') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'p_area') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::text('p_area',old('p_area')) !!}
										@if ($errors->has('p_area'))
							                <div class="invalid-feedback">{{ $errors->first('p_area') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Plot Area</button>
							</div>
						@endif
					</li>

					<li><span class="field-title">Built-up Area: </span>
						@if($property->b_area)
							
							<p>{{ $property->b_area }} m<sup>2</sup></p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'b_area') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::text('b_area',old('b_area')) !!}
									@if ($errors->has('b_area'))
						                <div class="invalid-feedback">{{ $errors->first('b_area') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'b_area') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'b_area') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::text('b_area',old('b_area')) !!}
										@if ($errors->has('b_area'))
							                <div class="invalid-feedback">{{ $errors->first('b_area') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Built-up Area</button>
							</div>
						@endif
					</li>

					@if($property->for_rent == 'yes')
					<li><span class="field-title">Renter: </span>
						@if($property->renter()->first())
							
							<p>{{ $property->renter()->first()->name }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'renter') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::select('renter',$renterOpt) !!}
									@if ($errors->has('renter'))
						                <div class="invalid-feedback">{{ $errors->first('renter') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'renter') !!}
									{!! Form::hidden('process', 'delete') !!}
								{!! Form::close() !!}
							</div>
							
							<div class="field-tool">
								<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
								<button class="btn btn-danger renter-delete" title="delete"><i class="fa fa-close"></i></button>
							</div>
						@else
							<p>--</p>
							<div class="field-form-wrap">
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'renter') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::select('renter',$renterOpt) !!}
										@if ($errors->has('renter'))
							                <div class="invalid-feedback">{{ $errors->first('renter') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Renter</button>
							</div>
						@endif
						
					</li>
					@else
					<li><span class="field-title">Occupant: </span>
						@if($property->owner()->first())
							
							<p>{{ $property->owner()->first()->name }}</p>
							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'owner') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::select('owner',$ownerOpt) !!}
									@if ($errors->has('owner'))
						                <div class="invalid-feedback">{{ $errors->first('owner') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'owner') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'owner') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::select('owner',$ownerOpt) !!}
										@if ($errors->has('owner'))
							                <div class="invalid-feedback">{{ $errors->first('owner') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Occupant</button>
							</div>
						@endif
						
					</li>
					@endif
					
					<li><span class="field-title">Owner: </span>
						<ul>
						@if($property->god()->first())
							@foreach($property->god()->get() as $god)
							<li>{{ $god->name }}
							{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
								{!! Form::hidden('field', 'god') !!}
								{!! Form::hidden('process', 'delete') !!}
								{!! Form::hidden('god', $god->id) !!}
							{!! Form::close() !!}
							<div class="entry-tool">
								<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
							</div>
							</li>
							@endforeach
						@endif
						</ul>
						<div class="field-form-wrap">
							{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
								{!! Form::hidden('field', 'god') !!}
								{!! Form::hidden('process', 'update') !!}
								{!! Form::select('owner[]',$owners,['multiple']) !!}
								@if ($errors->has('owner'))
					                <div class="invalid-feedback">{{ $errors->first('owner') }}</div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
						</div>
						<div class="field-tool">
							<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Owner</button>
						</div>
					</li>

					<li><span class="field-title">Status: </span>
						@if($property->for_rent == 'yes')
							
							<p>For Rental</p>
							
						@else
							<p>Not for Rental</p>
							
						@endif
						<div class="field-form-wrap">
							{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm', 'id' => 'rentalStatus']) !!}
								{!! Form::hidden('field', 'for_rent') !!}
								{!! Form::hidden('process', 'update') !!}
								<label for="for_rent"><input type="checkbox" name="for_rent" id="for_rent" value="yes" {{$property->for_rent?'checked':''}}>
								This property is for rent
								</label>
								<button class="btn btn-primary">Update</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
						</div>
						
						<div class="field-tool">
							<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
						</div>

					</li>
					<li><span class="field-title">Map: </span>
						@if($property->loc_long && $property->loc_lat)
							
							<div class="entry-content">
								<a class="btn btn-primary" href="http://www.google.com/maps/place/{{ $property->loc_lat }},{{ $property->loc_long }}" target="_blank"><i class="fa fa-map-marker"></i> Open in Google Maps</a>
								<div id="gmap" style="height: 300px"></div>
							</div>

							<div class="field-form-wrap">
								{!! Form::model($property,['route' => ['prop-update', $property->id],'class' => 'editForm']) !!}
									{!! Form::hidden('field', 'map') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::label('loc_lat','Latitude') !!}
									{!! Form::text('loc_lat',old('loc_lat')) !!}
									@if ($errors->has('loc_lat'))
						                <div class="invalid-feedback">{{ $errors->first('loc_lat') }}</div>
						            @endif
						            {!! Form::label('loc_long','Longitude') !!}
						            {!! Form::text('loc_long',old('loc_long')) !!}
									@if ($errors->has('loc_long'))
						                <div class="invalid-feedback">{{ $errors->first('loc_long') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								<button class="btn btn-danger btn-cancel">cancel</button>
								{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'map') !!}
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
									{!! Form::open(['route' => ['prop-update', $property->id],'class' => 'addForm']) !!}
										{!! Form::hidden('field', 'map') !!}
										{!! Form::hidden('process', 'add') !!}
										{!! Form::label('loc_lat','Latitude') !!}
										{!! Form::text('loc_lat',old('loc_lat')) !!}
										@if ($errors->has('loc_lat'))
							                <div class="invalid-feedback">{{ $errors->first('loc_lat') }}</div>
							            @endif
							            {!! Form::label('loc_long','Longitude') !!}
										{!! Form::text('loc_long',old('loc_long')) !!}
										@if ($errors->has('loc_long'))
							                <div class="invalid-feedback">{{ $errors->first('loc_long') }}</div>
							            @endif
										<button class="btn btn-primary">Add</button>
									{!! Form::close() !!}
									<button class="btn btn-danger btn-cancel">cancel</button>
							</div>
							<div class="field-tool">
								<button class="btn btn-primary btn-form" title="add"><i class="fa fa-plus"></i> Add Routes</button>
							</div>
						@endif
					</li>
				</ul>
			</div>

			<hr>

			<div class="list-wrap">
				<h4>Files</h4>
				<ul class="table">
					<li><span class="field-title">Building Permit: </span>
						@if($property->bldg_permit)
							
							<p><a href="{{$property->bldg_permit}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
							<div class="file-form-wrap">
								{!! Form::model($property,['route' => ['prop-file-update', $property->id],'class' => 'editForm','files' => true]) !!}
									{!! Form::hidden('field', 'bldg_permit') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::file('bldg_permit',old('bldg_permit')) !!}
									@if ($errors->has('bldg_permit'))
						                <div class="invalid-feedback">{{ $errors->first('bldg_permit') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'bldg_permit') !!}
									{!! Form::hidden('process', 'delete') !!}
									<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
								{!! Form::close() !!}
							</div>
							
						@else
							<p>No file yet. Use the form below to add building permit.</p>
							<div class="file-form-wrap">
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'addForm','files' => true]) !!}
									{!! Form::hidden('field', 'bldg_permit') !!}
									{!! Form::hidden('process', 'add') !!}
									{!! Form::file('bldg_permit',old('bldg_permit')) !!}
									@if ($errors->has('bldg_permit'))
						                <div class="invalid-feedback">{{ $errors->first('bldg_permit') }}</div>
						            @endif
									<button class="btn btn-primary">Add</button>
								{!! Form::close() !!}
							</div>
							
						@endif
					</li>

					<li><span class="field-title">Completion Certificate: </span>
						@if($property->completion)
							
							<p><a href="{{$property->completion}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
							<div class="file-form-wrap">
								{!! Form::model($property,['route' => ['prop-file-update', $property->id],'class' => 'editForm','files' => true]) !!}
									{!! Form::hidden('field', 'completion') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::file('completion',old('completion')) !!}
									@if ($errors->has('completion'))
						                <div class="invalid-feedback">{{ $errors->first('completion') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'completion') !!}
									{!! Form::hidden('process', 'delete') !!}
									<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
								{!! Form::close() !!}
							</div>
							
						@else
							<p>No file yet. Use the form below to add building permit.</p>
							<div class="file-form-wrap">
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'addForm','files' => true]) !!}
									{!! Form::hidden('field', 'completion') !!}
									{!! Form::hidden('process', 'add') !!}
									{!! Form::file('completion',old('completion')) !!}
									@if ($errors->has('completion'))
						                <div class="invalid-feedback">{{ $errors->first('completion') }}</div>
						            @endif
									<button class="btn btn-primary">Add</button>
								{!! Form::close() !!}
							</div>
							
						@endif
					</li>

					<li><span class="field-title">Title Deed: </span>
						@if($property->deed)
							
							<p><a href="{{$property->deed}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
							<div class="file-form-wrap">
								{!! Form::model($property,['route' => ['prop-file-update', $property->id],'class' => 'editForm','files' => true]) !!}
									{!! Form::hidden('field', 'deed') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::file('deed',old('deed')) !!}
									@if ($errors->has('deed'))
						                <div class="invalid-feedback">{{ $errors->first('deed') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'deed') !!}
									{!! Form::hidden('process', 'delete') !!}
									<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
								{!! Form::close() !!}
							</div>
							
						@else
							<p>No file yet. Use the form below to add building permit.</p>
							<div class="file-form-wrap">
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'addForm','files' => true]) !!}
									{!! Form::hidden('field', 'deed') !!}
									{!! Form::hidden('process', 'add') !!}
									{!! Form::file('deed',old('deed')) !!}
									@if ($errors->has('deed'))
						                <div class="invalid-feedback">{{ $errors->first('deed') }}</div>
						            @endif
									<button class="btn btn-primary">Add</button>
								{!! Form::close() !!}
							</div>
							
						@endif
					</li>

					<li><span class="field-title">Layout: </span>
						@if($property->layout)
							
							<p><a href="{{$property->layout}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
							<div class="file-form-wrap">
								{!! Form::model($property,['route' => ['prop-file-update', $property->id],'class' => 'editForm','files' => true]) !!}
									{!! Form::hidden('field', 'layout') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::file('layout',old('layout')) !!}
									@if ($errors->has('layout'))
						                <div class="invalid-feedback">{{ $errors->first('layout') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'layout') !!}
									{!! Form::hidden('process', 'delete') !!}
									<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
								{!! Form::close() !!}
							</div>
							
						@else
							<p>No file yet. Use the form below to add building permit.</p>
							<div class="file-form-wrap">
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'addForm','files' => true]) !!}
									{!! Form::hidden('field', 'layout') !!}
									{!! Form::hidden('process', 'add') !!}
									{!! Form::file('layout',old('layout')) !!}
									@if ($errors->has('layout'))
						                <div class="invalid-feedback">{{ $errors->first('layout') }}</div>
						            @endif
									<button class="btn btn-primary">Add</button>
								{!! Form::close() !!}
							</div>
							
						@endif
					</li>

					<li><span class="field-title">Floor Plans: </span>
						@if($property->floor)
							
							<p><a href="{{$property->floor}}" target="_blank">Download <i class="fa fa-download"></i></a></p>
							<div class="file-form-wrap">
								{!! Form::model($property,['route' => ['prop-file-update', $property->id],'class' => 'editForm','files' => true]) !!}
									{!! Form::hidden('field', 'floor') !!}
									{!! Form::hidden('process', 'update') !!}
									{!! Form::file('floor',old('floor')) !!}
									@if ($errors->has('floor'))
						                <div class="invalid-feedback">{{ $errors->first('floor') }}</div>
						            @endif
									<button class="btn btn-primary">Update</button>
								{!! Form::close() !!}
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'deleteForm']) !!}
									{!! Form::hidden('field', 'floor') !!}
									{!! Form::hidden('process', 'delete') !!}
									<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
								{!! Form::close() !!}
							</div>
							
						@else
							<p>No file yet. Use the form below to add building permit.</p>
							<div class="file-form-wrap">
								{!! Form::open(['route' => ['prop-file-update', $property->id],'class' => 'addForm','files' => true]) !!}
									{!! Form::hidden('field', 'floor') !!}
									{!! Form::hidden('process', 'add') !!}
									{!! Form::file('floor',old('floor')) !!}
									@if ($errors->has('floor'))
						                <div class="invalid-feedback">{{ $errors->first('floor') }}</div>
						            @endif
									<button class="btn btn-primary">Add</button>
								{!! Form::close() !!}
							</div>
							
						@endif
					</li>
				</ul>
			</div>

			<hr>

			<div class="list-wrap">
				<h4>Drawings</h4>
				<ul class="table">
				@if(!empty($asBuilt->toArray()))
					@foreach($asBuilt as $ab)
					<li>
						<div class="entry-link">
							<a href="{{$ab->drawing}}" target="_blank">{{$ab->drawingFileName}} <i class="fa fa-download"></i></a>
						</div>
						<div class="link-tool">
							<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						</div>
						{!! Form::open(['route' => ['draw-delete', $ab->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
					</li>
					@endforeach
				@endif
					<li>
						<div class="single-form-wrap">
							{!! Form::open(['route' => ['draw-store', $property->id],'files' => true]) !!}
								{!! Form::file('drawing[]',['multiple' => 'multiple']) !!}

								@if (count($errors->messages()) && $errors->has('drawing.0'))
					            <div class="error-wrap">
					                <ul class="error">
					                @foreach($errors->messages() as $error)
					                    <li>{{ $error[0] }}</li>
					                @endforeach
					                </ul>
					            </div>
					            @endif
								<button class="btn btn-primary">Add</button>
							{!! Form::close() !!}
						</div>
					</li>
				</ul>
			</div>	

			<hr>

			<div class="list-wrap">
				<h4>Assets</h4>
				<ul class="table">
				@if(!empty($furnitures->toArray()))
					@foreach($furnitures as $furn)
					<li><span class="field-title">{{ $furn->pivot->num }} Nos.</span>
						<p>{{ $furn->name }}</p>
						<div class="field-form-wrap">
							{!! Form::model($furn->pivot,['route' => ['prop-furn-update', $property->id],'class' => 'editForm','files' => true]) !!}
								{!! Form::hidden('furn_id', $furn->id) !!}
								{!! Form::label('num', $furn->name) !!}
								{!! Form::number('num',old('num'),['min' => 1]) !!}
								<button class="btn btn-primary">Update</button>
							{!! Form::close() !!}
							<button class="btn btn-danger btn-cancel">cancel</button>
							{!! Form::open(['route' => ['prop-furn-delete', $property->id],'class' => 'deleteForm']) !!}
								{!! Form::hidden('furn_id',$furn->id) !!}
							{!! Form::close() !!}
						</div>
						<div class="field-tool">
							<button class="btn btn-success btn-form" title="edit"><i class="fa fa-wrench"></i></button>
							<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						</div>
					</li>
					@endforeach
				@endif
					<li>
						<div class="single-form-wrap">
						@if(!empty($furnOpt))
						{!! Form::open(['route' => ['prop-furn-store', $property->id]]) !!}

							{!! Form::select('furniture',$furnOpt) !!}

							{!! Form::label('amount', 'Nos.') !!}
							{!! Form::number('amount',1,['min' => 1]) !!}
							<button class="btn btn-primary">Add</button>
						{!! Form::close() !!}
						@else
						<p>Asset list is empty. Click <a href="{{ url('furnitures') }}">here</a> and add asset.</p>	
						@endif
						</div>
					</li>
				</ul>
			</div>
		</div>


	@endslot
@endcomponent

@endsection

@section('script')
		function printDiv(divName) {
		     var printContents = document.getElementById(divName).innerHTML;
		     var originalContents = document.body.innerHTML;

		     document.body.innerHTML = printContents;

		     window.print();

		     document.body.innerHTML = originalContents;
		}

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

		$('#rentalStatus').submit(function(e){
			if(!$(this).find('#for_rent').is(':checked') && !rentProceed){
				e.preventDefault();
				$.ajax({
				    url: '{{url('get-pending-payments')}}',
				    dataType:'JSON',
				    type: "POST",
				    data: {'id':'{{$property->id}}'},
				    success: function(data){
				    	if(data['count'] > 0){
				    		var confirmText = 'This property have pending payment for:\n\n';
					    	for(var i in data){
					    		if(i != 'count'){
					    			confirmText = confirmText + month[data[i]['month']]+' '+data[i]['year']+'\n';
					    		}
					    	}

					    	confirmText = confirmText + '\n Delete anyway?';
					    	if(confirm(confirmText)){
								rentProceed = true;
								$('#rentalStatus').submit();
							}
				    	}else{
				    		rentProceed = true;
							$('#rentalStatus').submit();
				    	}
					    	
				    },
				    error: function(xhr) {
		  				alert(xhr.responseText);
					}
				});
			}	
		});

		$('.renter-delete').click(function(e){
			e.preventDefault();

			@if($pendingPayment && !empty($pendingPayment->toArray()))

			var confirmText = 'This renter has pending payment for:\n\n';

			@foreach($pendingPayment as $payment)
				confirmText = confirmText + month[{{$payment->month}}] + ' ' + {{ $payment->year }} + '\n';
			@endforeach

			confirmText = confirmText + '\nDelete anyway?'

			if(confirm(confirmText)){
				$(this).parent().parent().find('.deleteForm').submit();
			}
			@else
			if(confirm("Are you sure you want to delete this entry?")){
				$(this).parent().parent().find('.deleteForm').submit();
			}
			@endif

			
		});
		
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

		@if($property->loc_lat && $property->loc_long)
		new Maplace({
	    	map_options: {
				scrollwheel: false
			},
		    locations: [{
		        lat: {{$property->loc_lat}},
		        lon: {{$property->loc_long}},
		        zoom: 15,
		        title: '{{$property->name}}',
		        animation: google.maps.Animation.DROP
		    }]
		}).Load();
		@endif

	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection