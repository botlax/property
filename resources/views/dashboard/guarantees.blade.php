@extends('dashboard')

@section('title')
Guarantees | {{config('app.name')}}
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
		Guarantees
	@endslot
	@slot('content')
		<div id="tools">
			<p class="back-link"><a href="{{url('properties').'/'.$property->id}}"><i class="fa fa-arrow-left"> {{$property->name}}</i></a></p>
			<p class="search-form"><a href="#" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Guarantee</a></p>
		</div>

		<div class="addForm">
		{!! Form::open(['route' => ['guarantee-store', $property->id], 'files' => true]) !!}
			<div class="form-group">
				{!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('from','From') !!}
			    {!! Form::text('from',old('from'),['class' => 'form-control', 'id' => 'from']) !!}
			    @if ($errors->has('from'))
	                <div class="invalid-feedback">{{ $errors->first('from') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('to','To') !!}
			    {!! Form::text('to',old('to'),['class' => 'form-control', 'id' => 'to']) !!}
			    @if ($errors->has('to'))
	                <div class="invalid-feedback">{{ $errors->first('to') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('file','File') !!}
				{!! Form::file('file',['class' => 'form-control-file', 'id' => 'file']) !!}
				@if ($errors->has('file'))
	                <div class="invalid-feedback">{{ $errors->first('file') }}</div>
	            @endif
			 </div>
			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
		<button class="btn btn-danger btn-close">Cancel</button>
		</div>

		

		<div class="header">
			<h4>Guarantees</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		@if(!empty($guarantees->toArray()))
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Desc</th>
						<th>From</th>
						<th>To</th>
						<th>File</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($guarantees as $guarantee)

				<tr>
					<td>{{$x}}</td>
					<td>{{ $guarantee->desc }}</td>
					<td>{{ $guarantee->from->format('F d, Y') }}</td>
					<td>{{ $guarantee->to->format('F d, Y') }}</td>
					<td>
						@if($guarantee->file)
							<a href="{{ $guarantee->file }}" target="_blank"><i class="fa fa-download"></i> Download</a>
						@else
							--
						@endif
					</td>
					<td>
						{!! Form::open(['route' => ['guarantee-delete', $guarantee->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						<button class="btn btn-success btn-edit" title="edit"><i class="fa fa-wrench"></i></button>
					</td>
					<td colspan="6" class="form-wrap">
						{!! Form::model($guarantee,['route' => ['guarantee-update', $guarantee->id], 'files' => true]) !!}
							<div class="form-group">
								{!! Form::label('desc','Description') !!}
							    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
							    @if ($errors->has('desc'))
					                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
					            @endif
							</div>
							<div class="form-group">
								{!! Form::label('from','From') !!}
							    {!! Form::text('from',old('from'),['class' => 'form-control', 'id' => 'from-'.$guarantee->id]) !!}
							    @if ($errors->has('from'))
					                <div class="invalid-feedback">{{ $errors->first('from') }}</div>
					            @endif
							</div>
							<div class="form-group">
								{!! Form::label('to','To') !!}
							    {!! Form::text('to',old('to'),['class' => 'form-control', 'id' => 'to-'.$guarantee->id]) !!}
							    @if ($errors->has('to'))
					                <div class="invalid-feedback">{{ $errors->first('to') }}</div>
					            @endif
							</div>
							<div class="form-group">
								{!! Form::label('file','File') !!}
								{!! Form::file('file',['class' => 'form-control-file', 'id' => 'file']) !!}
								@if ($errors->has('file'))
					                <div class="invalid-feedback">{{ $errors->first('file') }}</div>
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
			<p>No Guarantees yet.</p>
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

		$('.btn-edit').click(function(){
			$(this).parent().parent().children().hide();
			$(this).parent().parent().find('.form-wrap').show();
		});

		$('input[id^=from]').each(function(){
			$(this).datepicker();
			$(this).datepicker("option", "dateFormat", "yy-mm-dd");
			if($(this).attr('value') != undefined){
				$(this).val($(this).attr('value').replace(' 00:00:00',''));
			}
		});

		$('input[id^=to]').each(function(){
			$(this).datepicker();
			$(this).datepicker("option", "dateFormat", "yy-mm-dd");
			if($(this).attr('value') != undefined){
				$(this).val($(this).attr('value').replace(' 00:00:00',''));
			}
		});			
	});
@endsection