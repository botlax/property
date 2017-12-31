@extends('dashboard')

@section('title')
Add log | {{config('app.name')}}
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
		Add log
	@endslot
	@slot('content')
		{!! Form::open(['route'=>['log-store', $property->id]]) !!}
			<div class="form-group">
			    {!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control', 'placeholder' => 'Enter Description']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>

			<div class="form-group">
	            {!! Form::label('log_date','Date') !!}
	            {!! Form::text('log_date',old('time'),['class' => 'time-input form-control']) !!}
	            @if ($errors->has('log_date'))
	                <div class="invalid-feedback">{{ $errors->first('log_date') }}</div>
	            @endif
            </div>

			<div class="form-group">
			    {!! Form::label('complainer','Complainer') !!}
			    {!! Form::text('complainer',old('complainer'),['class' => 'form-control', 'placeholder' => 'Enter Complainer Name']) !!}
			    @if ($errors->has('complainer'))
	                <div class="invalid-feedback">{{ $errors->first('complainer') }}</div>
	            @endif
			</div>

			<div class="form-group">
			    {!! Form::label('mobile','Mobile') !!}
			    {!! Form::text('mobile',old('mobile'),['class' => 'form-control', 'placeholder' => 'Enter complainer mobile']) !!}
			    @if ($errors->has('mobile'))
	                <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
	            @endif
			</div>

			<button class="btn btn-primary">Add</button>
		{!! Form::close() !!}
		
	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){
	
		$('#log_date').datepicker();
		$('#log_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#log_date').attr('value') != undefined){
			$('#log_date').val($('#log_date').attr('value').replace(' 00:00:00',''));
		}

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
	});
@endsection