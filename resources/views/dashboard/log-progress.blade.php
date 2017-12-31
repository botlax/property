@extends('dashboard')

@section('title')
Maintenance Progress | {{config('app.name')}}
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
		Maintenance Progress
	@endslot
	@slot('content')
		<div id="tools">
		@if($log->status == 'open')
			<p class="back-link"><a href="{{url('maintenance').'/'.$property->id}}"><i class="fa fa-arrow-left"> Maintenance Logs</i></a>
			<p class="search-form"><a href="#" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Progress</a></p>
		@else
			<p class="back-link"><a href="{{url('maintenance-closed').'/'.$property->id}}"><i class="fa fa-arrow-left"> Maintenance Logs</i></a>
		@endif

		</div>

		<div class="addForm">
		{!! Form::open(['route' => ['prog-store', $log->id]]) !!}
			<div class="form-group">
				{!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('log_date','Progress Date') !!}
				{!! Form::text('log_date',old('log_date'),['class' => 'form-control time-input', 'id' => 'log_date',  'placeholder'=>'Progress Date']) !!}
				@if ($errors->has('log_date'))
	                <div class="invalid-feedback">{{ $errors->first('log_date') }}</div>
	            @endif
			 </div>
			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
		<button class="btn btn-danger btn-close">Cancel</button>
		</div>

		<div class="header">
			<h4>Maintenance Progress</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		@if(!empty($progress->toArray()))
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Description</th>
						<th>Date</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($progress as $prog)

				<tr>
					<td>{{$x}}</td>
					<td>{{ $prog->desc }}</td>
					<td>{{ $prog->log_date->format('F d, Y (h:i a)') }}</td>
					<td>
						{!! Form::open(['route' => ['prog-delete', $prog->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						<button class="btn btn-success btn-edit" title="edit"><i class="fa fa-wrench"></i></button>
					</td>
					<td colspan="6" class="form-wrap">
					{!! Form::model($prog, ['route' => ['prog-update', $prog->id],'class' => 'editForm']) !!}
						<div class="form-group">
							{!! Form::label('desc','Description') !!}
						    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
						    @if ($errors->has('desc'))
				                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
				            @endif
						</div>
						<div class="form-group">
							{!! Form::label('log_date','Progress Date') !!}
							{!! Form::text('log_date',old('log_date'),['class' => 'form-control time-input', 'id' => 'log_date-'.$prog->id,  'placeholder'=>'Progress Date']) !!}
							@if ($errors->has('log_date'))
				                <div class="invalid-feedback">{{ $errors->first('log_date') }}</div>
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
			<p>No Progress yet.</p>
		@endif

	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){

		$('.time-input').inputmask("yyyy-mm-dd hh:mm:ss", {
            mask: "y-1-2 h:s:s",
            placeholder: "yyyy-mm-dd hh:mm:ss",
            alias: "datetime",
            separator: "-",
            leapday: "-02-29",
            regex: {
                val2pre: function(separator) {
                    var escapedSeparator = Inputmask.escapeRegex.call(this, separator);
                    return new RegExp("((0[13-9]|1[012])" + escapedSeparator + "[0-3])|(02" + escapedSeparator + "[0-2])");
                },
                val2: function(separator) {
                    var escapedSeparator = Inputmask.escapeRegex.call(this, separator);
                    return new RegExp("((0[1-9]|1[012])" + escapedSeparator + "(0[1-9]|[12][0-9]))|((0[13-9]|1[012])" + escapedSeparator + "30)|((0[13578]|1[02])" + escapedSeparator + "31)");
                },
                val1pre: new RegExp("[01]"),
                val1: new RegExp("0[1-9]|1[012]")
            },
            onKeyDown: function(e, buffer, caretPos, opts) {}
        });

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

		$('input[id^=paydate]').each(function(){
			$(this).datepicker();
			$(this).datepicker("option", "dateFormat", "yy-mm-dd");
			if($(this).attr('value') != undefined){
				$(this).val($(this).attr('value').replace(' 00:00:00',''));
			}
		});

		$('input[id^=log_date]').each(function(){
			$(this).datepicker();
			$(this).datepicker("option", "dateFormat", "yy-mm-dd");
			if($(this).attr('value') != undefined){
				$(this).val($(this).attr('value').replace(' 00:00:00',''));
			}
		});
			
			
	});
@endsection