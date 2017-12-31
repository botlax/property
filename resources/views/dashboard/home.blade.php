@extends('dashboard')

@section('title')
Dashboard | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('dbClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		home
	@endslot
	@slot('headerTitle')
		Dashboard
	@endslot
	@slot('content')
		<div class="chart-full" id="chart-full">
			<canvas id="rentalChart" style="width: 700px; height: 250px;"></canvas>
			<h4 style="margin-top: 50px">Total Expenses of {{date('Y')}}</h4>
			<ul>
				<li>Maintenance Expenses: QAR {{ array_sum($logExpense) }}</li>
				<li>Other Expenses: QAR {{ array_sum($otherExpense) }}</li>
				<li style="font-size: 1.2em;"><b>Total: QAR {{ array_sum($logExpense)+array_sum($otherExpense) }}</b></li>
			</ul>
		</div>
	@endslot
@endcomponent

@endsection

@section('script')

	$(document).ready(function(){

	});

        var barChartData = {
            labels: [
                @foreach($ms as $m)
                    "{{$m}}",
                @endforeach
            ],
            datasets: [{
                label: 'Maintenance Expenses',
                backgroundColor: "#F8D7DA",
                data: [
                    @foreach($logExpense as $expense)
                    	{{$expense}},
                    @endforeach
                ]
            }, {
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
