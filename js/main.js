jQuery(function($) {
	$('.wp-block-sc-avax-ourteamitem').on('click','button.more',function(){
		$(this).siblings('.bio').toggleClass('open');
		if ($(this).siblings('.bio').hasClass('open')) {
			$(this).text('less');
		} else {
			$(this).text('more');
		}
	});

	$('.mmenu').click(function(){
		$(this).toggleClass('mmmenuopen');
		$('header .container .header-menu').slideToggle({
			start: function() {
				$(this).css('display','block')
			}
		});
	});

	$(document).ready(function(){
		$(".topmenu, .footermenu").on("click","a", function (event) {
			var href = $(this).attr('href');
			if (href.search('#') != -1) {
				var id = href.slice(1);
				var block = $(id);
				if (block.length>0) {
					event.preventDefault();
					var top = $(id).offset().top;
					$('body,html').animate({scrollTop: top}, 1500);
				}
			}
		});
		$(".wp-block-sc-avax-hero").on("click","a", function (event) {
			event.preventDefault();
			var id = $(this).attr('href');
			var top = $(id).offset().top;
			$('body,html').animate({scrollTop: top}, 1500);
		});
	});

	$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: site.max_salary,
		values: [ 0, site.max_salary ],
		slide: function( event, ui ) {
			$( "#salary_min" ).val( ui.values[ 0 ]);
			$( "#salary_max" ).val( ui.values[ 1 ] );
		}
	});
	$( "#salary_min" ).val( $( "#slider-range" ).slider( "values", 0 ) );
	$( "#salary_max" ).val( $( "#slider-range" ).slider( "values", 1 ) );

	$('.filter-sidebar .item').on('click','h4',function(){
		$(this).toggleClass('open');
		$(this).siblings('.list').slideToggle();
	});

	$('.filter-sidebar .sidebar-header').on('click','h3',function(){
		if ($(window).width() < 751) {
			$(this).closest('.sidebar-header').siblings('.filter-sidebar-main').slideToggle();
		}
	});

	$('div#popup-bg').on('click', function(){
		$(this).css('display', 'none');
	});
	$('#popup-bg .mail-popup').on('click','.close',function(){
		$(this).closest('#popup-bg').css('display', 'none');
	});

	$('main.jobs-single .container .job-header').on('click','button',function(){
		$('#popup-bg').css('display', 'flex');
	});

	$('#popup-bg .mail-popup').on('click','',function(){
		event.stopPropagation();
	});



	$('main.archive-jobs .search').on('click','button.search',function(){
		let keyword = $(this).siblings('input[name="keyword"]').val();
		let location = $(this).siblings('input[name="location"]').val();
		let page = 1;
		$('.filter-sidebar-main input').prop("checked", false);
		$('.filter-sidebar-main input#salary_min').val("0");
		$('.filter-sidebar-main input#salary_max').val(site.max_salary);
		$('span.ui-slider-handle.ui-corner-all.ui-state-default:first').css("left","0");
		$('span.ui-slider-handle.ui-corner-all.ui-state-default:last').css("left","100%");
		$('.ui-slider-range.ui-corner-all.ui-widget-header').css({'left':0,'width':'100%'});
		jobsSort(keyword, location, page);
	});

	function jobsSort(keyword, location, page) {
		$.post(
			site.theme_path+"/inc/jobs_sort.php",
			{
				keyword:keyword,
				location:location,
				page:page
			},
			function(data) {
				$("main.archive-jobs .content-block .container .content").html(data);
				var top = $('.content-block').offset().top;
				$('body,html').animate({scrollTop: top}, 1500);
			}
			);
	}

	$('main.archive-jobs').on('click','.navigation.stoped.search-nav a',function(){
		event.preventDefault();
		let keyword = $('main.archive-jobs .search .form').find('input[name="keyword"]').val();
		let location = $('main.archive-jobs .search .form').find('input[name="location"]').val();
		let page = $(this).attr('data-page');
		jobsSort(keyword, location, page);
	});


	$('main.archive-jobs .content-block .container .filter-sidebar').on('click','button.submit-filter',function(){
		let industries = [];
		$('.filter-sidebar-main .item.industries-filter .check-container').each(function(){
			if ($(this).find('input').is(':checked')) {
				industries.push($(this).find('input').attr('name'));
			}
		});
		let location = [];
		$('.filter-sidebar-main .item.location-filter .check-container').each(function(){
			if ($(this).find('input').is(':checked')) {
				location.push($(this).find('input').attr('name'));
			}
		});
		let worktype = [];
		$('.filter-sidebar-main .item.worktype-filter .check-container').each(function(){
			if ($(this).find('input').is(':checked')) {
				worktype.push($(this).find('input').attr('name'));
			}
		});
		let page = 1;

		let salary_min = $('.filter-sidebar-main .item.salary-filter input#salary_min').val();
		let salary_max = $('.filter-sidebar-main .item.salary-filter input#salary_max').val();

		$('main.archive-jobs .search .form input').val('');

		jobsFilter(industries, location, worktype, page, salary_min, salary_max);
	});

	function jobsFilter(industries, location, worktype, page, salary_min, salary_max) {
		$.post(
			site.theme_path+"/inc/jobs_filter.php",
			{
				industries:industries,
				location:location,
				worktype:worktype,
				page:page,
				salary_min:salary_min,
				salary_max:salary_max

			},
			function(data) {
				$("main.archive-jobs .content-block .container .content").html(data);
				var top = $('.content-block').offset().top;
				$('body,html').animate({scrollTop: top}, 1500);
			}
			);
	}

	$('main.archive-jobs').on('click','.navigation.stoped.filter-nav a',function(){
		event.preventDefault();
		let industries = [];
		$('.filter-sidebar-main .item.industries-filter .check-container').each(function(){
			if ($(this).find('input').is(':checked')) {
				industries.push($(this).find('input').attr('name'));
			}
		});
		let location = [];
		$('.filter-sidebar-main .item.location-filter .check-container').each(function(){
			if ($(this).find('input').is(':checked')) {
				location.push($(this).find('input').attr('name'));
			}
		});
		let worktype = [];
		$('.filter-sidebar-main .item.worktype-filter .check-container').each(function(){
			if ($(this).find('input').is(':checked')) {
				worktype.push($(this).find('input').attr('name'));
			}
		});

		let salary_min = $('.filter-sidebar-main .item.salary-filter input#salary_min').val();
		let salary_max = $('.filter-sidebar-main .item.salary-filter input#salary_max').val();
		let page = $(this).attr('data-page');
		jobsFilter(industries, location, worktype, page, salary_min, salary_max);
	});


});