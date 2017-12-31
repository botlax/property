<section id="content">
	<header>
		<h3><i class="fa fa-{{$headerFA or ''}}"></i>{{$headerTitle or ''}}</h3>
	</header>

	<section id="main-content">
		{{$content or ''}}
	</section>
</section>

{!! Form::open(['route' => 'logout','id' => 'logout-form', 'method' => 'POST', 'style' => 'display: none;']) !!}
{!! Form::close() !!}