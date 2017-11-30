/* 
Start of file functions.js 
Author Gialo Vela AKA Sid
*/	

	
	$(document).ready(function(){
					
		var $BODY=$("body");
		var e=function(){var e=$BODY.outerHeight()};

		$("#dashboard a:contains('Dashboard')").parent().addClass('active');
		
		$("#settings a:contains(' Settings')").parent().addClass('active');
		//$("#profile a:contains(' Profile')").parent().addClass('active');
		
		$("#vehicles").find('a#vehicles-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
		
		$("#vehicle_makes").find('a#vehicle-makes-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
		
		$("#vehicle_models").find('a#vehicle-models-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
		
		$("#vehicle_types").find('a#vehicle-types-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
		
		
		$("#admin_users a:contains(' Manage Admins')").parent().addClass('active');
		$("#inbox a:contains('Messages')").parent().addClass('active');
		$("#sent a:contains('Messages')").parent().addClass('active');
			
		$("#messages a:contains(' Messages ')").parent().addClass('active');
		$("#sent_messages a:contains(' Messages ')").parent().addClass('active');
		$("#sale_enquiries a:contains(' Sale Enquiries ')").parent().addClass('active');
		
		$("#users a:contains('Manage Users')").parent().addClass('active');
		$("#reviews a:contains(' Reviews')").parent().addClass('active');
		$("#question_categories a:contains(' Question Categories')").parent().addClass('active');
		
		$("#orders a:contains(' Orders')").parent().addClass('active');
		$("#shipping a:contains(' Manage Shipping')").parent().addClass('active');
		$("#shipping a:contains('Track Shipping')").parent().addClass('active');
		//$("#transactions a:contains(' Transactions')").parent().addClass('active');
		$("#transactions").find('a#transactions-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
		
		$("#payments").find('a#payments-link').parent("li").addClass("current-page").parents("ul").slideDown(function(){e()}).parent().addClass("active");
		
		//$("#sale_enquiries a:contains('Sale Enquiries')").parent().addClass('active');
		
		
		$("#logins i.fa-sign-in").parent() .parent().addClass('active');
		
		$("#failed_logins a:contains(' Manage Logins')").parent().addClass('active');
		
		$("#password_resets a:contains(' Password Resets')").parent().addClass('active');
		$("#failed_resets a:contains(' Password Resets')").parent().addClass('active');
		
		$("#security_questions a:contains('Security Questions')").parent().addClass('active');
		$("#site_activities a:contains('Site Activities')").parent().addClass('active');
		$("#page_metadata a:contains('Page Metadata')").parent().addClass('active');
		$("#colours a:contains('Manage Colours')").parent().addClass('active');
		
		$('#load').hide();
	
	});	


	
	$(document).ready(function(){
					
		//disable delete button
		//$('#deleteButton').attr('disabled', 'disabled');
		$('.deleteButton').attr('disabled', 'disabled');
		$('.deleteButton').click(function( event ) {
			var $target  = $(event.target);
						  // check to see if the submit was clicked
						  //    and if it is disabled, and if so,
						  //    return false
			if( $target.is(':submit:disabled') ) {
				return false;
			}
		});
		
		//checkbox function
		$('.checkBox').click(function() {
			//check all checkboxes and enable delete button
			if ($(this).is(':checked')) {
				//$('#deleteButton').removeAttr('disabled');
				$('#delButton').removeAttr('disabled');
				$('.deleteButton').removeAttr('disabled');
				$("input:checkbox").prop('checked', $(this).prop("checked"));
			//	$('#cb').each(function() { //loop through each checkbox
			//		this.checked = true;  //select all checkboxes with class "cb"               
			//	});
			} else {
				$('#delButton').attr('disabled', 'disabled');
				$('.deleteButton').attr('disabled', 'disabled');
				$("input:checkbox").prop('checked', false);
			//$('#cb').each(function() { //loop through each checkbox
			//	this.checked = false; //deselect all checkboxes with class "cb"                       
				//
				//}); 
			}
		});	

		$('.cb2').click(function() {
			//enable delete button
			if ($(this).is(':checked')) {
				$('#delButton').removeAttr('disabled');
			} else {
				$('#delButton').attr('disabled', 'disabled');
			}
		});	

		//disable delete button
		$('#delButton').attr('disabled', 'disabled');	
		$('.deleteButton').attr('disabled', 'disabled');		
		
		//disable archive button
		$('#archiveButton').attr('disabled', 'disabled');
		$('#undoButton').attr('disabled', 'disabled');		
		
		//Enable check and uncheck all functionality
		$(".checkbox-toggle").click(function () {
			var clicks = $(this).data('clicks');
		  if (clicks) {
			//Uncheck all checkboxes
			//list-tables 
			$(".mailbox-messages input[type='checkbox']").prop('checked', false);
			$(".list-tables input[type='checkbox']").prop('checked', false);
			$(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
			$('#delButton').attr('disabled', 'disabled');
			$('.deleteButton').attr('disabled', 'disabled');
			$('#archiveButton').attr('disabled', 'disabled');
			$('#undoButton').attr('disabled', 'disabled');
		  } else {
			//Check all checkboxes
			$('#delButton').removeAttr('disabled');
			$('.deleteButton').removeAttr('disabled');
			$('#archiveButton').removeAttr('disabled');
			$('#undoButton').removeAttr('disabled');
			$(".mailbox-messages input[type='checkbox']").prop('checked', true);
			$(".list-tables input[type='checkbox']").prop('checked', true);
			$(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
		  }
		  $(this).data("clicks", !clicks);
		
		});

			//GET STATES FROM COUNTRY ID
			//DROPDOWN CHANGE
			$('#cntry2').on('change', function() {
				
				//alert( this.value );
				
				//$( "#load" ).show();
				
				var dataString = { 
					id : this.value
				};	
				
				//$('.states').find("option:eq(0)").html("Please wait..");
				
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"location/get_states",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							$('.states').html('<option value="0" selected="selected">Please wait..</option>');
							setTimeout(function() { 
								$(".states").html(data.options);
							}, 600);
				
							
						}else{
							$( "#load" ).hide();
							$("#errors").html('Errors!');
						}   
										  
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
					},

				});		
			});	

			//GET MODELS FROM MAKE CHANGE
			//DROPDOWN CHANGE
			$('#vehicle_make2').on('change', function() {
				
				//alert( this.value );
				
				//$( "#load" ).show();
				
				var dataString = { 
					id : this.value
				};	
				
				//$('.states').find("option:eq(0)").html("Please wait..");
				
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"vehicle/get_models",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							$('#vehicle_model').html('<option value="0" selected="selected">Please wait..</option>');
							setTimeout(function() { 
								$("#vehicle_model").html(data.options);
							}, 600);
				
							
						}else{
							$( "#load" ).hide();
							$("#errors").html('Errors!');
						}   
										  
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
					},

				});		
			});

			//HANDLES THE CUSTOM CHECKBOX CHECKING AND UNCHECKING
			$(document).on('click', '.checkbox.checkbox-primary', function() {
				
				var checkbox = $(this).find('input:checkbox');
				
				if (checkbox.is(':checked')) {
					checkbox.prop("checked", false);//REMOVES THE CHECK
				} else {
					checkbox.prop("checked", true);//CHECKS THE CHECKBOX
				}
				
				//CHECK IF ANY CHECKBOX IS CHECKED AND HANDLES THE DELETE BTN
				//ACCORDINGLY
				if ($('.cb:checked').length >= 1) {
					$('#delButton').removeAttr('disabled'); //ENABLES THE DELETE BTN
					$('.deleteButton').removeAttr('disabled');
				} else {
					$('#delButton').attr('disabled', 'disabled');//DISABLES BTN
					$('.deleteButton').attr('disabled', 'disabled');
				}
									
			});

		
			
			
				
	});	
		//var radio = $(this).find('input:radio');
				//var form = $(this).find('input:radio').closest('form');
		
		function colourFunction() {
			
			var myselect = document.getElementById("vehicle_colour"),
			colour = myselect.options[myselect.selectedIndex].className;
			$("#vehicle_colour").css('background-color',colour);
			$("#vehicle_colour").css('color','#ffffff');
			myselect.className = colour;
			myselect.blur(); //This just unselects the select list without having to click
			
		}
		
		function deleteRecords(obj){
			var form = $(obj).closest('form');
			var formUrl = form.attr('action');
			var form_id = form.attr('id');
			var checkboxes = form.find('.cb');
			var model = form.find('[name=model]').val();
			
			var ids = [];
			checkboxes.each(function () {
				if ($(this).is(":checked")) {
					ids.push($(this).val());
				}
			});
			
			$('#user_ids').val(ids);
			$('#model').val(model);
			$('#formUrl').val(formUrl);
			
			//alert('URL: '+formUrl+', IDs: '+ids+', Model: '+model);
		}
				
		//function to enable delete button
		//once checkbox is checked
		function enableButton(obj){
			if ($(obj).is(':checked')) {
				$('#delButton').removeAttr('disabled');
				$('.deleteButton').removeAttr('disabled');
			} else {
				$('#delButton').attr('disabled', 'disabled');
				$('.deleteButton').attr('disabled', 'disabled');
			}
		}
		

		//GET STATES FROM COUNTRY ID
			//DROPDOWN CHANGE
			//#cntry on change
			//url = location/get_states
			function getStates(obj, url) {
				
				var id = $(obj).val().trim();
				
				if(id === '' || url === ''){
					return;
				}
				
				var dataString = { 
					id : id
				};	
				
				$.ajax({
					
					type: "POST",
					url: url,
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							$('.states').html('<option value="0" selected="selected">Please wait..</option>');
							setTimeout(function() { 
								$(".states").html(data.options);
							}, 600);
				
							
						}else{
							$( "#load" ).hide();
							$("#errors").html('Errors!');
						}   
										  
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
					},

				});		
			}	

			//GET MODELS FROM MAKE CHANGE
			//DROPDOWN CHANGE
			//#vehicle_make on change
			//url = vehicle/get_models
			function getVehicleModels(obj, url) {
				
				var id = $(obj).val().trim();
				var type = $('#vehicle_type').val().trim();
				
				if(id.length < 1 || url.length < 1){
					return;
				}
				
				var dataString = { 
					id : id,
					type : type
				};	
				
				$.ajax({
					
					type: "POST",
					url: url,
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							
							$('#vehicle_model').html('<option value="0" selected="selected">Please wait..</option>');
							setTimeout(function() { 
								$("#vehicle_model").html(data.options);
							}, 600);
				
							
						}else{
							$( "#load" ).hide();
							$("#errors").html('Errors!');
						}   
										  
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						//alert(error);
					},

				});		
			}
		
		//forgot Password function		
		function forgotPassword() {
				
			//e.preventDefault();
				if($("#fp-email").val().length < 1){
					return;
				}
				
				//get values from form
				var form = new FormData(document.getElementById('forgotPasswordForm'));
				var validate_url = $('#forgotPasswordForm').attr('action');
				
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
							$(".next-step").click();
							$("#alert-message").html(data.notif);
						

						}else if(data.success == false){
							//testFunction(false);
							$( "#load" ).hide();
							//$(".prev-step").click();
							$("#error-message").html(data.notif);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						alert(error);
					},
				});
				
				return; 
				
		}		
		
		$(document).ready(function() {
			$("#code, #make_code, #model_code").on('paste change keydown keyup', upperCase);
		});	
				
		//FUNCTION TO TRANSFORM INPUT TO UPPERCASE	
		var upperCase = function () {
			
				var txt = $(this).val().trim();
				
				return $(this).val(txt.toUpperCase());
				
		}
	
		
		//function to handle submit update security form
		function updateSecurity() { 
			
			$( "#load" ).show();
			
			var question = $("#security_question").val().trim();
			var answer = $("#security_answer").val().trim();
			
			if(question == '' || question.length < 1 || answer == '' || answer.length < 1){
				return;
			}
			
			//alert('Question: '+question+' Answer: '+answer);
			
			
			//var form = $('#update_security').get(0);
			var form = new FormData(document.getElementById('set_security_form'));
			var validate_url = $("#set_security_form").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
					
						$("#security_question").val('');
						$("#security_answer").val('');
						
						$("#response-message").html(data.notif);
						
						$("html, body").animate({
							scrollTop: $(".card").offset().top
							
						}, 2000);
						
						//$(".update-security").slideUp(600);
						
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('#response-message').slideUp({ opacity: "hide" }, "slow");
							window.location = baseurl+"account/dashboard"; 
						}, 5000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
						//$( "#updatePINModal" ).hide();
						
						//$(".error-message").hide();
						$("#response-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						//$("#response-errors").html(data.errors);
						//$("#response-message").append();
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}	


		
		//submit Enquiry function		
		function submitEnquiry() {
			
			$( "#load" ).show();
			
			//get values from form
			var form = new FormData(document.getElementById('enquiry_form'));
			var validate_url = $('#enquiry_form').attr('action');
				
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
						$("input").val('');
						$("textarea").val('');
						$("input[type='checkbox']").prop('checked', false);
						
						$("html, body").animate({
							scrollTop: $(".notif").offset().top - 100		
						}, 600);
						
						$(".notif").html(data.notif);
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location = baseurl+""+data.url;
						}, 2000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
	
						$(".notif").html(data.notif);
					}
							
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					$(".notif").html(error);
				},
			});
				
			return; 
				
		}		
		
		//SUBSCRIPTION FORM SUBMIT
	
		//FUNCTION TO HANDLE USER SIGNUP FORM
		function userSignup() { 
			
			//clear any previous errors
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('signup_form'));
			var validate_url = $("#signup_form").attr('action');
			//baseurl+"home/quote_request_validation"
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						
						$("input").val('');
						window.location.href= baseurl+''+data.success_url;
						
						//$("#signup-form").html(data.notif);
						//$("#notif").html(data.notif);
						//setTimeout(function() { 
							
							//window.location.href= baseurl+''+data.profile_url;
						//}, 5000);
						//$('body').appendTo(data.notif).fadeIn(300).delay(3000).fadeOut(500);
						
					}else if(data.success == false){
						$( "#load" ).hide();
					
						$("#notif").html(data.notif);
						//$('body').appendTo(data.notif).fadeIn(300).delay(3000).fadeOut(500);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					$("#notif").html(error);
					//alert(error);
					//location.reload();
				},
			});
		
		}

		
		//SUBSCRIPTION FORM SUBMIT
	
		//function to handle submit subscribe form
		function emailSubscribe() { 
			
			//clear any previous errors
			$(".response-message").html('');
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('subscription_form'));
			var validate_url = $("#subscription_form").attr('action');
			//baseurl+"home/quote_request_validation"
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						
						$("#subscription_email").val('');
						
						$(".response-message").html(data.notif);
						setTimeout(function() { 
							$(".response-message").hide(600);
						}, 5000);
						//$('body').appendTo(data.notif).fadeIn(300).delay(3000).fadeOut(500);
						
					}else if(data.success == false){
						$( "#load" ).hide();
					
						$(".response-message").html(data.notif);
						//$('body').appendTo(data.notif).fadeIn(300).delay(3000).fadeOut(500);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}
		//SUBSCRIPTION FORM SUBMIT
		
		/*
		**	START CONTACT US MESSAGE FUNCTIONS	
		*/ 
		
		//function to handle submit contact us form
		function contactUsMessage() { 
		
			$(".error-message").hide();
			var error = '';
			var isFormValid = true; 
			$( "#load" ).show();
			
			//validate form before submit
			
				if ($("#contact_us_message").val().trim() === '') {
							
					$(this).css('border-color','red');     
					
					$(".error-message").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <i class="fa fa-exclamation-triangle"></i> Please enter your message!');
					isFormValid = false;
					
				}else{
					$(this).css('border-color','#B2B2B2');
				}
			
			if(!isFormValid){
					$(".error-message").show();
					$( "#load" ).hide();
					return isFormValid;
			} 
			
			var dataString = { 
				contact_us_name : $("#contact_us_name").val(),
				contact_us_telephone : $("#contact_us_telephone").val(),
				contact_us_email : $("#contact_us_email").val(),
				contact_us_company : $("#contact_us_company").val(),
				contact_us_message : $("#contact_us_message").val()
			};
			var form = $('.contact_us_form').get(0);
			//var form = new FormData(document.getElementById('contact_us_form'));
			var validate_url = $(".contact_us_form").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: new FormData(form),
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
					
						$("#contact_us_name").val('');
						$("#contact_us_telephone").val('');
						$("#contact_us_email").val('');
						$("#contact_us_company").val('');
						$("#contact_us_message").val('');
							  
						$("#response-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('#response-message').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						$(".error-message").hide();
						$("#response-message").html(data.notif+'<br/>'+data.errors);
						//$('html, body').animate({scrollTop: 350}, 700);
						//$("#response-errors").html(data.errors);
						//$("#response-message").append();
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}	
	
		/*
		**	END CONTACT US MESSAGE FUNCTIONS	
		*/ 
						
	/*
		**==============FEEDBACK FUNCTIONS=================***\\	
		*/ 
		function leaveFeedback() { 

			var form = new FormData(document.getElementById('feedbackForm'));
			
			//var editor = $('#comment-editor').html();
			
			//populate the hidden fields
			//document.addTestimonialForm.cmmnt.value = editor;
			//$('#cmmnt').val(editor);
			
			var validate_url = $('#feedbackForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				//dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){

					
					if(data.success == true){
						
						$("#cmmnt").val('');
						
						$( "#load" ).hide();
						$( "#feedbackModal" ).hide();
								  
						$(".feedback-message").html(data.notif);
						
						setTimeout(function() { 
							$(".feedback-message").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		/*
		**==============END FEEDBACK FUNCTIONS=================***\\	
		*/ 	
		
		
		$(document).ready(function(){
			
			//search call
			$("#search").on('paste change', searchVehicles);
		
		});
			
		//search ajax function		
		var searchVehicles = function () {
				
				//e.preventDefault();
				
				var search = $(this).val();
				var displayString = '';
				var form,validate_url;
				
				$('#display_option').html('<strong>Showing All</strong>');
				
				if($('#hidden').val() == 'inbox'){
					if(search.length < 1){
						window.location.reload(true);
						return;
					}
					
				//$('#display_option').html('Showing Results for <strong><em>'+search+'</em></strong> <a href="'+base_url+'message/inbox">Show All</a>';
					//get values from form
					form = new FormData(document.getElementById('inbox_search_form'));
					validate_url = $('#inbox_search_form').attr('action');
				}
				
				if($('#hidden').val() == 'sent'){
					if(search.length < 1){
						window.location.reload(true);
						return;
					}
					
					//$('#display_option').html('Showing Results for <strong><em>'+search+'</em></strong> <a href="'+base_url+'message/sent">Show All</a>';
					//get values from form
					form = new FormData(document.getElementById('sent_search_form'));
					validate_url = $('#sent_search_form').attr('action');
				}
				
				
				
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
							
							$(".count").html(data.count);
							$("#display_option").html(data.display_option);
							$(".current").html(data.current);
							$(".pagnums").html(data.pagination);
							$(".message-tbody").html(data.messages_display);
							//$(".message-tbody").html(data.messages_display);
							

						}else if(data.success == false){
							$( "#load" ).hide();
							$("#display_option").html(data.display_option);
							$(".current").html(data.current);
							$(".pagnums").html(data.pagination);
							$(".count").html(data.count);
							$(".message-tbody").html(data.messages_display);
						}
							
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						alert(error);
					},
				});
				
				return; 
				
		}
		
		
		function searchDejor(s){
			var search_string = s;
			$(".search-results").html(search_string);
		}
		
		$('#search-btn, #btn-search').click(function(e){
			 e.preventDefault(); //Prevent the normal submission action
			// var form = this;
			var form = $(this).closest('form');
			var form_id = form.attr('id');
			//alert(form_id);
			
			var isFormValid = true;
			var errors = '';
			
			if(form_id == 'search-form'){
				if ($("#keywords").val().trim() === '') {
					isFormValid = false;
					
				}
			}
			if(form_id == 'multi_search_form'){
				if ($("#vehicle_type").val().trim() === '') {
					errors += '<p class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select vehicle type</p>';
					//errors = 
					isFormValid = false;
				}
				if ($("#vehicle_make").val().trim() === '') {
					errors += '<p class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select vehicle make</p>';
					//errors = 
					isFormValid = false;
				}
				if ($("#vehicle_model").val().trim() === '') {
					errors += '<p class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select vehicle model</p>';
					//errors = 
					isFormValid = false;
				}
			
			}
			
			if(!isFormValid){
				//$(".error-message").show();
				$("#search-error").html('<div class="alert alert-danger text-center">'+errors+'</div>');
				$( "#load" ).hide();
				return isFormValid;
			} 
			// ... Handle form submission
			form.submit();
		});
			
		/*
		**	START SEARCH FUNCTIONS	
		*/ 
		
		//function to handle submit SEARCH form
		function search(obj) { 
		
			$("#search-error").html('');
			$("#search-error").show();
			
			
			//var search_form = $(obj).closest('form');
			var search_form = $(obj).parents('form:first');
			var form_id = search_form.attr('id');
			var validate_url;
			var isFormValid = true;
			var errors;
			
			alert(form_id);
			
			if(form_id == 'search-form'){
				if ($("#keywords").val().trim() === '') {
					isFormValid = false;
					
				}
				validate_url = $("#search-form").attr('action');
			}
			
			if(form_id == 'multi_search_form'){
				if ($("#vehicle_type").val().trim() === '' || $("#vehicle_make").val().trim() === '' || $("#vehicle_model").val().trim() === '') {
					$("#search-error").html('<div class="alert alert-danger text-danger text-center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select vehicle</div>');
					//errors = 
					isFormValid = false;
				}
				validate_url = $("#multi_search_form").attr('action');
			}
			
			if(!isFormValid){
				//$(".error-message").show();
				$( "#load" ).hide();
				return isFormValid;
			} 
			
			$( "#load" ).show();
			/*
			//var form = $('.contact_us_form').get(0);
			var form = new FormData(document.getElementById(form_id));
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$("#response-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('#response-message').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						$(".error-message").hide();
						$("#response-message").html(data.notif+'<br/>'+data.errors);
						//$('html, body').animate({scrollTop: 350}, 700);
						//$("#response-errors").html(data.errors);
						//$("#response-message").append();
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			*/
		}	
	
		/*
		**	END SEARCH FUNCTIONS	
		*/ 
				
		
					
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
	
		
		
		
		


	/* End of file functions.js */	