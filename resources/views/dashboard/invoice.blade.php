@extends('blank')

@section('title')
Invoice | {{config('app.name')}}
@endsection

@section('css')
	<style>
	body{
		background-color: #999;
	}

	#invoice-wrap{
		background-color: #fff;
		width: 900px;
		height: 1200px;
		margin: 0 auto;
		padding: 80px;
	}

	#tool-wrap{
		width: 900px;
		margin: 50px auto;
		text-align: right;
	}

	#company-info, #title{
		width: 50%;
		float: left;
	}

	#company-info p span{
		font-size: 1.2em;
		font-weight: bold;
	}

	#title{
		text-align: right;
	}
	table{
		width: 100%;
		margin-bottom: 70px;
	}
	table .invoice-body{
		height: 400px;
	}
	table th{
		border: 2px solid #000;
		text-align: center;
		padding: 5px 0;
		font-weight: bold;
	}
	table th:first-child{
		width: 70%;
	}
	table td{
		border: 1px solid #000;
		padding: 10px;
	}

	table .total{
		font-weight: bold;
		text-align: center;
	}

	footer p:first-child{
		margin-bottom: 50px;
		font-size: 0.9em;
	}

	footer p:last-child{
		font-weight: bold;
		text-align: center;
		font-size: 1.5em;
	}

	</style>
@endsection

@section('content')
	<div id="tool-wrap">
		<button class="btn btn-primary" onclick="printDiv('invoice-wrap')"><i class="fa fa-print"></i> Print</button>
		<button class="btn btn-primary" id="download"><i class="fa fa-download"></i> Download</button>
	</div>
	<section id="invoice-wrap">
		<header class="clearfix">

			<div id="company-info">
				<h1>Company Name</h1>
				
				<ul>
					<li>Location<br>Doha, Qatar</li>
					<li>P.O. Box 9551 </li>
					<li>Phone: 44455566</li>
					<li>Fax: 44455566</li>
				</ul>

				<p>Issued To: <span>{{ $renter->name }}</span></p>
			</div>

			<div id="title">
				<h2>INVOICE</h2>
				<ul>
					<li> Date: {{$invoice->paydate->format('d/m/Y')}} </li>
					<li> Invoice #: {{ $property->id }}S{{ $invoice->id }} </li>
				</ul>
			</div>

		</header>
		<div id="invoice-table">
			<table>
				<thead>
					<tr>
						<th>Description</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tr class="invoice-body">
					<td>{{ $property->name }} Rental Payment</td>
					<td>QAR {{$invoice->amount}}</td>
				</tr>
				<tr>
					<td class="total">TOTAL</td>
					<td class="total">QAR {{$invoice->amount}}</td>
				</tr>
			</table>
			
		</div>
		
		<footer>
			<p>Any additional notes goes here Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

			<p>Thank you for your business!</p>
		</footer>
	</section>
	<div id="editor"></div>

@endsection

@section('js')
	<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
	<script type="text/javascript">
		
		function printDiv(divName) {
		     var printContents = document.getElementById(divName).innerHTML;
		     var originalContents = document.body.innerHTML;

		     document.body.innerHTML = printContents;

		     window.print();

		     document.body.innerHTML = originalContents;
		}

		var specialElementHandlers = {
		    '#editor': function (element, renderer) {
		        return true;
		    }
		};

		$('#download').click(function () {
			var doc = new jsPDF();
		    doc.fromHTML($('#invoice-wrap').html(), 15, 15, {
		        'width': 170,
		            'elementHandlers': specialElementHandlers
		    });
		    doc.save('Invoice-{{ $property->id }}S{{ $invoice->id }}.pdf');
		});
		
	</script>
@endsection