
(function($) {

	skel.breakpoints({
		wide: '(max-width: 1680px)',
		normal: '(max-width: 1280px)',
		narrow: '(max-width: 980px)',
		narrower: '(max-width: 840px)',
		mobile: '(max-width: 736px)',
		small: '(max-width: 530px)'
	});

	$(document).ready(function(){
		$(window).on('beforeunload', function() {
		    $(window).scrollTop(0);
		});
	});

	$(function() {

		// Disable animations/transitions until the page has loaded.
			$('body').addClass('is-loading');

			skel.on("load", function() {
				$('body').removeClass('is-loading');
				
			});

		// CSS polyfills (IE<9).
			if (skel.vars.IEVersion < 9)
				$(':last-child').addClass('last-child');

		// Fix: Placeholder polyfill.
			$('form').placeholder();

	});

	$('nav#nav .with-dropdown > a').click(function(e){
		e.preventDefault();

		if(!$(this).hasClass('active')){
			$('nav#nav .with-dropdown a').removeClass('active');
			$('.dropdown').removeClass('show');
		}
		$(this).toggleClass('active');
		$(this).parent().find('.dropdown').toggleClass('show');

		$('nav#nav .with-dropdown > a').each(function(){
			if($(this).hasClass('active')){
				$('body').append('<div class="dropdown-overlay"></div>');
				$('header#header nav').append('<div class="dropdown-overlay"></div>');
			}
		});
		
	});

	$(document).on('click','.dropdown-overlay, #user-wrap',function(){
		$('nav#nav .with-dropdown a').removeClass('active');
		$('.dropdown').removeClass('show');
		$('.dropdown-overlay').remove();
	});

	$('#sub-nav .with-dropdown > a, #sub-nav-mobile .with-dropdown > a').click(function(e){
		e.preventDefault();
		$(this).parent().find('.dropdown').slideToggle(200);
	});

	$('#nav-button').click(function(e){
		e.preventDefault();
		$('nav#sub-nav').slideToggle(200);
	});

	$(window).resize(function(){
		skel.on("-small", function(){
			$('nav#sub-nav').attr('style', '');
		});
	});

	//---------FLASH
	if($('.flash-wrap').length){
		var n = $('.flash-wrap .flash').length * 300;
		$('.flash-wrap .flash').each(function(i){
			setTimeout(function(){
				$('.flash-wrap .flash').eq(i).addClass('show');
				if(!$('.flash-wrap .flash').eq(i).hasClass('flash-important')){
					setTimeout(function(){
						$('.flash-wrap .flash').eq(i).removeClass('show');
					},5000);
				}
			},300 * (i+1));
		});

		setTimeout(function(){
			$('.flash-wrap .flash').each(function(i){
				if(!$('.flash-wrap .flash').eq(i).hasClass('flash-important')){
					$('.flash-wrap .flash').eq(i).remove();
				}
			});
		},(n*2)+5000);

		$('.flash-wrap .flash .close').click(function(){
			var elem = $(this).parent();
			elem.removeClass('show');

			setTimeout(function(){
				elem.remove();
			},500);
		});
	}

	//-----------LeanModal
	$("div[id$=leanmodal]").leanModal({ overlay : 0.4, closeButton: ".modal_close" });
  	$("a[rel*=leanModal]").leanModal();

  	$("div[id$=leanmodal]").css({'margin-top':'-'+($("div[id$=leanmodal]").outerHeight() / 2)+'px'});

  	$(document).on('click','.modal_close, .options .cancel, #lean_overlay',function(){
        $("div[id$=leanmodal]").css({'display':'none'});
        $("#lean_overlay").css({'display':'none'});
        $('.reason, .cancel_date').html('');
        $('.cancel-button').remove();
  	});

  	//------------Upload form
  
		$(".inputfile").change(function(e)
		{	
			var $input	 = $( this ),
			$label	 = $input.prev( 'label' ),
			labelVal = $label.html();

			var fileName = '';

			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else if( e.target.value )
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				$label.html( fileName );
			else
				$label.html( labelVal );
		});

	//css
	$( '.inputfile' ).prev().css({
		'width':'auto',
		'max-width':'300px',
		'padding':'.5em 1em',
		'display':'block',
		'text-align':'center',
		'color':'#fff',
		'background':'#417AD1',
		'border':'3px solid #143971',
		'cursor':'pointer'
	});

	$( '.inputfile' ).css({
		'position':'absolute',
		'width':'0.1px',
		'height':'0.1px',
		'visibility':'hidden',
		'z-index':'-1'
	});
	$('form').css({'position':'relative'});

		// Firefox bug fix
	$( '.inputfile' )
		.on( 'focus', function(){ $(this).addClass( 'has-focus' ); })
		.on( 'blur', function(){ $(this).removeClass( 'has-focus' ); });

	// Advance Search
	$('.adv-search-toggle').click(function(e){
		e.preventDefault();
		$('#adv-search').slideToggle('300');
		return false;
	})


})(jQuery);