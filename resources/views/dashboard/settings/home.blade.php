@extends('dashboard')

@section('title')
App Settings | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		cog
	@endslot
	@slot('headerTitle')
		App Settings
	@endslot
	@slot('content')
        {!! Form::open(['route' => 'setting-update']) !!}
    		<div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="status" id="year" value="year" {{$setting->status == 'year'?'checked':''}}> By year
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="status" id="month" value="month" {{$setting->status == 'month'?'checked':''}}> By past number of months
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="status" id="custom" value="custom" {{$setting->status == 'custom'?'checked':''}}> Custom
                </label>
            </div>
            <fieldset class="form-group">
                <fieldset id="year-wrap" class="panel" style="{{$setting->status == 'year'?'':'display:none'}}">
                    <div class="form-group">
                        {!! Form::select('year', $year,$setting->to->format('Y'),['class' => 'form-control', 'id' => 'year',  'placeholder'=>'-- Select Year --']) !!}
                        @if ($errors->has('year'))
                            <div class="invalid-feedback">{{ $errors->first('year') }}</div>
                        @endif
                    </div>
                </fieldset>
                <fieldset id="month-wrap" class="form-inline panel" style="{{$setting->status == 'month'?'':'display:none'}}">
                    <div class="form-group">
                        {!! Form::label('month','Show data for the past ') !!}
                        &nbsp;{!! Form::number('month', $monthNum,['class' => 'form-control','min' => 1]) !!}&nbsp;
                        {!! Form::label('month',' months') !!}
                        @if ($errors->has('month'))
                            <div class="invalid-feedback">{{ $errors->first('month') }}</div>
                        @endif
                    </div>
                </fieldset>
                <fieldset id="custom-wrap" class="form-inline panel" style="{{$setting->status == 'custom'?'':'display:none'}}">
                    <div class="form-group">
                        {!! Form::label('month_from','From ') !!}&nbsp;
                        {!! Form::select('month_from', $month,$setting->from->format('m'),['class' => 'form-control', 'id' => 'month_from',  'placeholder'=>'-- Select Month --']) !!}
                        @if ($errors->has('month_from'))
                            <div class="invalid-feedback">{{ $errors->first('month_from') }}</div>
                        @endif
                        {!! Form::select('year_from', $year,$setting->from->format('Y'),['class' => 'form-control', 'id' => 'year_from',  'placeholder'=>'-- Select Year --']) !!}
                        @if ($errors->has('year_from'))
                            <div class="invalid-feedback">{{ $errors->first('year_from') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('month_from','To ') !!}&nbsp;
                        {!! Form::select('month_to', $month,$setting->to->format('m'),['class' => 'form-control', 'id' => 'month_to',  'placeholder'=>'-- Select Month --']) !!}
                        @if ($errors->has('month_to'))
                            <div class="invalid-feedback">{{ $errors->first('month_to') }}</div>
                        @endif
                        {!! Form::select('year_to', $year,$setting->to->format('Y'),['class' => 'form-control', 'id' => 'year_to',  'placeholder'=>'-- Select Year --']) !!}
                        @if ($errors->has('year_to'))
                            <div class="invalid-feedback">{{ $errors->first('year_to') }}</div>
                        @endif
                    </div>
                    
                </fieldset>
            </fieldset>
            <button class="btn btn-primary">Save</button>
        {!! Form::close() !!}
	@endslot
@endcomponent

@endsection

@section('script')
	$(document).ready(function(){

        $('input[type=radio]').click(function(){
            $('.panel').hide();
            $('fieldset#'+$(this).attr('id')+'-wrap').show();
        });

	});
@endsection
