@extends('dashboard')

@section('title')
Maintenance Invoice | {{config('app.name')}}
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
		file
	@endslot
	@slot('headerTitle')
		Maintenance Invoice
	@endslot
	@slot('content')
		<div id="tools">
		@if($log->status == 'open')
			<p class="back-link"><a href="{{url('maintenance').'/'.$property->id}}"><i class="fa fa-arrow-left"> Maintenance Logs</i></a></p>
		@else
			<p class="back-link"><a href="{{url('maintenance-closed').'/'.$property->id}}"><i class="fa fa-arrow-left"> Maintenance Logs</i></a></p>
		@endif
			<p class="search-form"><a href="#" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Invoice</a></p>

		</div>
		<div class="addForm">
		{!! Form::open(['route' => ['invoice-store', $log->id], 'files' => true]) !!}
			<div class="form-group">
				{!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('invoice','Invoice') !!}
				{!! Form::file('invoice',['class' => 'form-control-file', 'id' => 'invoice']) !!}
				@if ($errors->has('invoice'))
	                <div class="invalid-feedback">{{ $errors->first('invoice') }}</div>
	            @endif
			 </div>
			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
		<button class="btn btn-danger btn-close">Cancel</button>
		</div>

		<div class="header">
			<h4>Invoice List</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		@if(!empty($invoices->toArray()))
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Description</th>
						<th>Invoice</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($invoices as $invoice)

				<tr>
					<td>{{$x}}</td>
					<td>{{ $invoice->desc }}</td>
					<td><a href="{{ $invoice->invoice }}" target="_blank"><i class="fa fa-download"></i> Download</a></td>
					<td>
						{!! Form::open(['route' => ['invoice-delete', $invoice->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						<button class="btn btn-success btn-edit" title="edit"><i class="fa fa-wrench"></i></button>
					</td>
					<td colspan="6" class="form-wrap">
					{!! Form::model($invoice, ['route' => ['invoice-update', $invoice->id],'class' => 'editForm', 'files' => true]) !!}
						<div class="form-group">
							{!! Form::label('desc','Description') !!}
						    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
						    @if ($errors->has('desc'))
				                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
				            @endif
						</div>
						<div class="form-group">
							{!! Form::label('invoice','Invoice') !!}
							{!! Form::file('invoice',['class' => 'form-control-file', 'id' => 'invoice']) !!}
							@if ($errors->has('invoice'))
				                <div class="invalid-feedback">{{ $errors->first('invoice') }}</div>
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
			<p>No Invoices yet.</p>
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
			return false;
		});

		$('.btn-batch').click(function(){
			$(this).parent().parent().find('.batchForm').show();
			$(this).parent().parent().find('.addForm').hide();
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