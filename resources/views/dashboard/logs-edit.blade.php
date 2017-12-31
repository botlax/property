@extends('dashboard')

@section('title')
Edit Log | {{config('app.name')}}
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
		wrench
	@endslot
	@slot('headerTitle')
		Edit Log
	@endslot
	@slot('content')
		{!! Form::model($log,['route'=>['log-update', $log->id]]) !!}
			<div class="form-group">
			    {!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control', 'placeholder' => 'Enter Description']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('complainer','Complainer') !!}
			    {!! Form::text('complainer',old('complainer'),['class' => 'form-control', 'placeholder' => 'Enter Complainer name']) !!}
			    @if ($errors->has('complainer'))
	                <div class="invalid-feedback">{{ $errors->first('complainer') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('mobile','Mobile') !!}
			    {!! Form::text('mobile',old('mobile'),['class' => 'form-control', 'placeholder' => 'Enter Complainer Mobile']) !!}
			    @if ($errors->has('mobile'))
	                <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
	            @endif
			</div>

			<div class="form-group">
	            {!! Form::label('log_date','Date') !!}
	            {!! Form::text('log_date',old('time'),['class' => 'time-input form-control']) !!}
	            @if ($errors->has('log_date'))
	                <div class="invalid-feedback">{{ $errors->first('log_date') }}</div>
	            @endif
            </div>

			@if($log->status == 'close')
			<div class="form-group">
			    {!! Form::label('close_date','Close Date') !!}
	            {!! Form::text('close_date',old('time'),['class' => 'time-input form-control']) !!}
	            @if ($errors->has('close_date'))
	                <div class="invalid-feedback">{{ $errors->first('close_date') }}</div>
	            @endif
			</div>
			@endif

			@if($log->status == 'close')
			<div class="form-group">
			    {!! Form::label('cost','Cost') !!}
			    {!! Form::text('cost',old('cost'),['class' => 'form-control']) !!}
			    @if ($errors->has('cost'))
	                <div class="invalid-feedback">{{ $errors->first('cost') }}</div>
	            @endif
			</div>
			@endif

			<button class="btn btn-primary">Update</button>
		{!! Form::close() !!}
		
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
	
		$('#log_date').datepicker();
		$('#log_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#log_date').attr('value') != undefined){
			$('#log_date').val($('#log_date').attr('value').replace(' 00:00:00','{{$log->log_date->format('H:i:s')}}'));
		}

		$('#close_date').datepicker();
		$('#close_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#close_date').attr('value') != undefined){
			$('#close_date').val($('#close_date').attr('value').replace(' 00:00:00','{{$log->log_date->format('H:i:s')}}'));
		}
	});
@endsection