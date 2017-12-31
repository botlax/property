@extends('dashboard')

@section('title')
Payment History | {{config('app.name')}}
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
		money
	@endslot
	@slot('headerTitle')
		Payment History
	@endslot
	@slot('content')
		<div id="tools">

			<p class="back-link"><a href="{{url('properties').'/'.$property->id}}"><i class="fa fa-arrow-left"> {{$property->name}}</i></a></p>

			<div class="search-form">
				{!! Form::open(['method' => 'GET', 'route' => ['pay-search', $property->id],'class' => 'form-inline']) !!}
					From:
					<div class="form-group">
					    {!! Form::select('month_from', $month,old('month_from'),['class' => 'form-control', 'id' => 'month_from',  'placeholder'=>'-- Select Month --']) !!}
					    @if ($errors->has('month_from'))
			                <div class="invalid-feedback">{{ $errors->first('month_from') }}</div>
			            @endif
					</div>
					<div class="form-group">
					    {!! Form::select('year_from', $year,old('year_from'),['class' => 'form-control', 'id' => 'year_from',  'placeholder'=>'-- Select Year --']) !!}
					    @if ($errors->has('year_from'))
			                <div class="invalid-feedback">{{ $errors->first('year_from') }}</div>
			            @endif
					</div>

					To:
					<div class="form-group">
					    {!! Form::select('month_to', $month,old('month_to'),['class' => 'form-control', 'id' => 'month_to',  'placeholder'=>'-- Select Month --']) !!}
					    @if ($errors->has('month_to'))
			                <div class="invalid-feedback">{{ $errors->first('month_to') }}</div>
			            @endif
					</div>
					<div class="form-group">
					    {!! Form::select('year_to', $year,old('year_to'),['class' => 'form-control', 'id' => 'year_to',  'placeholder'=>'-- Select Year --']) !!}
					    @if ($errors->has('year_to'))
			                <div class="invalid-feedback">{{ $errors->first('year_to') }}</div>
			            @endif
					</div>
					<button class="btn btn-primary"><i class="fa fa-search"></i></button>
				{!! Form::close() !!}
			</div>

			<div class="main-tools">
				<a href="{{url('payments').'/'.$property->id}}" class="btn btn-primary"><i class="fa fa-bars"> All Payments</i></a>
				<a href="#" class="btn btn-success btn-add"><i class="fa fa-plus"></i> Add Payment</a>
				<a href="#" class="btn btn-success btn-batch"><i class="fa fa-plus"></i> Add Bulk Payment</a>
			</div>

		</div>

		<div class="addForm">
		{!! Form::open(['route' => ['pay-store', $property->id],'files' => true]) !!}
			<div class="form-group">
				{!! Form::label('amount','Amount') !!}
			    {!! Form::text('amount',$property->fee,['class' => 'form-control']) !!}
			    @if ($errors->has('amount'))
	                <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('paydate','Date') !!}
			    {!! Form::text('paydate',old('paydate'),['class' => 'form-control', 'id' => 'paydate']) !!}
			    @if ($errors->has('paydate'))
	                <div class="invalid-feedback">{{ $errors->first('paydate') }}</div>
	            @endif
			</div>
			For:
			<div class="form-group">
			    {!! Form::select('month', $month,old('month'),['class' => 'form-control',  'placeholder'=>'-- Select Month --']) !!}
			    @if ($errors->has('month'))
	                <div class="invalid-feedback">{{ $errors->first('month') }}</div>
	            @endif
			</div>
			<div class="form-group">
			    {!! Form::select('year', $year,old('year'),['class' => 'form-control',  'placeholder'=>'-- Select Year --']) !!}
			    @if ($errors->has('year'))
	                <div class="invalid-feedback">{{ $errors->first('year') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('cheque','Cheque') !!}
			    {!! Form::file('cheque',old('cheque'),['class' => 'form-control-file']) !!}
			    @if ($errors->has('cheque'))
	                <div class="invalid-feedback">{{ $errors->first('cheque') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('renter_id','Renter') !!}
			    {!! Form::select('renter_id', $renters,$renter?$renter->id:'',['class' => 'form-control']) !!}
			    @if ($errors->has('renter_id'))
	                <div class="invalid-feedback">{{ $errors->first('renter_id') }}</div>
	            @endif
			</div>
			<div class="form-group">
				<label for="overwrite"><input type="checkbox" value="1" name="overwrite" checked> Overwrite payments inside date range</label>
			</div>
			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
		<button class="btn btn-danger btn-close">Cancel</button>
		</div>

		<div class="batchForm">
		{!! Form::open(['route' => ['pay-batch', $property->id]]) !!}
			<div class="form-group">
				{!! Form::label('amount','Amount') !!}
			    {!! Form::text('amount',$property->fee,['class' => 'form-control']) !!}
			    @if ($errors->has('amount'))
	                <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('paydate','Date') !!}
			    {!! Form::text('paydate',old('paydate'),['class' => 'form-control', 'id' => 'paydate-batch']) !!}
			    @if ($errors->has('paydate'))
	                <div class="invalid-feedback">{{ $errors->first('paydate') }}</div>
	            @endif
			</div>
			From:
			<div class="form-group">
			    {!! Form::select('month', $month,old('month'),['class' => 'form-control',  'placeholder'=>'-- Select Month --']) !!}
			    @if ($errors->has('month'))
	                <div class="invalid-feedback">{{ $errors->first('month') }}</div>
	            @endif
			</div>
			<div class="form-group">
			    {!! Form::select('year', $year,old('year'),['class' => 'form-control',  'placeholder'=>'-- Select Year --']) !!}
			    @if ($errors->has('year'))
	                <div class="invalid-feedback">{{ $errors->first('year') }}</div>
	            @endif
			</div>
			To:
			<div class="form-group">
			    {!! Form::select('month_to', $month,old('month_to'),['class' => 'form-control',  'placeholder'=>'-- Select Month --']) !!}
			    @if ($errors->has('month_to'))
	                <div class="invalid-feedback">{{ $errors->first('month_to') }}</div>
	            @endif
			</div>
			<div class="form-group">
			    {!! Form::select('year_to', $year,old('year_to'),['class' => 'form-control',  'placeholder'=>'-- Select Year --']) !!}
			    @if ($errors->has('year_to'))
	                <div class="invalid-feedback">{{ $errors->first('year_to') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('renter_id','Renter') !!}
			    {!! Form::select('renter_id', $renters,$renter?$renter->id:'',['class' => 'form-control']) !!}
			    @if ($errors->has('renter_id'))
	                <div class="invalid-feedback">{{ $errors->first('renter_id') }}</div>
	            @endif
			</div>
			<div class="form-group">
				<label for="overwrite"><input type="checkbox" value="1" name="overwrite" checked> Overwrite payments inside date range</label>
			</div>
			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
		<button class="btn btn-danger btn-close">Cancel</button>
		</div>

		<div class="header">
			<h4>Payment List</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		<p>Total Revenue: QAR {{$payments->sum('amount')}}</p>
		@if(!empty($payments->toArray()))
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Amount</th>
						<th>Cheque</th>
						<th>Date of Payment</th>
						<th>Payment for</th>
						<th>Renter</th>
						<th>Invoice</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($payments as $pay)

				<tr>
					<td>{{$x}}</td>
					<td>QAR {{ $pay->amount }}</td>
					<td>
						@if($pay->cheque)
						<a href="{{$pay->cheque}}" target="_blank">Download <i class="fa fa-download"></i></a>
						@else
						--
						@endif
					</td>
					<td>{{ $pay->paydate->format('F d, Y') }}</td>
					<td>{{ $month[$pay->month].' '.$pay->year }}</td>
					<td><a href="{{ url('renters').'/' }}{{ App\Renter::find($pay->renter_id)->id }}">{{ App\Renter::find($pay->renter_id)->name }}</a></td>
					<td>
						<a href="{{ url('invoice').'?id='.urlencode($pay->invoice) }}" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i> View</a>

						{!! Form::open(['route' => ['send-invoice',$pay->id]]) !!}
							<button class="btn btn-primary"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Send invoice to renter</button> 
						{!! Form::close() !!}
					</td>
					<td>
						{!! Form::open(['route' => ['pay-delete', $pay->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						<button class="btn btn-success btn-edit" title="edit"><i class="fa fa-wrench"></i></button>
					</td>
					<td colspan="7" class="form-wrap">
					{!! Form::model($pay, ['route' => ['pay-change', $pay->id],'class' => 'editForm','files' => true]) !!}
						<div class="form-group">
							{!! Form::label('amount','Amount') !!}
						    {!! Form::text('amount',old('amount'),['class' => 'form-control', 'id' => 'amount']) !!}
						    @if ($errors->has('amount'))
				                <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
				            @endif
						</div>
						<div class="form-group">
							{!! Form::label('paydate','Date') !!}
						    {!! Form::text('paydate',old('paydate'),['class' => 'form-control', 'id' => 'paydate-'.$pay->id]) !!}
						    @if ($errors->has('paydate'))
				                <div class="invalid-feedback">{{ $errors->first('paydate') }}</div>
				            @endif
						</div>
						For:
						<div class="form-group">
						    {!! Form::select('month', $month,old('month'),['class' => 'form-control', 'id' => 'month',  'placeholder'=>'-- Select Month --']) !!}
						    @if ($errors->has('month'))
				                <div class="invalid-feedback">{{ $errors->first('month') }}</div>
				            @endif
						</div>
						<div class="form-group">
						    {!! Form::select('year', $year,old('year'),['class' => 'form-control', 'id' => 'year',  'placeholder'=>'-- Select Year --']) !!}
						    @if ($errors->has('year'))
				                <div class="invalid-feedback">{{ $errors->first('year') }}</div>
				            @endif
						</div>
						<div class="form-group">
							{!! Form::label('cheque','Cheque') !!}
						    {!! Form::file('cheque',old('cheque'),['class' => 'form-control-file']) !!}
						    @if ($errors->has('cheque'))
				                <div class="invalid-feedback">{{ $errors->first('cheque') }}</div>
				            @endif
						</div>
						<div class="form-group">
							{!! Form::label('renter_id','Renter') !!}
						    {!! Form::select('renter_id', $renters,old('renter_id'),['class' => 'form-control', 'id' => 'renter']) !!}
						    @if ($errors->has('renter_id'))
				                <div class="invalid-feedback">{{ $errors->first('renter_id') }}</div>
				            @endif
						</div>
						<button class="btn btn-primary">Update</button>
					{!! Form::close() !!}
					<button class="btn btn-danger btn-cancel">Cancel</button>
					</td>
				</tr>
				<?php $x++; ?>
			@endforeach
			</table>
		@else
			<p>No Payments yet.</p>
		@endif

		<div class="header">
			<h4>Pending Payments</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		@if(!empty($pending->toArray()))
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Amount</th>
						<th>Payment for</th>
						<th>Renter</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($pending as $pay)

				<tr>
					<td>{{$x}}</td>
					<td>QAR {{ $pay->amount }}</td>
					<td>{{ $month[$pay->month].' '.$pay->year }}</td>
					<td>{{ App\Renter::find($pay->renter_id)->name }}</td>
					<td>
						{!! Form::open(['route' => ['pay-delete', $pay->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
						{!! Form::open(['route' => ['pay-update', $pay->id],'class' => 'payForm']) !!}
						{!! Form::close() !!}
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						<button class="btn btn-primary btn-pay" title="paid"><i class="fa fa-money"></i></button>
					</td>
				</tr>
				<?php $x++; ?>
			@endforeach
			</table>
		@else
			<p>No Pending Payment.</p>
		@endif

	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){

		$('.form-wrap,.batchForm,.addForm').hide();

		$('.btn-delete').click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to delete this entry?")){
				$(this).parent().find('.deleteForm').submit();
			}
		});

		$('.btn-pay').click(function(e){
			e.preventDefault();
			$(this).parent().find('.payForm').submit();
		});

		$('.btn-close').click(function(){
			$(this).parent().hide();
		});

		$('.btn-cancel').click(function(){
			$(this).parent().parent().children().show();
			$(this).parent().hide();
		});

		$('.btn-add').click(function(){
			$(this).parent().parent().parent().find('.addForm').show();
			$(this).parent().parent().parent().find('.batchForm').hide();
			return false;
		});

		$('.btn-batch').click(function(){
			$(this).parent().parent().parent().find('.batchForm').show();
			$(this).parent().parent().parent().find('.addForm').hide();
			return false;
		});

		$('.btn-edit').click(function(){
			$(this).parent().parent().children().hide();
			$(this).parent().parent().find('.form-wrap').show();
		});

		$('input[id^=paydate]').each(function(){
			$(this).datepicker();
			$(this).datepicker("option", "dateFormat", "yy-mm-dd");
			if($(this).attr('value') != undefined){
				$(this).val($(this).attr('value').replace(' 00:00:00',''));
			}
		});
			
	});
@endsection