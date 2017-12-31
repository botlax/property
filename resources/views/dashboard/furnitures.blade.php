@extends('dashboard')

@section('title')
Assets | {{config('app.name')}}
@endsection

@section('header')

@include('dashboard.partials.header')

@endsection

@section('content')

@component('dashboard.partials.nav-panel')
	@slot('furnClass')
		active
	@endslot
@endcomponent


@component('dashboard.partials.content')
	@slot('headerFA')
		dropbox
	@endslot
	@slot('headerTitle')
		Assets
	@endslot
	@slot('content')
		<ul class="table" id="furnitures">
		<?php $x=1; ?>
		@foreach($furnitures as $furn)
			<li id="furn-{{$furn->id}}">
				<span class="field-title">{{ $x }}</span>
				<p>{{$furn->name}}</p>
				<div class="field-form-wrap" style="display: none">
					{!! Form::model($furn,['id' => 'furn-update-'.$furn->id]) !!}
						{!! Form::hidden('id',$furn->id,['id' => 'id']) !!}
						<div class="form-group">
							{!! Form::text('name',old('name'),['class' => 'form-control', 'id' => 'name']) !!}
						</div>
						<button class="btn btn-success" title="edit"><i class="fa fa-check"></i></button>
					{!! Form::close() !!}
					<button class="btn btn-danger cancel-btn" title="cancel" data-id="{{ $furn->id }}">cancel</button>
				</div>
				<div class="field-tool">
					<button class="btn btn-success update-btn" title="edit" data-id="{{ $furn->id }}"><i class="fa fa-wrench"></i></button>
					{!! Form::open(['id' => 'furn-del-'.$furn->id]) !!}
						{!! Form::hidden('id',$furn->id,['id' => 'id']) !!}
						<button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button>
					{!! Form::close() !!}
				</div>
			</li>
			<?php $x++; ?>
		@endforeach
		
		</ul>

		<hr>

		{!! Form::open(['id' => 'furn-add']) !!}
			<div class="form-group">			
				{!! Form::label('name','Name') !!}
				{!! Form::text('name',old('name'),['class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::submit('Add Asset',['class' => 'btn btn-primary']) !!}
			</div>
		{!! Form::close() !!}


	@endslot
@endcomponent

@endsection


@section('script')
	$(document).ready(function(){
		function dump(obj) {
		    var out = '';
		    for (var i in obj) {
		        out += i + ": " + obj[i] + "\n";
		    }

		    alert(out);

		    // or, if you wanted to avoid alerts...

		    var pre = document.createElement('pre');
		    pre.innerHTML = out;
		    document.body.appendChild(pre)
		}

		$.ajaxSetup({
	    	headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	  	});


		$(document).on('submit','#furn-add',function(e){

			e.preventDefault();
			$.ajax({
			    url: '{{url('furnitures/add')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {'name':$('#furn-add #name').val()},
			    success: function(data){
			    	$('#furn-add #name').removeClass('is-invalid');
			    	$('#furn-add #name').parent().find('.invalid-feedback').remove();
			    	$('#furn-add #name').parent().find('.valid-feedback').remove();
			    	$('#furn-add #name').after('<div class="valid-feedback">'+data['message']+'</div>');
			    	$('#furn-add #name').parent().find('.valid-feedback').show();
			    	$('#furnitures').append('<li id="furn-'+data['id']+'"><span class="field-title"></span><p>'+$('#furn-add #name').val()+'</p><div class="field-form-wrap" style="display: none"><form method="POST" action="{{url('furnitures')}}" accept-charset="UTF-8" id="furn-update-'+data['id']+'" style="position: relative;"><input name="_token" type="hidden" value="{!! csrf_token() !!}"><input id="id" name="id" type="hidden" value="'+data['id']+'"><div class="form-group"><input class="form-control" name="name" type="text" id="name"></div><button class="btn btn-success" title="edit"><i class="fa fa-check"></i></button></form><button class="btn btn-danger cancel-btn" title="cancel" data-id="'+data['id']+'">cancel</button></div><div class="field-tool"><button class="btn btn-success update-btn" title="edit" data-id="'+data['id']+'"><i class="fa fa-wrench"></i></button><form method="POST" action="{{url('furnitures')}}" accept-charset="UTF-8" id="furn-del-'+data['id']+'" style="position: relative;"><input name="_token" type="hidden" value="{!! csrf_token() !!}"><input id="id" name="id" type="hidden" value="'+data['id']+'"><button class="btn btn-danger" title="delete"><i class="fa fa-close"></i></button></form></div></li>');
			    	$('#furn-add #name').val('');

			    	var num = 1;
			    	$('.field-title').each(function(){
			    		$(this).html(num);
			    		num = num + 1;
			    	});
			    },
			    error: function(xhr) {
			    	if( xhr.status === 422 ) {
			    		$('#furn-add #name').parent().find('.invalid-feedback').remove();
			    		$('#furn-add #name').parent().find('.valid-feedback').remove();
			    		$('#furn-add #name').addClass('is-invalid');
			    		$('#furn-add #name').after('<div class="invalid-feedback">'+xhr.responseJSON.errors.name+'</div>')
			    	}
			    	else{
			    		var err = eval("(" + xhr.responseText + ")");
  						alert(err.message);
			    	}
				}
			});
		});

		$(document).on('submit','form[id^=furn-del]',function(e){
			e.preventDefault();
			var id = $(this).find('#id').val();
			if(confirm("Are you sure you want to delete this entry?")){
	  			$.ajax({
				    url: '{{url('furnitures/delete')}}',
				    dataType:'JSON',
				    type: "POST",
				    data: {'id':id},
				    success: function(data){
				    	$('#furn-del-' + id).parent().parent().remove();
				    	alert(data.message);

				    	var num = 1;
				    	$('.field-title').each(function(){
				    		$(this).html('');
				    		$(this).html(num);
				    		num = num + 1;
				    	});
				    },
				    error: function(xhr) {
				    	if( xhr.status === 422 ) {
					    	alert(xhr.responseJSON.error);
				    	}
				    	else{
				    		var err = eval("(" + xhr.responseText + ")");
	  						alert(err.message);
				    	}
					}
				});
	  		}
		});

		$(document).on('click','.update-btn',function(){
			var id = $(this).data('id');
			var furn = $('#furn-'+id+' p').text();
			$('li#furn-'+id).children().hide();
			$('li#furn-'+id+' div[class$=form-wrap]').show();
			$('#furn-update-'+id+' #name').val(furn);
		});

		$(document).on('click','.cancel-btn',function(){
			var id = $(this).data('id');
			$('li#furn-'+id).children().show();
			$('li#furn-'+id+' div[class$=form-wrap]').hide();
			$('#furn-update-'+id+' #name').val('');
		});

		$(document).on('submit','form[id^=furn-update]',function(e){
			e.preventDefault();
			var id = $(this).find('#id').val();
			var name = $(this).find('#name').val();
  			$.ajax({
			    url: '{{url('furnitures/update')}}',
			    dataType:'JSON',
			    type: "POST",
			    data: {'id':id,'name':name},
			    success: function(data){
			    	$('#furn-update-'+id+ ' #name').removeClass('is-invalid');
			    	$('#furn-update-'+id+ ' #name').parent().find('.invalid-feedback').remove();
					$('li#furn-'+data['id']).children().show();
					$('li#furn-'+data['id']+' div[class$=form-wrap]').hide();
					$('#furn-update-'+data['id']+' #name').val('');
					$('#furn-'+data['id']+' p').html(data['name']);
			    },
			    error: function(xhr) {
			    	if( xhr.status === 422 ) {
			    		alert(1);
			   			$('#furn-update-'+id+ ' #name').parent().find('.invalid-feedback').remove();
			    		$('#furn-update-'+id+ ' #name').addClass('is-invalid');
			    		$('#furn-update-'+id+ ' #name').after('<div class="invalid-feedback">'+xhr.responseJSON.errors.name+'</div>')
			    	}
			    	else{
			    		var err = eval("(" + xhr.responseText + ")");
  						alert(err.message);
			    	}
				}
			});
	  		
		});

	});
@endsection

@section('meta')
<meta name="_token" content="{!! csrf_token() !!}"/>
@endsection