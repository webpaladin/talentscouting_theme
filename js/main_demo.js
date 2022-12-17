jQuery(function($) {

	$( "ol" ).each(function() {
		var   val=1;
		if ( $(this).attr("start")){
			val =  $(this).attr("start");
		}
		val=val-1;
		val= 'my-awesome-counter '+ val;
		$(this ).css('counter-reset',val );
	});

// паралакс фока блока
function parallax(){
	var scrolled = $(window).scrollTop();
	if ($(window).width() < 480) {
		$('.kachrem').css('background-position-y', -(scrolled * 0.2) + 300 + 'px');
	} else {
		$('.kachrem').css('background-position-y', -(scrolled * 0.2) + 'px');
	}
}
$(window).scroll(function(e){
	parallax();
});

// кнопка скролла к верху страницы
$("#to-top").on("click", function() {
	$('body,html').animate({
		scrollTop:0
	}, 800);
	return false;
});

// скролл меню до блока с id
$(document).ready(function(){
	$("#menu").on("click","a", function (event) {
		// event.preventDefault();
		var id  = $(this).attr('href'),
		top = $(id).offset().top;
		$('body,html').animate({scrollTop: top}, 1500);
	});
});

//Мобильное меню 
$("#mm-but").on("click", function() {
	$(".mobile-menu").slideToggle("fast");
});

// клик по кнопке
$('#close-zap').on("click", function () {
	$('#bg-black').css('display', 'none');
	$('#zapnarem').css('display', 'none');
});

site_url = document.location.origin;
// Слайдер 1
$(document).ready(function(){
	$('.slider').owlCarousel({
		items:1,
		loop:true,
		autoplay:true,
		nav:true,
		navText: ['<img src="'+site_url+'/wp-content/themes/Accounting/img/left-arrow.png">',
		'<img src="'+site_url+'/wp-content/themes/Accounting/img/right-arrow.png">']
	});
});

// Слайдер 2
$(document).ready(function(){
	$('.slider2').owlCarousel({
		responsive:{
			0:{
				items:1,
			},
			426:{
				items:1,
			},
			581:{
				items:3,
			}
		},
		loop:true,
		dots:true,
		autoplay:true,
		nav:true,
		navText: ['<img src="'+site_url+'/wp-content/themes/Accounting/img/left-arrow.png">',
		'<img src="'+site_url+'/wp-content/themes/Accounting/img/right-arrow.png">']
	});
});

// пример
function Someting(val) {
	site_link = location.host;
	site_protocol = location.protocol;
	$('.pb-left').html('<img src="'+site_protocol+'//'+site_link+'/wp-content/themes/FreshFree/img/nabor-popup.png">');

}

// Содержание
// В нужном месте добавить <div class="sc-page-menu"></div>

var scPageMenu = $('.sc-page-menu');
if (scPageMenu.length > 0) {
	var num = 1;
	$('h2,h3,h4').each(function(){
		$(this).attr('id','sc_nav_'+num);
		var text = $(this).text();
		var tag = $(this).get(0).tagName;
		scPageMenu.append('<a href="#sc_nav_'+num+'" class="sc_nav_'+tag+'">'+text+'</a><br>');
		num++;
	});
}



});