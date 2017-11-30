	
	$(document).ready(function(){
					
		var $BODY=$("body");
		var e=function(){var e=$BODY.outerHeight()};
		
		$("#home a:contains('Home')").parent().addClass('active');
		$("#about a:contains('About Us')").parent().addClass('active');
		$("#services a:contains('Services')").parent().addClass('active');
		$("#contact_us a:contains('Contact Us')").parent().addClass('active');
		$("#gallery a:contains('Vehicle Gallery')").parent().addClass('active');
		$("#login a:contains('Login')").parent().addClass('active');
		$("#sign_up a:contains('Sign Up')").parent().addClass('active');

		
	
	});	
	
	
	$(document).ready(function(){
					
			/* 
			* Function for scroll to top button
			* And Fixed Navbar 
			*/	
			var amountScrolled = 300;
			
			//get window top
			var scrollTop = $(window).scrollTop();
			
			//get navbar top
			//var elementOffset = $('.navbar-menu').offset().top;
			
			//get distance btw navbar and window top
			//var distance = (elementOffset - scrollTop);
			
			//$('.navbar-menu').removeClass('navbar-fixed-top');
			
			$(window).scroll(function() {
				
				//console.log($(window).scrollTop())
				/*if ($(this).scrollTop() > 200) {
				  $('.navbar-menu').addClass('navbar-fixed-top');
				}else{
					$('.navbar-menu').removeClass('navbar-fixed-top');
				}*/
				
				if ( $(this).scrollTop() > amountScrolled ) {
					$('a.back-to-top').fadeIn('slow');
					//$('.top-btn-wrap').fadeIn('slow');
				} else {
					$('a.back-to-top').fadeOut('slow');
					//$('.top-btn-wrap').fadeOut('slow');
				}
				
			});
			
			$('#nav').affix({
				  offset: {
					top: $('#navbar-wrapper').height()
				  }
			});	
			
			$('a.back-to-top').click(function() {
				$('html, body').animate({
					scrollTop: 0
				}, 700);
				return false;
			});
			
			$(".go-to-menu").click(function() {
				$('html, body').animate({
					scrollTop: $("#top-menu").offset().top
				}, 2000);
			});
			
		  //Parallax
		  $('.parallax').parallax();
		  
		  //Material Box
		  $('.materialboxed').materialbox();
		  
		  //Slider
		  $('.slider').slider();
		  
		  // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
			$('.modal').modal();
			
			//You can also open modals programatically, the below code will make your modal open on document ready:
			//$('#modal1').modal('open');
			//$('#modal1').modal('close');
			 // Initialize collapse button
			  $(".button-collapse").sideNav();
			  // Initialize collapsible (uncomment the line below if you use the dropdown variation)
			  //$('.collapsible').collapsible();
			
			//Full Width Slider
			$('.carousel').carousel();
			$('.carousel.carousel-slider').carousel({fullWidth: true});
			
			//Material Box
			$('.materialboxed').materialbox();
			
			//Slider
			$('.slider').slider();
			
			//Tooltips
			//$('.tooltipped').tooltip({delay: 50});
			
			//Prefilling Text Inputs
			Materialize.updateTextFields();
			
			//Initialize Select2 Elements
			$(".select2").select2();
			
			//Carousel
			$('#myCarousel').carousel();
			var winWidth = $(window).innerWidth();
			$(window).resize(function () {

				if ($(window).innerWidth() < winWidth) {
					$('.carousel-inner>.item>img').css({
						'min-width': winWidth, 'width': winWidth
					});
				}
				else {
					winWidth = $(window).innerWidth();
					$('.carousel-inner>.item>img').css({
						'min-width': '', 'width': ''
					});
				}
			});
	
			//show and hide search box	
			$(".search-icon").click(function (e) { 
				e.preventDefault();
				//$(this).parent().toggleClass('open');
				$("i",this).toggleClass("fa-search fa-times");
						
			});
			
			//CLOSE SEARCH INPUT ON CLICK OUTSIDE ELEMENT
			//$(document).on("click", function () {
			$('.main-body2').on("click", function () {
				//GET INPUT ELEMENT
				var search_input = $(this).find('.search-dropdown input');
				
				//CHECK IF INPUT CONTAINS ANY VALUE
				if(search_input.val().trim().length > 0){
					
					//IF INPUT IS NOT EMPTY, LEAVE DROPDOWN OPEN
					$(this).find('.search-icon').parent().toggleClass('open');
				}else{
					//ELSE CLOSE AND CHANGE ICON RESPECTIVELY
					$(this).find('.search-icon i').removeClass("fa-times");
					$(this).find('.search-icon i').addClass("fa-search");
				}
				
			});
			/*
			$(".filter-box").on("click", function (event) {
				event.stopPropagation();
			});
			*/
			//$(document).on('click', '.search-dropdown .dropdown-menu', function (e) {
			//  e.stopPropagation();
			//});
			//$('li.dropdown.search-dropdown a').on('click', function (event) {
				
			//});
			
			//fire search function
			$("input#search").on('change paste keyup',function (e) {
				
				
				var string = $(this).val().trim();
				//CHECK IF INPUT CONTAINS ANY VALUE
				if(string.length > 0){
					$('.search-results').show();
					searchDejor(string);
				}else{
					$('.search-results').hide();
				}
						
			});
			
			/* 
			* Function for countup
			*/	
			var models_count = $('.models-count').text();
			var consultants_count = $('.consultants-count').text();
			var models_sale = $('.models-sale').text();
			var clients_count = $('.clients-count').text();	
				
			// Enter num from and to
			/*$({countNum: 0}).animate({countNum: models_count, countNum2: consultants_count}, {
			  duration: 2000,
			  easing:'linear',
			  step: function() {
				$('.models-count').text(Math.floor(this.countNum));
				$('.consultants-count').text(Math.floor(this.countNum2));
			  },
			  complete: function() {
				$('.models-count').text(this.countNum);
				$('.consultants-count').text(this.countNum2);
			  }
			});

			*/
			
			$('.models-count').countTo({
				from: 0,
				to: models_count,
				speed: 5000,
				refreshInterval: 50,
				onComplete: function(value) {
					console.debug(this);
				}
			});
			
			$('.consultants-count').countTo({
				from: 0,
				to: consultants_count,
				speed: 5000,
				refreshInterval: 50,
				onComplete: function(value) {
					console.debug(this);
				}
			});
			
			$('.models-sale').countTo({
				from: 0,
				to: models_sale,
				speed: 5000,
				refreshInterval: 50,
				onComplete: function(value) {
					console.debug(this);
				}
			});		
	
			$('.clients-count').countTo({
				from: 0,
				to: clients_count,
				speed: 5000,
				refreshInterval: 50,
				onComplete: function(value) {
					console.debug(this);
				}
			});	
			
			//DROPDOWN ON HOVER
			$('ul.nav li.dropdown').hover(function() {
			  $(this).find('.dropdown-menu.fa-ul').stop(true, true).delay(200).fadeIn(500);
			}, function() {
			  $(this).find('.dropdown-menu.fa-ul').stop(true, true).delay(200).fadeOut(500);
			});

			
		//$('input.floatLabel').parent().next().addClass('empty');
		//$('textarea.floatLabel').parent().next().addClass('empty');
		//$("select.floatLabel").next().css('left','20px');
		
			if ($(".textinput input").val() != "") {
				//$(".textinput input").addClass('filled');
				$(".textinput input").parent().next().addClass('float-to-top');
			} else {
				//$(".textinput input").removeClass('filled');
				$(".textinput input").parent().next().removeClass('float-to-top');
			}
			//FLOAT LABEL ON INPUT CHANGE
			$(".textinput input").on('change keyup keypress',function() {
				if ($(this).val() != "") {
					//alert($(this).val());
					//$(this).addClass('filled');
					$(this).parent().next().addClass('float-to-top');
				} else {
					$(this).parent().next().removeClass('float-to-top');
					//$(this).removeClass('filled');
				}
			});
				
			/*$(".textinput textarea").on('change keyup keypress',function() {
				if ($(this).val() != "") {
					//alert($(this).val());
					//$(this).addClass('filled');
					$(this).next().addClass('float-to-top');
					$(this).next().css('font-size','0.8em');
				} else {
					$(this).next().removeClass('float-to-top');
					$(this).next().css('font-size','1em');
					//$(this).removeClass('filled');
				}
			});*/
			//LIMIT THE NUMBER OF CHARACTERS IN TEXTAREA
			$(".textarea-control").on('change keyup keypress',function() {
				var maxVal = parseInt($(this).attr('data-length'));
				
				if ($(this).val().length >= maxVal) {
					return false;
				} 
			});
			
			//INPUT FUNCTION
			$(".input-group > input").focus(function(e){
				if ($(this).is(":invalid") && $(this).val().trim().length > 0) {
					$(this).css('border-color','#F44336');
				}else{
					$(this).css('border-color','#4CAF50');
					$(this).addClass("input-focus");
					$(this).prev().addClass("input-group-addon-focus");
				}
				
				
				
			}).blur(function(e){
				$(this).removeClass("input-focus");
				$(this).prev().removeClass("input-group-addon-focus");
				
			});	
			
			
			//INPUT FUNCTION
			$(".input-group > input").keyup(function(e){
				if ($(this).is(":invalid") && $(this).val().trim().length > 0) {
					$(this).css('border-color','#F44336');
				}else{
					$(this).css('border-color','#4CAF50');
					$(this).addClass("input-focus");
					$(this).prev().addClass("input-group-addon-focus");
				}
			});	
			
			//ON PASSWORD ENTER, SHOW 
			$('#upass, #security_answer').on('keyup', function(e) {
				if($(this).val().trim().length > 0){
					$(".show-password-wrap").show();
				}else{
					$(".show-password-wrap").hide();
				}
				
			});
		
			//ON PASSWORD ENTER, SHOW 
			$('.togglePassword').on('keyup', function(e) {
				var wrap = $(this).parent().find(".show-password-wrap");
				
				if($(this).val().trim().length > 0){
					wrap.show();
				}else{
					wrap.hide();
				}
				
			});
		
			//TOGGLE PASSWORD FIELD FROM TEXT TO PASSWORD
			$('.show-password').on('click', function(e) {
				e.preventDefault();
				var upass = document.getElementById('upass');
				if(upass.type == "password"){
					upass.type = "text";
					$(".show-password").html("Hide");
				} else {
					upass.type = "password";
					$(".show-password").html("Show");
				}
			});
			
			$('.show-answer').on('click', function(e) {
				e.preventDefault();
				var input = document.getElementById('security_answer');
				if(input.type == "password"){
					input.type = "text";
					$(".show-answer").html("Hide");
				} else {
					input.type = "password";
					$(".show-answer").html("Show");
				}
			});
			
			
			$(".open-modal").click(function (e) {
				e.preventDefault();
				var modal = $(this).attr('data-target');
				$(modal).show();
				//$(".custom-modal").show();
				
			});
			
			
			$(".close-modal").click(function (e) {
				e.preventDefault();
				$(".custom-modal").hide();
				
			});
			
			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				var modal = document.getElementsByClassName("custom-modal")[0];
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}		
			
			
			//*********STARR**********//
			$(".stars").starrr();
			
				
			$('.stars-existing').starrr({
				//var existingCount = $(this).attr('data-rating');
			  //rating: $('.stars-count-existing').html(),
			  rating: $('.stars-existing').attr('data-rating'),
			  readOnly: true
			});

			$('.stars').on('starrr:change', function (e, value) {
				$('.stars-count').html(value);
				$('.rating').val(value);
				//alert($('.rating').val());
			});
			
			$(".stars-existing").click(function (e) { 
				e.preventDefault();
			});
			//*/
			//*********STARR**********//
			
			
			
			
	});


			//TOGGLE PASSWORD FIELD FROM TEXT TO PASSWORD
			function togglePassword(obj, e) {
				//alert($(obj).html());
				e.preventDefault();
				
				//var upass = document.getElementsByClassName('upass');
				var field = $(obj).parent().parent().find(".togglePassword");
				var type = field.attr('type');
				
				//alert('Type: '+type+'; Val: '+field.val());
				
				if(type == "password"){
					//field.type = "text";
					field.attr('type', 'text');
					$(obj).html("Hide");
				} else {
					//field.type = "password";
					$(obj).html("Show");
					field.attr('type', 'password');
				}
			}
			
		
			
		//function to submit review
		//to db via ajax
		function submitReview(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('review_form'));
			
			var validate_url = $('#review_form').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						
						$('.rating').val('');
						$("#review_name").val('');
						$("#review_email").val('');
						$("#review_comment").val('');
						
						$( "#load" ).hide();
						
						$("#notif").html(data.notif);
						
						setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							$("html, body").animate({ scrollTop: 0 }, "slow");
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						/*setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							
						}, 8000);*/
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
	//FADE IN FUNCTION
	var $animation_elements = $('.fade');
	var $window = $(window);

	function check_if_in_view() {
		
		var window_height = $window.height();
		var window_top_position = $window.scrollTop();
		var window_bottom_position = (window_top_position + window_height);
		 
		$.each($animation_elements, function() {
			var $element = $(this);
			var element_height = $element.outerHeight();
			var element_top_position = $element.offset().top;
			var element_bottom_position = (element_top_position + element_height);
		 
			//check to see if this current container is within viewport
			if ((element_bottom_position >= window_top_position) &&
				(element_top_position <= window_bottom_position)) {
			  $element.addClass('in-view');
			} //else {
			 // $element.removeClass('in-view');
			//}
		});
	}

	$window.on('scroll resize', check_if_in_view);
	$window.trigger('scroll');
	
		
		

	/* 
	* Function for count up
	*/			
	(function($) {
		$.fn.countTo = function(options) {
			// merge the default plugin settings with the custom options
			options = $.extend({}, $.fn.countTo.defaults, options || {});

			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(options.speed / options.refreshInterval),
				increment = (options.to - options.from) / loops;

			return $(this).each(function() {
				var _this = this,
					loopCount = 0,
					value = options.from,
					interval = setInterval(updateTimer, options.refreshInterval);

				function updateTimer() {
					value += increment;
					loopCount++;
					$(_this).html(value.toFixed(options.decimals));

					if (typeof(options.onUpdate) == 'function') {
						options.onUpdate.call(_this, value);
					}

					if (loopCount >= loops) {
						clearInterval(interval);
						value = options.to;

						if (typeof(options.onComplete) == 'function') {
							options.onComplete.call(_this, value);
						}
					}
				}
			});
		};

		$.fn.countTo.defaults = {
			from: 0,  // the number the element should start at
			to: 100,  // the number the element should end at
			speed: 1000,  // how long it should take to count between the target numbers
			refreshInterval: 100,  // how often the element should be updated
			decimals: 0,  // the number of decimal places to show
			onUpdate: null,  // callback method for every time the element is updated,
			onComplete: null,  // callback method for when the element finishes updating
		};
	})(jQuery);	


	
	
	
        