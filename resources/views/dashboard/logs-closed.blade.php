@extends('dashboard')

@section('title')
Maintenance Logs (Closed) | {{config('app.name')}}
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
		Maintenance Logs(closed)
	@endslot
	@slot('content')
		<div id="tools">
			<p class="back-link"><a href="{{url('properties').'/'.$property->id}}"><i class="fa fa-arrow-left"> {{$property->name}}</i></a></p>
			<div class="search-form">
				{!! Form::open(['method' => 'GET', 'route' => ['log-search', $property->id],'class' => 'form-inline']) !!}
					<div class="form-group">
						{!! Form::label('from', 'Search') !!}
					    {!! Form::text('from',old('from'),['class' => 'form-control', 'id' => 'from',  'placeholder'=>'From']) !!}
					    @if ($errors->has('from'))
			                <div class="invalid-feedback">{{ $errors->first('from') }}</div>
			            @endif
					</div>
					<div class="form-group">
					    {!! Form::text('to',old('to'),['class' => 'form-control', 'id' => 'to',  'placeholder'=>'To']) !!}
					    @if ($errors->has('to'))
			                <div class="invalid-feedback">{{ $errors->first('to') }}</div>
			            @endif
					</div>
					<button class="btn btn-primary"><i class="fa fa-search"></i></button>
				{!! Form::close() !!}
			</div>
			<div class="main-tools">
				<a href="{{url('maintenance').'/'.$property->id}}" class="btn btn-primary"><i class="fa fa-bars"> Ongoing Complaints</i></a>
				<a href="{{url('maintenance').'/'.$property->id}}" class="btn btn-primary"><i class="fa fa-bars"></i> Open Complaints</a>
				<a href="{{url('maintenance').'/'.$property->id.'/add'}}" class="btn btn-success"><i class="fa fa-plus"></i> Add Complaint</a>
				
			</div>
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
			<h4>Maintenance List (closed)</h4>
			<div class="header-tools">
				<button class="btn btn-primary" onclick="printDiv('log-list')"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
		<p>Total Expenses: QAR {{ $logs->sum('cost') }}</p>

		<div id="log-list">
		@if($logs->toArray()['total'] != 0)
			<table>
				<thead>
					<tr>
						<th>SN</th>
						<th>Open Date</th>
						<th>Close Date</th>
						<th>Description</th>
						<th>Complainer</th>
						<th>Mobile</th>
						<th>Cost</th>
						<th>Progress</th>
						<th>Invoice</th>
						<th>Tools</th>
					</tr>
				</thead>
			<?php $x = 1; ?>
			@foreach($logs as $log)
				<tr>
					<td>{{ $x }}</td>
					<td>{{$log->log_date->format('F d, Y (h:i a)')}}</td>
					<td>{{$log->close_date->format('F d, Y (h:i a)')}}</td>
					<td>{{$log->desc}}</td>
					<td>{{$log->complainer?$log->complainer:'--'}}</td>
					<td>{{$log->mobile?$log->mobile:'--'}}</td>
					<td>{{$log->cost?'QAR':''}} {{$log->cost?$log->cost:'--'}}</td>
					<td><a href="{{ url('maintenance').'/'.$log->id.'/progress' }}">Progress</a></td>
					<td><a href="{{ url('maintenance').'/'.$log->id.'/invoice' }}">Invoice</a></td>
					<td>
						<div class="field-form-wrap">
							{!! Form::open(['route' => ['log-delete', $log->id],'class' => 'deleteForm']) !!}
							{!! Form::close() !!}
						</div>
						
						<div class="field-tool">
							<a href="{{url('maintenance').'/'.$log->id.'/update'}}" class="btn btn-success btn-edit" title="delete"><i class="fa fa-wrench"></i></a>
							<button class="btn btn-danger btn-delete" title="delete"><i class="fa fa-close"></i></button>
							{!! Form::open(['route' => ['log-open', $log->id]]) !!}
								<button class="btn btn-primary btn-open" title="open?">Open</button>
							{!! Form::close() !!}
						</div>
					</td>
				</tr>
				<?php $x++; ?>
			@endforeach
			</table>
		@else
			<p>No Logs.</p>
		@endif
		</div>
		{{ $logs->links() }}
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

		$('.field-form-wrap').hide();
	
		$('#from').datepicker();
		$('#from').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#from').attr('value') != undefined){
			$('#from').val($('#from').attr('value').replace(' 00:00:00',''));
		}

		$('#to').datepicker();
		$('#to').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#to').attr('value') != undefined){
			$('#to').val($('#to').attr('value').replace(' 00:00:00',''));
		}

		$('#close_date').datepicker();
		$('#close_date').datepicker("option", "dateFormat", "yy-mm-dd");
		if($('#close_date').attr('value') != undefined){
			$('#close_date').val($('#close_date').attr('value').replace(' 00:00:00',''));
		}

		$('.btn-delete').click(function(e){
			e.preventDefault();
			if(confirm("Are you sure you want to delete this entry?")){
				$(this).parent().parent().find('.deleteForm').submit();
			}
		});

		$('.btn-open').click(function(e){
			e.preventDefault();
			if(confirm("Closing date and cost will be deleted. Open anyway?")){
				$(this).parent().submit();
			}
		});

		$('.btn-cancel').click(function(e){
			e.preventDefault();
			$(this).parent().hide();
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
                    @foreach($logExpense as $expense)
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