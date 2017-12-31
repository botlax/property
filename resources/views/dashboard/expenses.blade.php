@extends('dashboard')

@section('title')
Expenses | {{config('app.name')}}
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
		Expenses
	@endslot
	@slot('content')
		<div id="tools">
			<p class="back-link"><a href="{{url('properties').'/'.$property->id}}"><i class="fa fa-arrow-left"> {{$property->name}}</i></a></p>
			<p class="search-form"><a href="#" class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Add Expense</a></p>
		</div>

		<div class="addForm">
		{!! Form::open(['route' => ['expense-store', $property->id], 'files' => true]) !!}
			<div class="form-group">
				{!! Form::label('desc','Description') !!}
			    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
			    @if ($errors->has('desc'))
	                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('cost','Cost') !!}
			    {!! Form::text('cost',old('cost'),['class' => 'form-control']) !!}
			    @if ($errors->has('cost'))
	                <div class="invalid-feedback">{{ $errors->first('cost') }}</div>
	            @endif
			</div>
			<div class="form-group">
				{!! Form::label('date','Date') !!}
			    {!! Form::text('date',old('date'),['class' => 'form-control', 'id' => 'date']) !!}
			    @if ($errors->has('date'))
	                <div class="invalid-feedback">{{ $errors->first('date') }}</div>
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
			<h4>Expenses Chart</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		<div class="chart-full">
			<canvas id="rentalChart" style="width: 700px; height: 250px;"></canvas>
		</div>
		

		<div class="header">
			<h4>Expenses</h4>
			<div class="header-tools">
				<button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		@if(!empty($expenses->toArray()))
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Desc</th>
						<th>Date</th>
						<th>Cost</th>
						<th>File</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($expenses as $expense)

				<tr>
					<td>{{$x}}</td>
					<td>{{ $expense->desc }}</td>
					<td>{{ $expense->date->format('F d, Y') }}</td>
					<td>QAR {{ $expense->cost }}</td>
					<td>
						@if($expense->file)
							<a href="{{ $expense->file }}" target="_blank"><i class="fa fa-download"></i> Download</a>
						@else
							--
						@endif
					</td>
					<td>
						{!! Form::open(['route' => ['expense-delete', $expense->id],'class' => 'deleteForm']) !!}
						{!! Form::close() !!}
						<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
						<button class="btn btn-success btn-edit" title="edit"><i class="fa fa-wrench"></i></button>
					</td>
					<td colspan="6" class="form-wrap">
						{!! Form::model($expense,['route' => ['expense-update', $expense->id], 'files' => true]) !!}
							<div class="form-group">
								{!! Form::label('desc','Description') !!}
							    {!! Form::textarea('desc',old('desc'),['class' => 'form-control']) !!}
							    @if ($errors->has('desc'))
					                <div class="invalid-feedback">{{ $errors->first('desc') }}</div>
					            @endif
							</div>
							<div class="form-group">
								{!! Form::label('cost','Cost') !!}
							    {!! Form::text('cost',old('cost'),['class' => 'form-control']) !!}
							    @if ($errors->has('cost'))
					                <div class="invalid-feedback">{{ $errors->first('cost') }}</div>
					            @endif
							</div>
							<div class="form-group">
								{!! Form::label('date','Date') !!}
							    {!! Form::text('date',old('date'),['class' => 'form-control', 'id' => 'date-'.$expense->id]) !!}
							    @if ($errors->has('date'))
					                <div class="invalid-feedback">{{ $errors->first('date') }}</div>
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
			<p>No Expenses yet.</p>
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

		$('input[id^=date]').each(function(){
			$(this).datepicker();
			$(this).datepicker("option", "dateFormat", "yy-mm-dd");
			if($(this).attr('value') != undefined){
				$(this).val($(this).attr('value').replace(' 00:00:00',''));
			}
		});	
	});

		var barChartData = {
            labels: [
            	@foreach($ms as $m)
                    "{{$m}}",
                @endforeach
            ],
            datasets: [{
                label: 'Other Expenses',
                backgroundColor: "#CCE5FF",
                data: [
                    @foreach($otherExpense as $expense)
                    	{{$expense}},
                    @endforeach
                ]
            }]

        };
        window.onload = function() {
            var ctx = document.getElementById("rentalChart").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    title:{
                        display:true,
                        text:"Expenses of {{ date('Y') }}"
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        };
@endsection