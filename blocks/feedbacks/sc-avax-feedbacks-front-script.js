jQuery(function($) {

	$(document).ready(function(){
		$('.feedbacks-slider').owlCarousel({
			responsive:{
    			0:{
    				items:1,
    			},
    			751:{
    				items:3,
    				margin:50
    			},
    			1001:{
    				items:3,
    				margin:65
    			},
    			1570:{
    				margin:100
    			}
    		},
			loop:true,
			autoplay:true,
			nav:false,
			dots:true,
		});
	});

});