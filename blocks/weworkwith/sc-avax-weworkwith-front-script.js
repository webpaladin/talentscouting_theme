jQuery(function($) {

	$(document).ready(function(){
		$('.weworkwith-slider').owlCarousel({
			responsive:{
    			0:{
    				items:3,
    				margin:30
    			},
    			751:{
    				items:5,
    				margin:30
    			},
    			1001:{
    				items:5,
    				margin:30
    			},
    			1570:{
    				items:5,
    				margin:30
    			}
    		},
			loop:true,
			autoplay:true,
			nav:false,
			dots:false,
		});
	});

});