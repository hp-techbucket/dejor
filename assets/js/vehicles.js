		
		
		/*
		**====================START VEHICLES FUNCTIONS==========***\\\	
		*/ 
	
		
		$(document).ready(function() {
			
			
			$('.add_vehicle').click(function() {	
				
				$(".headerTitle").html('Add Vehicle');
				$(".thumbnail").html('');
				$(".thumbnail").css('display','none');			

				$("#vehicleID").val('');
				
				$(".u-thumbnail").html('');
				$("#vehicle_type").val('');
				//$("#vehicleType").val('');
				$("#vehicle_make").val('');
				//$("#vehicleMake").val('');
				$("#vehicle_model").val('');
				//$("#vehicleModel").val('');
				$("#year_of_manufacture").val('');
				$("#vehicle_odometer").val('');
				$("#vehicle_lot_number").val('');
				$("#vehicle_vin").val('');
				$("#vehicle_colour").val('');
				//$("#vehicleColour").val('');
				$("#vehicle_price").val('');
				$("#vehicle_location_city").val('');
				$("#vehicle_location_country").val('');
				$("#vehicle_description").val('');
				$("#sale_status").val('0');
				$("#trader_email").val('');
				$("#discount").val('');
				$("#price_after_discount").val('');
							
				$(".btn-add").show();
				$(".btn-update").addClass('hidden');				
			});
			
			
			$('.other-input').click(function(e) {
				e.preventDefault();
				//alert($(this).text());
				//$(this).siblings('input').
				//var input = $("input[name='"+fieldName+"']");
				//var input = $(this).parent().siblings('input[name="quantity"]');
				//$(this).prev().hide(300);
				//$(this).next().show(300);
				var input = $(this).siblings('input[type="text"]');
				var select = $(this).siblings('select');
				
				if (input.hasClass("hidden")) {
					select.hide(100);
					input.removeClass('hidden');
					input.show(100);
					$(this).text('Cancel');
					//$(this).next().slideDown(600); 
					//$(this).next().show(600);
				} else {
					select.show(100);
					input.hide(100);
					input.addClass('hidden');
					$(this).text('Other');
				} 
				//$(this).siblings('select').hide(300);
				//$(this).siblings('input[type="text"]').show(300);
				//$(".btn-update").addClass('hidden');				
			});
				
			$("#discount").on('paste change keyup', calculateDiscount);
			
		});
		
				
		//FUNCTION TO CALCULATE DISCOUNT	
		var calculateDiscount = function () {
			
				var rate = $(this).val().trim();
				var price = $('#vehicle_price').val().trim();
				if(rate.length > 1 && price.length > 1){
					var percentage = rate / 100;
					var percentage_value = price * percentage;
					var discount = price - percentage_value;
					
					$('#percentage-off').html('('+rate+'% off)');
					$('#price_after_discount').val(discount);
				}
				if(price.length > 1 && rate == ''){
					
					$('#percentage-off').html('');
					$('#price_after_discount').val('');
				}
				return; 
				
		}
	
		//FUNCTION TO CALCULATE DISCOUNT	
		function calculateDiscount2(obj) {
			var rate = $(obj).val().trim();
			var price = $('#vehicle_price').val().trim();
			if(rate.length > 1 && price.length > 1){
				var percentage = rate / 100;
				var percentage_value = price * percentage;
				var discount = price - percentage_value;
				
				$('#percentage-off').html('('+rate+'% off)');
				$('#price_after_discount').val(discount);
			}
			
		}
		
		//function to add new vehicle to db
		function addVehicle() { 
			
			$( "#load" ).show();
			
			if($("#vehicle_type").val().trim() === ''){
				$(".form_errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a type!</div>');
				return;
			}
			
			if($("#vehicle_make").val() == ''){
				$(".form_errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a make!</div>');
				return;
			}
			
			if($("#vehicle_model").val().trim() == ''){
				$(".form_errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a model!</div>');
				return;
			}
			
			if($("#vehicle_colour").val().trim() == ''){
				$(".form_errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a colour!</div>');
				return;
			}
			
			var form = new FormData(document.getElementById('addVehicleForm'));
			
			var validate_url = $('#addVehicleForm').attr('action');
			
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
						
						$(".thumbnail").html('');
						$(".thumbnail").css('display','none');
						
						$("#vehicle_type").val('');
						//$("#vehicleType").val('');
						$("#vehicle_make").val('');
						//$("#vehicleMake").val('');
						$("#vehicle_model").val('');
						//$("#vehicleModel").val('');
						$("#year_of_manufacture").val('');
						$("#vehicle_odometer").val('');
						$("#vehicle_lot_number").val('');
						$("#vehicle_vin").val('');
						$("#vehicle_colour").val('');
						//$("#vehicleColour").val('');
						$("#vehicle_price").val('');
						$("#vehicle_location_city").val('');
						$("#vehicle_location_country").val('');
						$("#vehicle_description").val('');
						$("#sale_status").val('0');
						$("#trader_email").val('');
						$("#discount").val('');
						$("#price_after_discount").val('');
							
						//$("#addVehicleModal").modal('hide');
						$('#addVehicleModal').hide();
						$('.modal-backdrop').hide();
						
						$( "#load" ).hide();
								  
						$(".notif").html(data.notif);

						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('#notif').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 5000);
						window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						
						$(".form_errors").html(data.notif);
						$(".form_errors").append(data.upload_error);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
			return false;
		}	
		 		
			
		//function to edit Vehicle details
		function editVehicle(id, url) {
			
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
					
						//populate the hidden fields
						//document.addVehicleForm.vehicleID.value = data.id;
						$("#vehicleID").val(data.id);
						
						$(".headerTitle").html('Update - '+data.headerTitle);
						
						$(".u-thumbnail").show();
						$(".u-thumbnail").html(data.thumbnail);
					
						$("#vehicle_type").html(data.vehicle_type_options);
						$("#vehicle_make").html(data.vehicle_make_options);
						$("#vehicle_model").html(data.vehicle_model_options);
						$("#year_of_manufacture").html(data.year_of_manufacture_options);
						$("#vehicle_odometer").val(data.vehicle_odometer);
						$("#vehicle_lot_number").val(data.vehicle_lot_number);
						$("#vehicle_vin").val(data.vehicle_vin);
						$("#vehicle_colour").html(data.colour_options);
						$("#vehicle_price").val(data.price);
						/*var decimal = '';
						if(data.price_decimal === 0){
							decimal = '.00';
						}
						//$(".price-decimal").html(decimal);*/
						$("#vehicle_location_city").val(data.vehicle_location_city);
						$("#vehicle_location_country").html(data.country_options);
						$("#vehicle_description").val(data.vehicle_description);
						$("#sale_status").html(data.sale_status_options);
						$("#trader_email").html(data.user_options);
						$("#discount").val(data.discount);
						$("#price_after_discount").val(data.price_after_discount);
						
						$(".btn-add").hide();
						$(".btn-update").removeClass('hidden');

						
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}	

		
		//function to submit edited Vehicle
		//to db
		function updateVehicle(url) {
			
			$( "#load" ).show();
			
			//var vehiclePrice = parseInt($("#vehicle_price").val());
			//var decimal = parseFloat($(".price-decimal").html());
			//var totalPrice = parseFloat(vehiclePrice+decimal);
			//$("#vehicle_price").val(totalPrice);
			//alert(totalPrice);
			
			
			var form = new FormData(document.getElementById('addVehicleForm'));
			
			//var validate_url = $('#addVehicleForm').attr('action');
			var validate_url = baseurl+""+url;
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: formData,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						//$("#addVehicleModal").modal('hide');
						$('#addVehicleModal').hide();
						$('.modal-backdrop').hide();
						
						$(".notif").html(data.notif);
						$(".errors").html(data.upload_error);
						
						$(".u-thumbnail").html('');
						$(".u-thumbnail").css('display','none');
						
						$("#vehicleID").val('');
						$("#vehicle_type").val('');
						$("#vehicleType").val('');
						$("#vehicle_make").val('');
						$("#vehicleMake").val('');
						$("#vehicle_model").val('');
						$("#vehicleModel").val('');
						$("#year_of_manufacture").val('');
						$("#vehicle_odometer").val('');
						$("#vehicle_lot_number").val('');
						$("#vehicle_vin").val('');
						$("#vehicle_colour").val('');
						$("#vehicleColour").val('');
						$("#vehicle_price").val('');
						$("#vehicle_location_city").val('');
						$("#vehicle_location_country").val('');
						$("#vehicle_description").val('');
						$("#sale_status").val('0');
						$("#trader_email").val('');
						$("#discount").val('');
						$("#price_after_discount").val('');
						
						
						
						//window.location.reload(true);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							$('.errors').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						$(".form_errors").append(data.upload_error);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
			
			//*/
			
		}	

		
		//function to submit edited Vehicle
		//to db
		function sellerUpdateVehicle(url) {
			
			$( "#load" ).show();
			
			//var vehiclePrice = parseInt($("#vehicle_price").val());
			//var decimal = parseFloat($(".price-decimal").html());
			//var totalPrice = parseFloat(vehiclePrice+decimal);
			//$("#vehicle_price").val(totalPrice);
			//alert(totalPrice);
			
			
			var form = new FormData(document.getElementById('addVehicleForm'));
			
			//var validate_url = $('#addVehicleForm').attr('action');
			var validate_url = baseurl+""+url;
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				data: form,
				//data: formData,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						//$("#addVehicleModal").modal('hide');
						$('#addVehicleModal').hide();
						$('.modal-backdrop').hide();
						
						$(".notif").html(data.notif);
						$(".errors").html(data.upload_error);
						
						$(".u-thumbnail").html('');
						$(".u-thumbnail").css('display','none');
						
						$("#vehicleID").val('');
						$("#vehicle_type").val('');
						$("#vehicleType").val('');
						$("#vehicle_make").val('');
						$("#vehicleMake").val('');
						$("#vehicle_model").val('');
						$("#vehicleModel").val('');
						$("#year_of_manufacture").val('');
						$("#vehicle_odometer").val('');
						$("#vehicle_lot_number").val('');
						$("#vehicle_vin").val('');
						$("#vehicle_colour").val('');
						$("#vehicleColour").val('');
						$("#vehicle_price").val('');
						$("#vehicle_location_city").val('');
						$("#vehicle_location_country").val('');
						$("#vehicle_description").val('');
						$("#sale_status").val('0');
						$("#discount").val('');
						$("#price_after_discount").val('');
						
						
						
						//window.location.reload(true);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							$('.errors').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						$(".form_errors").append(data.upload_error);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
			
			//*/
			
		}	
	
	$(document).ready(function(){
					
		$("a.grouped_elements").fancybox();
			
		$("a#single_image").fancybox();
			
		$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
		});
		
	
	});	
		
  		//function to view Vehicle details
		function viewVehicle(id, url) {
			
			
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

						$("#headerTitle").html(data.title);
						
						$("#image").html(data.image);
						
						$("#gallery").html(data.vehicle_gallery);
						//$("#vehicle_gallery").html(data.vehicle_gallery);
						$("#title").html(data.vehicle_title);
						$("#view-vehicle-type").html(data.vehicle_type);
						$("#view-vehicle-make").html(data.vehicle_make);
						$("#view-vehicle-model").html(data.vehicle_model);
						$("#view-year").html(data.year_of_manufacture);
						$("#view-odometer").html(data.vehicle_odometer);
						$("#view-lot-number").html(data.vehicle_lot_number);
						$("#view-vin").html(data.vehicle_vin);
						$("#view-colour").html(data.colour);
						$("#view-price").html(data.vehicle_price);
						$("#view-city").html(data.vehicle_location_city);
						$("#view-country").html(data.vehicle_location_country);
						$("#view-description").html(data.vehicle_description);
						$("#view-sale-status").html(data.saleStatus);
						$("#view-trader").html(data.trader);
						$("#view-discount").html(data.discount);
						$("#view-discount-price").html(data.price_after_discount);
						$("#view-old-price").html(data.old_price);
						
						$("#date-added").html(data.date_added);
						
						
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
		
		$(".progress").hide();
								
		//function to remove or add more images
		function editVehicleImages(id, url) {
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
						
			//$( "#load" ).show();
			//$(".progress").hide();

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
						$(".progress").hide();
						
						var images_count = data.images_count;
						var allowed_count = 0;
						
						if(images_count < 6){
							allowed_count = 5 - images_count;
						}
						
						
						//populate the hidden fields
						//document.upload_vehicle_images.vehicle_id.value = data.id;
						$("#vehicle_id").val(data.id);
						$("#existing_count").val(images_count);
						
						$("#header").html(data.headerTitle);
						
						$("#gallery-edit").html(data.image_group);
						$("#images_count").html(images_count);
						$("#allowed_count").html(' max allowed '+allowed_count);
						
					}else{
						$( "#load" ).hide();
						$("#errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}
		
		
		//function to upload Vehicle Images to db
		function uploadVehicleImages() {

			var isFormValid = true;
			var errorMessage = '';
			$(".img-alert").html('');
			$('.img-alert').slideDown({ opacity: "show" }, "fast");
		
			$( "#load" ).show();
			$("#progress-wrap").html('<div class="progress"><div class="indeterminate"></div></div>');
			
			//GET ALLOWED COUNT
			//var allowedCount = $("#allowed_count").html();
			var allowedCount = 5 - parseInt($("#existing_count").val());
						
			//GET CURRENT COUNT
			var existingCount = parseInt($("#existing_count").val());
			
			//COUNT NUMBER OF UPLOADED FILES
			var count = $('input[type=file]').filter(function(){
				return $(this).val();
			}).length;
			
			//CHECK IF NOT ALLOWED ANYMORE UPLOAD
			if(allowedCount == 0){
				isFormValid = false;
				errorMessage = 'You must delete an existing image before you can add another!<br/>';
				
			}
			
			//CHECK IF FILES ATTACHED MORE THAN ALLOWED NUMBER
			if(count > allowedCount){
				isFormValid = false;
				errorMessage += 'You can only upload '+allowedCount+' more image(s)!';
				
			}
			
			if(!isFormValid){
				$(".img-alert").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> '+errorMessage+'</div>');
				$( "#load" ).hide();
				$(".progress").hide();
				return isFormValid;
			}
			
			var form = new FormData(document.getElementById('upload_vehicle_images'));
			
			var validate_url = $('#upload_vehicle_images').attr('action');
			
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
						
						//progressBarMove();
						
						setTimeout(function() {

							$(".progress").hide();						
								
							var images_count = data.images_count;
							var allowed_count = 0;
							
							if(images_count < 6){
								allowed_count = 5 - images_count;
							}
							
							//$('input[type=file]').fieldValue('');
							//$("#portfolio_id").val('');
							
							//$("html, body").animate({ scrollTop: 0 }, "slow");					
							//$("#addImagesModal").modal('hide');
							$( "#load" ).hide();	
							//$("#myProgress").hide();
							$(".image_name").html('');
							$(".upload-gallery").html('');
							
							$(".img-alert").html(data.notif);
							$("#gallery-edit").html(data.image_group);
							$("#images_count").html(data.images_count);
							
							$("#allowed_count").html(allowed_count+' remaining');
							
						}, 2000);
						//window.location.reload(true);
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('.img-alert').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 4000);
						
						$(".input_file_wrap").html('<div class="form-group"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Select image file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="vehicle_images[]"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a></div></div>'); 

					}else if(data.success == false){
						
						$( "#load" ).hide();
						$(".img-alert").html(data.notif);
						$("#errors").html(data.upload_error);
						$(".input_file_wrap").html('<div class="form-group"><div class="fileinput fileinput-new" data-provides="fileinput"><span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Select image file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="vehicle_images[]"></span><span class="fileinput-filename"></span><a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a></div></div>');
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
					//location.reload();
				},
			});
			return false;
		}	
	
		
		//function to delete individual Vehicle image
		function deleteVehicleImage(obj,vehicle_id,image_id,path,url) { 
			
			//CHECK IF EMPTY, DONT PROCEED
			if(vehicle_id.length < 1 || image_id.length < 1 || path.length < 1 || url.length < 1){
				$( "#load" ).hide();
				return;
			}	
					
			$(obj).parent().parent('div').remove(); 
			
			$(".img-alert").html('');
			$('.img-alert').slideDown({ opacity: "show" }, "fast");
			
			$( "#load" ).show();
			$(".progress").show();
			
			//var form = new FormData(document.getElementById('deleteUserForm'));
			var dataString = { 
				vehicle_id : vehicle_id,
				id : image_id,
				path : path
			};
			
			//alert($("#id").val()+', '+$("#email").val()+', '+$("#user_model").val());
			
			$.ajax({
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				//data: form,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){

					if(data.success == true){
						
						//progressBarMove();
						$( "#load" ).hide();
						
						setTimeout(function() { 
								
							$(".progress").hide();
							//$("#myProgress").hide();
							
							var images_count = data.images_count;
							var allowed_count = 0;
							
							if(images_count < 6){
								allowed_count = 5 - images_count;
							}
							
							$(".img-alert").html(data.notif);
							$("#gallery-edit").html(data.image_group);
							$("#images_count").html(data.images_count);
							
							$("#allowed_count").html(allowed_count+' remaining');
							
						}, 600);
						
						setTimeout(function() { 
							
							$('.img-alert').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 2000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".img-alert").html(data.notif);
						$("#myProgress").hide();
						setTimeout(function() { 
							$('.img-alert').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}			
		
		//FUNCTION TO MAKE IMAGE MAIN
		function mainVehicleImage(obj,vehicle_id,image_name,url) {
			
			//CHECK IF EMPTY, DONT PROCEED
			if(vehicle_id.length < 1 || image_name.length < 1 || url.length < 1){
				$( "#load" ).hide();
				return;
			}	
					
			$(".img-alert").html('');
			$('.img-alert').slideDown({ opacity: "show" }, "fast");
			
			$( "#load" ).show();
			$(".progress").show();
			
			//var form = new FormData(document.getElementById('deleteUserForm'));
			var dataString = { 
				vehicle_id : vehicle_id,
				image_name : image_name,
			};
			
			//alert($("#id").val()+', '+$("#email").val()+', '+$("#user_model").val());
			
			$.ajax({
				type: "POST",
				url: baseurl+""+url,
				data: dataString,
				//data: form,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				success: function(data){

					if(data.success == true){
						
						//progressBarMove();
						$( "#load" ).hide();
						setTimeout(function() { 
								
							$(".progress").hide();
							//$("#myProgress").hide();
							
							var images_count = data.images_count;
							var allowed_count = 0;
							
							if(images_count < 6){
								allowed_count = 5 - images_count;
							}
							
							$(".img-alert").html(data.notif);
							$("#gallery-edit").html(data.image_group);
							$("#images_count").html(data.images_count);
							
							$("#allowed_count").html(allowed_count+' remaining');
							
						}, 600);
						
						setTimeout(function() { 
							
							$('.img-alert').slideUp({ opacity: "hide" }, "slow");
							//window.location.reload(true);
						}, 2000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".progress").hide();
						$("#myProgress").hide();
						
						$(".img-alert").html(data.notif);
						
						setTimeout(function() { 
							$('.img-alert').slideUp({ opacity: "hide" }, "slow");
						}, 5000);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
		
		}			
				
			//function to display clicked image
		//as main image
		function changeImage(a) {
			document.getElementById("main-img").src=a;
			//$("#main-img").parent().attr("href", a);
		}
		
		/*
		**===============END VEHICLES FUNCTIONS==============***\\	
		*/ 	
