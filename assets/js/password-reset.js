	$(document).ready(function () {
		
		$( ".processing-gif" ).hide();
		
		//Initialize tooltips
		//$('.nav-tabs > li a[title]').tooltip();
		
		//Wizard
		$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

			var $target = $(e.target);
		
			if ($target.parent().hasClass('disabled')) {
				return false;
			}
		});

		//next button function for password reset
		$(".next-step").click(function (e) {
					
			var $active = $('.wizard .nav-tabs li.active');
			$active.next().removeClass('disabled');
			nextTab($active);
					
		});
		
		$(".next-step-btn").click(function (e) {
					
			var $active = $('.wizard .nav-tabs li.active');
			$active.next().removeClass('disabled');
			nextTab($active);
					
		});
		
		//prev button function for password reset
		$(".prev-step").click(function (e) {

			var $active = $('.wizard .nav-tabs li.active');
			prevTab($active);

		});
		
		
	});

	
	function nextTab(elem) {
		$(elem).next().find('a[data-toggle="tab"]').click();
	}
	
	function prevTab(elem) {
		$(elem).prev().find('a[data-toggle="tab"]').click();
	}
			

			
		
				
			
			
		
		//FORGOT PASSWORD FUNCTION TO VALIDATE IF EMAIL
		//EXISTS		
		function validateEmail() {
			
			$("#email-error").html('');
			
			$( "#load" ).show();
			
			if($("#fp-email").val().length < 1 || $("#fp-email").val() == ''){
				
				$( "#load" ).hide();
				
				$("#email-error").html('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Please enter your registered e-mail address!</div>');
				
				$('#fp-email').focus();
				return false;
			}
				
			//get values from form
			var form = new FormData(document.getElementById('forgotPasswordForm'));
			
			var url = $("input[name='validate_email']").val();
			//alert(url);
			//var validate_url = baseurl+'home/validate_username';
				
				$.ajax({
					type: "POST",
					url:  baseurl+''+url,
					//data: form,
					data: form,
					//data: dataString,
					dataType: "json",
					cache : false,
					contentType: false,
					processData: false,
					
					success: function(data){
						
						if(data.success == true){
							
							$( "#load" ).hide();
							$(".next-step").click();
							$("#security-question").html(data.security_question);
							$("#fp-security-question").html(data.security_question);

						}else if(data.success == false){
							//testFunction(false);
							$( "#load" ).hide();
							//$(".prev-step").click();
							$("#email-error").html(data.notif);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						$("#email-error").html('Status: '+status+' Error: '+error);
						//alert(error);
					},
				});
				
				return; 
				
		}	


		
		
		//FORGOT PASSWORD FUNCTION TO VALIDATE 
		//USERS SECURITY QUESTION AND ANSWER		
		function validateAnswer() {
				
			$("#error-message").html('');
				
			$( "#load" ).show();

			if($("#fp-security-answer").val().length < 1){
				
				$("#error-message").html('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Please enter your security answer!</div>');
				$('#fp-security-answer').focus();
				return false;
			}
				
			var form = new FormData(document.getElementById('forgotPasswordForm'));
			
			var url = $("input[name='validate_answer']").val();
			//alert(url);
			//var validate_url = baseurl+'home/validate_security_answer';
				
			$.ajax({
					type: "POST",
					url: baseurl+''+url,
					//data: form,
					data: form,
					//data: dataString,
					dataType: "json",
					cache : false,
					contentType: false,
					processData: false,
					
					success: function(data){
						
						if(data.success == true){
							
							$( "#load" ).hide();
							$(".next-step-btn").click();
							
						}else if(data.success == false){
							//testFunction(false);
							$( "#load" ).hide();
							//$(".prev-step").click();
							$("#error-message").html(data.notif);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
						$("#error-message").html('Status: '+status+' Error: '+error);
					},
				});
				
				return; 
				
		}
		
		//forgot Password function		
		function newPassword() {
			
			//$( "#load" ).show();
			$( ".processing-gif" ).css('display','block');
			$( ".processing-gif" ).show();
			
			
			var newPassword = $("#fp-password").val();
			var confirmNewPassword = $("#fp-confirm-password").val();
			
			//e.preventDefault();
			if(newPassword.length < 1 || confirmNewPassword.length < 1 ){
				$( "#load" ).hide();
				$( ".processing-gif" ).hide();
				$("#password_error").html('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> Please enter your new password!</div>');
				
				return;
			}
			if(newPassword != confirmNewPassword){
				$( "#load" ).hide();
				$( ".processing-gif" ).hide();
				$("#password_error").html('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle"></i> The passwords don\'t match!</div>');
				$('#fp-password').focus();
				return false;
			}
			//var loader = baseurl+'assets/images/gif/load.gif';
			//$(".job_listings").html('<center><img src="'+loader+'"></center>');
				//get values from form
				var form = new FormData(document.getElementById('forgotPasswordForm'));
				var validate_url = $('#forgotPasswordForm').attr('action');
				//var validate_url = baseurl+'home/forgot_password_validation';
				
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
							
							$( "#load" ).hide();
							$( ".processing-gif" ).hide();
							$(".next-step").click();
							$("#complete-message").html(data.notif);
							/*
							$("html, body").animate({
								scrollTop: $(".custom-card").offset().top
							}, 600);
							setTimeout(function() { 
								$(".custom-card").html(data.notif);
							}, 300);
							*/	
							$('.wizard .nav-tabs li').removeClass('active');
							$('.wizard .nav-tabs li').addClass('disabled');
							
						}else if(data.success == false){
							$("#password_error").html(data.notif);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						$( ".processing-gif" ).hide();
						//alert(error);
						$("#password_error").html('Status: '+status+' Error: '+error);
					},
				});
				
				return; 
		
		}	
