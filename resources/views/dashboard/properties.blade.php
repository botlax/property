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


		<div class="header">
			<h4>For Rent</h4>
			<div class="header-tools">
				<button class="btn btn-primary" onclick="printDiv('for-rent-wrap')"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		<div id="for-rent-wrap" class="print-wrap">
		<?php $x = 1; ?>
		@if(!empty($for_rent->toArray()))
		<table>
			<thead>
				<tr>
					<th>SN</th>
					<th>Property</th>
					<th>Owner/s</th>
					<th>Occupant</th>
					<th>Pending Payment</th>
					<th class="ph">Tools</th>
				</tr>
			</thead>
		@foreach($for_rent as $prop)
			<tr>
				<td>{{ $x }}</td>
				<td><a href="{{ url('properties').'/'.$prop->id }}">{{$prop->name}}</a></td>
				<td>
					@if(!empty($prop->god()->get()->toArray()))
					<ul>
						@foreach($prop->god()->get() as $god)
						<li>
							<a href="{{url('users').'/'.$god->id}}">{{$god->name}}</a>
							{!! Form::open(['route' => ['prop-update',$prop->id],'class' => 'entry-form']) !!} 
								{!! Form::hidden('field', 'god') !!}
								{!! Form::hidden('process', 'delete') !!}
								{!! Form::hidden('god', $god->id) !!}
								<button class="btn btn-danger btn-user btn-delete"> <i class="fa fa-close"></i> </button> 
							{!! Form::close() !!}
						</li>
						@endforeach
					</ul>
					@else
					<a href="{{ url('properties').'/'.$prop->id }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add owner</a>
					@endif
				</td>
				<td>
					@if($prop->renter()->first())
						<a href="{{ url('renters').'/'.$prop->renter()->first()->id }}">{{$prop->renter()->first()->name}}</a>
					@else
						<a href="{{ url('properties').'/'.$prop->id }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add renter</a>
					@endif
				</td>
				<td>
				<?php 
					$pending = $prop->payment()->whereNull('paydate')->orderBy('year','ASC')->orderBy('month','ASC')->first();
					$latest = $prop->payment()->whereNotNull('paydate')->orderBy('year','DESC')->orderBy('month','DESC')->first();
				 ?>
				@if($pending && $prop->renter()->first())
					{{Carbon\Carbon::create($pending->year,$pending->month)->format('M Y')}}

					{!! Form::open(['route' => ['pay-update',$pending->id]]) !!}
						<button class="btn btn-primary"><i class="fa fa-money"></i>&nbsp;&nbsp;Paid</button> 
					{!! Form::close() !!}
				@else
					@if($latest)
					{{Carbon\Carbon::create($latest->year,$latest->month)->format('M Y')}} (Paid)
					{!! Form::open(['route' => ['send-invoice',$latest->id]]) !!}
						<button class="btn btn-primary"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Send invoice to renter</button> 
					{!! Form::close() !!}
					@endif
				@endif

				@if(!$prop->renter()->first())
				 	<a href="{{ url('properties').'/'.$prop->id }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add renter</a>
				@endif

				</td>
				<td class="ph">{!! Form::open(['route' => ['prop-delete',$prop->id]]) !!} <button class="btn btn-danger btn-delete"> <i class="fa fa-close"></i> </button> {!! Form::close() !!}</td>
			</tr>
			<?php $x++; ?>
		@endforeach
		</table>
		@else
		<p>List Empty</p>
		@endif
		</div>
		<hr>

		<div class="header">
			<h4>Owner Occupied</h4>
			<div class="header-tools">
				<button class="btn btn-primary" onclick="printDiv('owner-wrap')"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		<div id="owner-wrap" class="print-wrap">
		<?php $x = 1; ?>
		@if(!empty($owner_prop->toArray()))
		<table>
			<thead>
				<tr>
					<th>SN</th>
					<th>Property</th>
					<th>Owner/s</th>
					<th>Occupant</th>
					<th class="ph">Tools</th>
				</tr>
			</thead>
		@foreach($owner_prop as $prop)
			<tr>
				<td>{{ $x }}</td>
				<td><a href="{{ url('properties').'/'.$prop->id }}">{{$prop->name}}</a></td>
				<td>
					@if(!empty($prop->god()->get()->toArray()))
					<ul>
						@foreach($prop->god()->get() as $god)
						<li><a href="{{url('users').'/'.$god->id}}">{{$god->name}}</a>
							{!! Form::open(['route' => ['prop-update',$prop->id],'class' => 'entry-form']) !!} 
								{!! Form::hidden('field', 'god') !!}
								{!! Form::hidden('process', 'delete') !!}
								{!! Form::hidden('god', $god->id) !!}
								<button class="btn btn-danger btn-user btn-delete"> <i class="fa fa-close"></i> </button> 
							{!! Form::close() !!}
						</li>
						@endforeach
					</ul>
					@else
					<a href="{{ url('properties').'/'.$prop->id }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add owner</a>
					@endif
				</td>
				<td>
					@if($prop->owner()->first())
						<a href="{{ url('users').'/'.$prop->owner()->first()->id }}">{{$prop->owner()->first()->name}}</a>
					@else
						<a href="{{ url('properties').'/'.$prop->id }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add occupant</a>
					@endif
				</td>
				<td class="ph">{!! Form::open(['route' => ['prop-delete',$prop->id]]) !!} <button class="btn btn-danger btn-delete"> <i class="fa fa-close"></i> </button> {!! Form::close() !!}</td>
			</tr>
			<?php $x++; ?>
		@endforeach
		</table>
		@else
		<p>List Empty</p>
		@endif
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

		
		
		$('.btn-delete').click(function(e){
			e.preventDefault();
			if($(this).hasClass('btn-user')){
				if(confirm("Are you sure you want to delete this entry?")){
					$(this).parent().submit();
				}
			}
			else{
				if(confirm("Are you sure you want to delete this entry? All payment records, maintenance logs, guarantees and expenses will also be deleted.")){
					$(this).parent().submit();
				}
			}
		});

	});
@endsection