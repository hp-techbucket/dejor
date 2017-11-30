	
	
	
	$(document).ready(function(){
		$('.collapsible').collapsible();
	});

		/*
		**	START MESSAGING FUNCTIONS	
		*/ 
		//function to handle submit new message form
		function sendMessage() { 
				
			$("#alerts").hide();
				
			var isFormValid = true; 
			$( "#load" ).show();
				
			//validate form before submit
				
			if ($("#address_book").val().trim() === '') {
								
				//$(this).css('border-color','red');     
						
				$("#alerts").html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <div class="alert alert-danger text-center" role="alert"><i class="fa fa-exclamation-triangle"></i> Please select a recipient!</div>');
				isFormValid = false;
						
			}
					//else{
					//	$(this).css('border-color','#B2B2B2');
				//	}
				
			if(!isFormValid){
				$("#alerts").show();
				$( "#load" ).hide();
				return isFormValid;
			} 

			var str = $("#address_book").val();
			//str = str.replace(/[^a-zA-Z 0-9]+/g, '');
			var words = str.split(" - ");
			var receiverName = words[0];
			var receiverUsername = words[1];
			
			var dataString = { 
				sender_name : $("#sender_n").val(),
				sender_username : $("#sender_u").val(),
				message_subject : $("#subject").val(),
				message_details : $("#editor").html(),
				receiver_name : receiverName,
				receiver_username : receiverUsername
			};
			
			var validate_url = $("#messageForm").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						//$('.compose').slideDown();
						$('#compose').click();
						
						$("#sender_name").val(''),
						$("#sender_username").val(''),
						$("#subject").val(''),
						$("#editor").text('')
							  
						$("#response-message").html(data.notif);
						//$('html, body').animate({scrollTop: 350}, 700);
						//setTimeout(function() { 
							//$("#response-message").hide(600);
						//	$('#response-message').slideUp({ opacity: "hide" }, "slow");
						//}, 5000);
						
						setTimeout(function() {
							$("#response-message").fadeTo(500, 0).slideUp(500, function(){
								$(this).remove(); 
							});
						}, 3000);
						
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
			
		$('.disabled').prop('disabled', true);
			
		$(document).on("click", '.messageToggle', function(event) {
			
			event.preventDefault();	
			//var text = $(this).find('a').html();
			
			//alert(text);
			//$(".message-body").hide();
			//$(this).parent().parent().next().slideToggle(600);
			//var id = $(this).attr('id');
			//markAsRead(id);
			//if ($(this).next().is(":hidden")) {
			if ($(this).next().is(":hidden")) {
				$(".messageContents").hide();
				
				$(this).next().slideDown(600); 
				//$(this).next().show(600);
			} else { 
				$(this).next().slideUp(600); 
			} 
		});
		
		$('.mailbox-messages2').on("click", '.mToggle', function(event) { 
		
			event.preventDefault();
			//$(".message-body").hide();
			//$(this).parent().parent().next().slideToggle(600);
			//var id = $(this).attr('id');
			//markAsRead(id);
			if ($(this).parent().parent().next().is(":hidden")) {
				$(".message-body").hide();
				$(this).parent().parent().next().slideDown(600); 
				//$(this).next().show(600);
			} else { 
				$(this).parent().parent().next().slideUp(600); 
			} 
		});
		
					
		$(document).on("click", '.enquiryToggle', function(event) {
			
			event.preventDefault();	
			//var text = $(this).find('a').html();
			
			//alert(text);
			//$(".message-body").hide();
			//$(this).parent().parent().next().slideToggle(600);
			//var id = $(this).attr('id');
			//markAsRead(id);
			//if ($(this).next().is(":hidden")) {
			if ($(this).next().is(":hidden")) {
				$(".enquiryContents").hide();
				
				$(this).next().slideDown(600); 
				$("i",this).removeClass('fa-angle-double-down');
				$("i",this).addClass('fa-angle-double-up');
				//$(this).next().show(600);
			} else { 
				$("i",this).addClass('fa-angle-double-down');
				$("i",this).removeClass('fa-angle-double-up');
				$(this).next().slideUp(600); 
			} 
		});
		
		/*	
		$(".messageToggle").click(function () { 
			if ($(this).next().is(":hidden")) {
				$(".messageDiv").hide();
				$(this).next().slideDown("fast"); 
				//$(this).next().show(600);
			} else { 
				$(this).next().hide(); 
			} 
		});
		
		*/
		
		//mark inbox message as read
		function markAsRead(msgID, url) {
		
			//CHECK IF EMPTY, DONT PROCEED
			if(msgID === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
					
			$('#subj_line_'+msgID).addClass('msgRead');
			
			$(msgID).addClass('msgRead');
			
			var id = msgID;
			
			$.ajax({
				type: "POST",
				url: baseurl+""+url,
				data: {message_id: id},
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						$('.inbox-count').html(data.count_unread_messages);
						
					}
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		}	
		
			
		$(document).ready(function(){

			//$('.wysi-editor').wysihtml5();
			
			//$('.editor-wrapper').wysihtml5();
			
			//search mail call
			$("#search").on('paste change', searchMail);
			
				

				//messaging editor
				//$('.message_details').wysihtml5();//compose
				//$('.message_details').wysihtml5();//compose
				/*$('#message_details').wysihtml5({
					"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
					"emphasis": true, //Italics, bold, etc. Default true
					"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
					"html": false, //Button which allows you to edit the generated HTML. Default false
					"link": false, //Button to insert a link. Default true
					"image": false, //Button to insert an image. Default true,
					"color": false //Button to change color of font  
				});
				*/
				//$('#message_editor').wysiwyg();//reply

				
				$('[type=file]').change(function() {
					$('.fileinput-preview').show();
					
				});
				
				//Initialize Select2 Elements
				$(".select2").select2();
				//$("select").select2();
				   //Date picker
					$('.datepicker').datepicker({
					  autoclose: true,
					  format: 'yyyy-mm-dd'
					});
					
					
				   //Date picker
					$('.datepicker2').datepicker({
					  autoclose: true,
					  format: 'mm/dd/yyyy',
					});

				
				$('.private-message').click(function() {
					$('.messaging-box').show(300);
					$('.widget-user').hide(300);
				});
				
				$('.cancel-message').click(function() {
					$('.messaging-box').hide();
					$('.widget-user').show(300);
				});	
					

		});
					
						
			//function to preview message from the header
			function previewMessage(id, url) {
				
				////CHECK IF EMPTY, DONT PROCEED
				if(id === '' || url === ''){
					$( "#load" ).hide();
					return;
				}	
				////alert('ID: '+id+' URL: '+url);
				
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

						$( "#load" ).hide();

						if(data.success == true){
							
							$("#header_subject").html(data.subject);
							
							$("#show_name").html(data.name);
							$("#show_username").html(data.username);
							$("#show_subject").html(data.subject);
							$("#show_attachment").html(data.attachment);
							$("#show_message").html(data.message);
							$("#show_files").html(data.files_link);
							
							$("#show_date").html(data.date_sent);
							$(".messages-unread").html(data.count_unread);

							$(".msg_list").html(data.header_messages);
							//remove message dynamically
							//$('.msg_list').has('input[name="cb[]"]:checked').remove();
							//$('.msg_list').find('a#'+id).parent().remove();	

						} 
							  
					},error: function(xhr, status, error) {
							alert(error);
					},

				});					
			}	
			
		//search mail ajax function		
		var searchMail = function () {
				
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
		
				//function for dynamic ajax reply message display
				function replyMessage(id, url) {
					
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
								$("#replying_to").html(data.replying_to);
								$("#messageID").val(data.message_id);
								$("#senderName").val(data.sender_name);
								$("#senderEmail").val(data.sender_email);
								$("#receiverName").val(data.receiver_name);
								$("#receiverEmail").val(data.receiver_email);
								$("#email_to").val(data.email_to);
								$("#messageSubject").val(data.message_subject);
								$("#message_editor").html(data.message_details);
											

							}else{
								$( "#load" ).hide();
							} 
								  
						},error: function(xhr, status, error) {
								alert(error);
						},

					});					
				}
		
		//function for dynamic ajax new message
		//using ajax to get recipient and sender details
		//direct messaging
		function sendDirectMessage(id,model,url) {
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || model === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
									
			$( "#load" ).show();
			$(".error-message").html('');
			
			//alert('ID: '+id+' Model: '+model);
			
			var dataString = { 
				id : id,
				model : model
			};				
			$.ajax({
						
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					$( "#load" ).hide();

					if(data.success == true){
						
						$(".form-group").show();
						$(".btn-primary").show();	
						
						$("#messageTitle").html(data.messageTitle);
						$("#email_to").val(data.email_to);
						$("#sender_name").val(data.sender_name);
						$("#sender_email").val(data.sender_email);
						$("#receiver_name").val(data.receiver_name);
						$("#receiver_email").val(data.receiver_email);
								

					} 
					if(data.success == false){
						//$(".form-group").remove();
						$(".form-group").hide();
						//$(".btn-primary").remove();
						$(".btn-primary").hide();
						$(".error-message").html(data.notif);
					} 			  
				},error: function(xhr, status, error) {
					alert(error);
				},

			});	
			//*/			
		}
		
					
		//function to submit new message
		function submitMessage() { 
				
			$("#alerts").hide();
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('message_form'));
			
			var validate_url = $('#message_form').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						
						//alert('Sent!');
						$("#load").hide();
						$("#messageModal").hide();
						$(".close-modal").click();
						
						$("#sender_name").val(''),
						$("#sender_username").val(''),
						$("#message_subject").val(''),
						$("#headerTitle").html(''),
						$("#email_to").val(''),
						$("#message_details").val(''),
						$("#receiver_name").val(''),
						$("#receiver_username").val('')
						
						//Materialize.toast(data.toast, 4000);
						
						$(".notif").html(data.notif);
						$(".errors").html(data.upload_error);
					//	$(".feedback-message").html(data.notif);
						
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							$('.feedback-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
					
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}		
					
		//function to submit reply message
		function submitReply() { 
				
			$("#alerts").hide();
			
			$( "#load" ).show();
			
			var dataString = { 
				message_id : $("#messageID").val(),
				sender_name : $("#senderName").val(),
				sender_email : $("#senderEmail").val(),
				message_subject : $("#messageSubject").val(),
				message_details : $("#message_editor").html(),
				receiver_name : $("#receiverName").val(),
				receiver_email : $("#receiverEmail").val()
			};
			
			var validate_url = $("#reply_form").attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						$("#load").hide();
						$("#replyModal").hide();
						$(".close-modal").click();
						
						$("#senderName").val(''),
						$("#senderUsername").val(''),
						$("#messageSubject").val(''),
						$("#headerTitle").html(''),
						$("#replying_to").html(''),
						$("#message_editor").html(''),
						$("#receiverName").val(''),
						$("#receiverUsername").val('')
						
						$(".response-message").html(data.notif);
						
						//get current sent messages count
						$(".sent-count").html(data.count_sent_messages);
						
						//$('html, body').animate({scrollTop: 350}, 700);
						setTimeout(function() { 
							//$("#response-message").hide(600);
							$('.response-message').slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
						//setTimeout(function() {
						//	$("#response-message").fadeTo(500, 0).slideUp(500, function(){
						//		$(this).remove(); 
						//	});
						//}, 3000);
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
					
						//$(".error-message").html(data.notif);
						$(".response-message").html(data.notif);
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

		
		//multiple messaging
		//function to handle submit new message form
		function newMessage() { 
		
			$(".custom-loading").show();
			
			$( "#load" ).show();
			
			$(".error-message").html('');
			
			var addressBook = $("#address_book").val().trim();
			var subject = $("#message_subject").val().trim();
			var message = $("#message_details").val().trim();
			var dataString = {};
			
			var model = $("#model").val().trim();
			//alert(addressBook);
		
			if(addressBook == '0'){
				$(".custom-loading").hide();
				$( "#load" ).hide();
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a recipient!</div>');
				$('html, body').animate({
					scrollTop: $(".error-message").offset().top
				}, 2000);
				return;
			}
			if(subject.length == 0){
				$(".custom-loading").hide();
				$( "#load" ).hide();
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a subject!</div>');
				$('html, body').animate({
					scrollTop: $(".error-message").offset().top
				}, 2000);
				return;
			}
			
			if(subject.length > 0 && subject.length < 3){
				$(".custom-loading").hide();
				$( "#load" ).hide();
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a longer subject!</div>');
				$('html, body').animate({
					scrollTop: $(".error-message").offset().top
				}, 2000);
				return;
			}
			
			if(message.length == 0){
				$(".custom-loading").hide();
				$( "#load" ).hide();
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a message!</div>');
				$('html, body').animate({
					scrollTop: $(".error-message").offset().top
				}, 2000);
				return;
			}	
			
			if(message.length > 0 && message.length < 3){
				$(".custom-loading").hide();
				$( "#load" ).hide();
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a longer message!</div>');
				$('html, body').animate({
					scrollTop: $(".error-message").offset().top
				}, 2000);
				return;
			}	
			
			var user = addressBook.split(" - ");
			var receiverName = user[0];
			var receiverEmail = user[1];
			//update form
			$("#receiver_name").val(receiverName);
			$("#receiver_email").val(receiverEmail);
			
			//var validate_url = baseurl+'message/new_message_validation';
			
			var form = new FormData(document.getElementById('message_form'));
			
			var validate_url = $('#message_form').attr('action');
			
				dataString = { 
					sender_name : $("#name").val(),
					sender_email : $("#username").val(),
					message_subject : subject,
					message_details : message,
					receiver_name : receiverName,
					receiver_email : receiverEmail
				};
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				success: function(data){
					
					if(data.success == true){
						$(".custom-loading").hide();
						$(".discard-button" ).click();
						$("#load").hide();
						$(".close-modal").click();
						$("#mailerModal" ).hide();
						$("#messageModal" ).hide();
						$('.modal-backdrop').hide();
						
						//clear the form
						$("#receiver_name").val('');
						$("#receiver_email").val('');
						$("#name").val('');
						$("#username").val('');
						$("textarea").val('');
						//$('[name=address_book]').val('0');
						$("#message_subject").val('');
						$("#message_details").val('');
						//$(".message_details").val('');
						//$('#message_details').data("wysihtml5").editor.clear();
						//$(".message-body").html('<textarea name="message_details" id="message_details" class="form-control message_details" style="width: 100%; height: 85px;" placeholder="Message"></textarea>');
						//$('.message_details').wysihtml5();
						
						$(".notif").html(data.notif);
						
						$("#success-message").html(data.notif);
						$(".success-message").html(data.notif);
						$(".response-message").html(data.notif);
						
						$('html, body').animate({
							scrollTop: $(".error-message").offset().top
						}, 2000);
						
						//get current sent messages count
						$(".sent-count").html(data.count_sent_messages);
						
						setTimeout(function() { 
							//$("#success-message").hide(600);
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							$('#success-message').slideUp({ opacity: "hide" }, "slow");
							$('.success-message').slideUp({ opacity: "hide" }, "slow");
							$('.response-message').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
							if(model == 'user'){
								window.location = baseurl+'account/messages';
							}else{
								window.location.reload(true);
							}
						}, 4000);
						
						
						$("html, body").animate({
							scrollTop: $(".box-body").offset().top
						}, 2000);
							  
						
					}else if(data.success == false){
						
						$("html, body").animate({
							scrollTop: $(".error-message").offset().top
						}, 2000);
							  
						$(".custom-loading").hide();
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			
			//*/
		
		}	
			
		
		//function to handle submit new message form
		function submitNewMessage() { 
			
			$(".error-message").html('');
			
			$( "#load" ).show();
			
			var addressBook = $("#address_book").val().trim();
			var message = $(".messageDetails").val().trim();
			var validate_url = baseurl+'message/new_message_validation';;
			
			//$(".feedback-message")
			var user = addressBook.split(" - ");
				var receiverName = user[0];
				var receiverUsername = user[1];
			
			if(addressBook == '0'){
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a recipient!</div>');
				return;
			}
			
			if(message.length < 3){
				$(".error-message").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please enter a longer message!</div>');
				return;
			}	
				
			var dataString = { 
					sender_name : $("#name").val(),
					sender_username : $("#username").val(),
					message_subject : $("#message_subject").val(),
					message_details : $(".messageDetails").val(),
					receiver_name : receiverName,
					receiver_username : receiverUsername
				};
			//alert(addressBook);
		
			$.ajax({
				type: "POST",
				url: validate_url,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){
					
					if(data.success == true){
						
						$("#load").hide();
						$(".close-modal").click();
						$("#messageModal" ).hide();
						$("#name").val('');
						$("#username").val('');
						$("#message_subject").val('');
						$(".messageDetails").val('');
						
						$(".success-message").html(data.notif);
						setTimeout(function() { 
							
							$('.success-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
					}else if(data.success == false){
						
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			
			//*/
		
		}	
					
		
	
		//function to handle multi delete
		function multiMessageDelete() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('message_delete_form'));

			var form_url = $('#message_delete_form').attr('action');
			
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
						$("#messageDeleteModal").modal('hide');  
						$("#notif").html(data.notif);
						
						//remove deleted rows dynamically
						$('table tr').has('input[name="cb[]"]:checked').remove();
						
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('#notif').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#delete-errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}
		
		
	
		//function to handle multi message archive
		function multiMessageArchive() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('message_archive_form'));

			var form_url = $('#message_archive_form').attr('action');
			
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
						$("#archiveModal").modal('hide');  
						$("#deleteModal").modal('hide'); 
						$(".response-message").html(data.notif);
						
						
						//display current inbox count
						$(".inbox-count").html(data.count_inbox_messages);
						
						//display current archive count
						$(".archive-count").html(data.count_archive_messages);
						
						//display current sent count
						$(".sent-count").html(data.count_sent_messages);
						
						//remove deleted rows dynamically
						$('table tr').has('input[name="cb[]"]:checked').remove();
						
						$("html, body").animate({
								scrollTop: $(".response-message").offset().top
						}, 2000);
						
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('.response-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#archiveModal").modal('hide');  
						$("#deleteModal").modal('hide');
						$(".response-message").html(data.notif);
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('.response-message').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}
		
		
	
		//function to handle moving messages 
		//from archives to inbox
		
		function moveMessages() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('move_to_inbox_form'));

			var form_url = $('#move_to_inbox_form').attr('action');
			
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
						$("#movetoInboxModal").modal('hide');  
						$("#response-message").html(data.notif);
						
						//display current inbox count
						$(".inbox-count").html(data.count_inbox_messages);
						
						//display current archive count
						$(".archive-count").html(data.count_archive_messages);
						
						$("html, body").animate({
							scrollTop: $(".nav-tabs").offset().top
						}, 2000);
						
						//remove deleted rows dynamically
						$('table tr').has('input[name="cb[]"]:checked').remove();
						
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('#response-message').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						$("html, body").animate({
							scrollTop: $(".nav-tabs").offset().top
						}, 2000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#movetoInboxModal").modal('hide');
						$("#response-message").html(data.notif);
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('#response-message').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}
				
		/*
		**	END MESSAGING FUNCTIONS	
		*/ 
		
