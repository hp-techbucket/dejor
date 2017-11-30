
			$(".welcome-modal .close-modal").click(function (e) {
				e.preventDefault();
				$(".custom-modal").remove();
				
			});
			
		
		//*****************START ORDER FUNCTIONS*************//	
		//function to view Order details
		function viewOrder(id, url) {
			
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#ref").html(data.reference);
						$("#view-order-description").html(data.order_description);
						if(data.num_of_items == 1){
							$("#view-num-of-items").html(data.num_of_items+' item');
						}else{
							$("#view-num-of-items").html(data.num_of_items+' items');
						}
						
						$("#view-total-price").html(data.total_price);
						$("#view-payment-status").html(data.payment_status);
						
						if(data.edit_payment_status === '1'){
							$("#view-payment-method").html(data.view_payment_method);
						}
						
						$("#view-shipping-status").html(data.shipping_status);
						
						$("#view-order-date").html(data.order_date);
						$("#orderDate").html(data.orderDate);
						
						$("#view-delivery-date").html(data.delivery_date);
						 
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//*****************END ORDER FUNCTIONS*************//	
		
		
		//*****************TRANSACTIONS FUNCTIONS*************//	
  		//function to view Transaction details
		function viewTransaction(id, url) {
			
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#view-details").html(data.details);
						
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		//*****************END TRANSACTIONS FUNCTIONS*************//
		
				
		//*****************START SHIPPING FUNCTIONS*************//		
 			
			
  		//function to view Shipping Status details 
		//organized by reference
		function viewShippingDetails(reference, url) {
			
			if(reference === '')
				return;
					
			$( "#load" ).show();

			var dataString = { 
				reference : reference
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#statusTitle").html(data.headerTitle);
						
						$("#view-details-by-reference").html(data.shipping_status_details);
						
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//*****************END SHIPPING FUNCTIONS*************//
		
		
		
		//*****************SETTINGS FUNCTIONS*************//
		
		
		$(document).ready(function(){
					
			//Enable check and uncheck all functionality
			$(".btn-settings").click(function (e) {
				e.preventDefault();
				var href = $(this).attr('href');
				
				if ($(href).is(":hidden")) {
					$(".settings-section").slideUp(600);
					$(href).slideDown(600); 
					//$(this).next().show(600);
					var height = $(href).height();
					$("html, body").animate({
						scrollTop: $(href).offset().top + height		
					}, 200);
				} else { 
					$(href).slideUp(600);
				} 
				
				
				//alert(href)
				
			
			});
				
			
		
		});	
		
		
		//*****************PROFILE UPDATE FUNCTIONS*************//
		
		//CHANGE EMAIL ALERT STATUS
		function alertChange(obj, url){
			
			var status = '';
			
			$(".notif").html("");
			$(".notif").slideDown({ opacity: "show" }, "slow");
			
			if($(obj).is(':checked')){
				status = '1';
				//alert(status);
			}else{
				status = '0';
				//alert(status);
			}
			
			var dataString = { 
				alert_status : status,
			};
			
			$.ajax({
				type: "POST",
				url: baseurl+''+url,
				data: dataString,
				dataType: "json",
				cache : false,
				
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 5000);
						

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					$(".notif").html(error);
				},
			});
		} 
		
		
		//Enable SlideToggle Edit Profile
		function editProfile(obj){
			var scrolled=0;
			//$(obj).html('<i class="fa fa-chevron-right"></i>');
			$("span i",obj).toggleClass("fa-chevron-right fa-chevron-down");
			//alert('Click');
			$("#edit-profile").slideToggle(400);
			if($("#edit-profile").is(":hidden")){
				//$("#edit-profile").show(400);
				scrolled=scrolled-1500;
				var $elem = $('#edit-profile');
				$("html, body").animate({
					scrollTop: scrolled		
				}, 100);		
			}else{
				//$("#edit-profile").hide(400);
				$("html, body").animate({
					scrollTop: $(".card").offset().top		
				}, 100);
			}
			
		}
		
		
				
						
		//function to submit edited details
		//to db via ajax
		function updateUser(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('update_profile'));
			
			var validate_url = $('#update_profile').attr('action');
			
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
						
						$(".notif").html(data.notif);
						
						$("html, body").animate({
							scrollTop: $(".notif").offset().top - 100		
						}, 100);
						//$("#edit-profile").slideUp({ opacity: "hide" }, "slow");
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location = baseurl+""+data.url; 
							//window.location.reload(true);
						}, 5000);
						

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form-errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}

		
		//*****************END PROFILE UPDATE FUNCTIONS*************//
		
		//function to handle submit update Password form
		function updatePassword() { 
			
			var old_password = $("#old_password").val().trim();
			var new_password = $("#new_password").val().trim();
			var confirm_new_password = $("#confirm_new_password").val().trim();
			
			if(old_password == '' || old_password.length < 1 || new_password == '' || new_password.length < 1 || confirm_new_password == '' || confirm_new_password.length < 1){
				return;
			}
			
			$( "#load" ).show();
			
			//var form = $('#update_security').get(0);
			var form = new FormData(document.getElementById('password_update'));
			var validate_url = $("#password_update").attr('action');
			
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
					
						$("#old_password").val('');
						$("#new_password").val('');
						$("#confirm_new_password").val('');
						
						$(".notif").html(data.notif);
						
						$("html, body").animate({
							scrollTop: $(".breadcrumb").offset().top
							
						}, 2000);
						
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location = baseurl+""+data.url; 
						}, 5000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						$(".notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}	
		
		//FUNCTION TO VALIDATE SECURITY 
		function validateSecurity() { 
			
			var question = $("#security_question").val().trim();
			var answer = $("#security_answer").val().trim();
			
			if(question == '' || question.length < 1 || answer == '' || answer.length < 1){
				return;
			}
			
			$( "#load" ).show();
			
			//var form = $('#update_security').get(0);
			var form = new FormData(document.getElementById('security_validate'));
			var validate_url = $("#security_validate").attr('action');
			
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
					
						$(".notif").html(data.notif);
						
						$("#security_question").val('');
						$("#security_answer").val('');
						
						$("#security-check").slideUp(600);
						
						setTimeout(function() { 
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							$("#security-change").slideDown(600);
						}, 2000);
						
						
						
						
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
	
						$(".notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}

		
		//function to handle submit update security form
		function changeSecurity() { 
			
			var question = $("#securityQuestion").val().trim();
			var answer = $("#securityAnswer").val().trim();
			
			if(question == '' || question.length < 1 || answer == '' || answer.length < 1){
				return;
			}
			
			$( "#load" ).show();
			
			//var form = $('#update_security').get(0);
			var form = new FormData(document.getElementById('security_update'));
			var validate_url = $("#security_update").attr('action');
			
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
					
						//$("#securityQuestion").val('');
						//$("#securityAnswer").val('');
						
						$(".notif").html(data.notif);
						
						$("html, body").animate({
							scrollTop: $(".breadcrumb").offset().top
							
						}, 2000);
						
						setTimeout(function() { 
							
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location = baseurl+""+data.url; 
						}, 5000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						$(".notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}	
		
		//*****************END SETTINGS FUNCTIONS*************//
		
		
		
		
		//*****************START SALE ENQUIRIES FUNCTIONS*************//	
		//function to view SALE ENQUIRIES details
		function viewEnquiry(obj, id, url) {
			
			var $elem = $(obj).parent().parent().find('span').attr('class');
			alert($elem);
			//$(obj).parent().parent().find('span').removeClass('msgDefault').addClass('msgRead');
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#customer_name").html(data.customer_name);
						
						$("#customer_telephone").html(data.customer_telephone);
						$("#vehicle_title").html(data.vehicle_title);
						
						$("#comment").html(data.comment);
						
						$("#contact_method").html(data.preferred_contact_method);
						$("#location").html(data.location);
						$("#opened").html(data.opened);
						$("#enquiry_date").html(data.enquiry_date);
						$("#enquiries_unread").html(data.enquiries_unread);
						 
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//*****************END SALE ENQUIRIES FUNCTIONS*************//	
		
		
		
		
		//*****************START REVIEW FUNCTIONS*************//	
		//FUNCTION TO VIEW REVIEW DETAILS
		function viewReview(id, url) {
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#headerTitle").html(data.headerTitle);
						
						$("#reviewer_name").html(data.reviewer_name);
						
						$("#reviewer_email").html(data.reviewer_email);
						$("#reviewer_location").html(data.location);
						
						$("#reviewer_comment").html(data.comment);
						
						$("#reviewer_rating").html(data.rating_box);
						$("#review_date").html(data.review_date);
						$("#opened").html(data.opened);
						$("#enquiry_date").html(data.enquiry_date);
						$("#enquiries_unread").html(data.enquiries_unread);
						 
					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		//*****************END REVIEW FUNCTIONS*************//	
		
				
				/*
		**==============START DELETE FUNCTIONS=================***\\	
		*/ 
		//function to handle multi delete
		function multiDelete() { 
			
			$( "#load" ).show();
			
			//alert($(obj).attr('class'));
			
			//var htmlForm = $(obj).closest('form');
			
			//var form_id = htmlForm.attr('id');
			
			//var form = new FormData(form_id);

			//var form_url = $(form_id).attr('action');
			
			
			var form = new FormData($('#multi_delete_form').get(0));

			var form_url = $('#multi_delete_form').attr('action');
			
			
			$.ajax({
				type: "POST",
				url: form_url,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					if(data.success == true){
						
						$( "#load" ).hide();
						
						//$("#multiDeleteModal").modal('hide');  
						$('#multiDeleteModal').hide();
						$('.modal-backdrop').hide();
						
						$("#notif").html(data.notif);
						$(".notif").html(data.notif);
						
						//remove deleted rows dynamically
						$('table tr').has('input[name="cb[]"]:checked').remove();
						
						//get the number of deleted rows
						var deleted_count = data.deleted_count;
						
						//old number of rows displayed
						var old_count = $("#record-count").html();
						
						//substract deleted from old number
						var new_count = old_count - deleted_count;
						
						//change value displayed
						$("#record-count").html(new_count);
						
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('#notif').slideUp({ opacity: "hide" }, "slow");
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".notif").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			//*/
		}
