	$(document).ready(function() {
		
		$("#load").hide();
		
		//HIDE LOGO ON MENU RESIZE
		$("#menu_toggle").on("click",function() { 
			if($('.navbar.nav_title').is(":hidden") == false){
				$('.navbar.nav_title').hide();
			}else{
				$('.navbar.nav_title').show();
			}
					
		});


		$('.tags-input').tagsInput({
			  width: 'auto'
		});
						
		
				
			
	});	
	
	

		/*
		**====================START ADMIN USERS FUNCTIONS==========***\\\	
		*/ 
		//function to add new admin
		function addAdmin() { 

			var form = new FormData(document.getElementById('addAdminForm'));
			
			var validate_url = $('#addAdminForm').attr('action');
			
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
						
						$( "#load" ).hide();
						$("#addAdminModal").modal('hide');
						
						$("#name_of_admin").val('');
						$("#admin_username").val('');
						$("#admin_password").val('');
							  
						$("#notif").html(data.notif);
	
						setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$("#errors").html(data.upload_error);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		
		
		//Function to view admin user details
		function viewAdmin(id, url){
			
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
						
						$("#headerTitle").html(data.admin_name);
						$("#thumbnail").html(data.thumbnail);
						$("#adminUserName").html(data.admin_username);
						$("#adminName").html(data.admin_name);
						$("#accessLevel").html(data.access_level);
						
						$("#lastLogin").html(data.last_login);
						$("#dateJoined").html(data.date_created);				

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

		//Function to edit admin user details
		function editAdmin(id, url){
			
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
						document.updateAdminForm.adminID.value = data.id;
						//$("#adminID").val(data.id);
						
						$("#name").html(data.admin_name);
						$("#admin_name").html(data.admin_name);
						$(".u-thumbnail").html(data.update_thumbnail);
						$("#username").html(data.admin_username);
						$("#a_level").html(data.select_access_level);
						$("#old_password").val(data.admin_password);			

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
		
				
		//function to submit edited details
		//to db via ajax
		function updateAdmin(){
			
			var form = new FormData(document.getElementById('updateAdminForm'));
			
			var validate_url = $('#updateAdminForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$("#adminID").val('');
						$('#new_password').val('');
						$("#old_password").val('');
						
						$("#notif").html(data.notif);
						
						setTimeout(function() { 
							$("#notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		//function to Update Admins Profile
		//to db via ajax
		function updateProfile(){
			
			var form = new FormData(document.getElementById('profile_update'));
			
			var validate_url = $('#profile_update').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#updateModal').hide();
						$('.modal-backdrop').hide();
						
						$(".notif").html(data.notif);
						$(".notif").append(data.upload_errors);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$('#updateModal').hide();
						$('.modal-backdrop').hide();
						
						$(".notif").html(data.notif);
						$(".notif").append(data.upload_errors);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		//function to Update Admins Password
		//to db via ajax
		function updatePassword(){
			
			var form = new FormData(document.getElementById('settings_update'));
			
			var validate_url = $('#settings_update').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#updateModal').hide();
						$('.modal-backdrop').hide();
						
						$('#old_password').val('');
						$('#new_password').val('');
						$('#confirm_new_password').val('');
						
						$(".notif").html(data.notif);
						$(".notif").append(data.upload_errors);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
							//window.location.href= baseurl+''+data.profile_url;
							window.location = baseurl+""+data.profile_url;
							
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$('#updateModal').hide();
						$('.modal-backdrop').hide();
						
						$(".notif").html(data.notif);
						$(".notif").append(data.upload_errors);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		/*
		**====================END ADMIN USERS FUNCTIONS==========***\\\	
		*/ 
		

					
		/*
		**==============START USER FUNCTIONS===============***\\	
		*/ 
		$(document).ready(function() {
			
			
			$('.add_user').click(function() {	
				
				$(".headerTitle").html('Add New User');
				$(".thumbnail").html('');
				$(".thumbnail").css('display','none');			
				//populate the hidden fields
				//document.updateUserForm.userID.value = data.id;
				$("#userID").val('');
							
				//document.updateClientForm.avatar.value = data.avatar_name;
				$("#avatar").val('');
				$(".u-thumbnail").html('');
				$("#fName").val('');
				$("#lName").val('');
				$("#cName").val('');
				$("#address_line_1").val('');
				$("#address_line_2").val('');
				$("#cty").val('');
				$("#pcode").val('');
				//$("#state").val(data.state);
				$("#ste").val('');
				$("#cntry").val('');
				$("#tel").val('');
							
				$("#email_add").val('');
				$("#status").val('0');
				$("#security_question").val('');
				$("#security_answer").val('');
							
				$(".btn-add").show();
				$(".btn-update").addClass('hidden');				
			});
		});
	
	
		//function to handle add user
		function addUser() { 
		
			$( "#load" ).show();

			var form = new FormData(document.getElementById('addUserForm'));
			
			var validate_url = $('#addUserForm').attr('action');
			
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
						
						$( "#load" ).hide();
						
						$(".notif").html(data.notif);
						//$("#addUserModal").modal('hide');
						
						$('#addUserModal').hide();
						$('.modal-backdrop').hide();
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						
						$("#fName").val('');
						$("#lName").val('');
						$("#cName").val('');
						$("#address_line_1").val('');
						$("#address_line_2").val('');
						$("#cty").val('');
						$("#pcode").val('');
						$("#ste").val('');
						$("#cntry").val('');
						$("#tel").val('');
						$("#email_add").val('');
						$("#passwd").val('');
						
					

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
		
		
		//Function to view Users details
		function viewUser(id, url){
			
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
						$("#thumbnail").html(data.avatar);
						$(".fullName").html(data.fullName);
						$("#companyName").html(data.company_name);
						$("#complete_address").html(data.complete_address);
						$("#view-telephone").html(data.telephone);
					
						$("#view-email").html(data.email);
						
						$("#view-security-question").html(data.security_question);
						$("#view-security-answer").html(data.security_answer);
						$("#view-status").html(data.status);

						$("#view-last-login").html(data.last_login);
						
						
						$("#view-date-created").html(data.date_created);				

					}else if(data.success == false){
						
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}

		//Function to edit User details
		function editUser(id, url){
			
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
						
						$(".headerTitle").html('Edit User');
						
						//populate the hidden fields
						//document.updateUserForm.userID.value = data.id;
						$("#userID").val(data.id);
						
						//document.updateClientForm.avatar.value = data.avatar_name;
						$("#avatar").val(data.avatar_name);
						
						//$(".thumbnail").removeClass('fileinput-preview');
						//$(".thumbnail").addClass('fileinput-new');
						$(".u-thumbnail").show();
						$(".u-thumbnail").html(data.u_thumbnail);
						$("#fName").val(data.first_name);
						$("#lName").val(data.last_name);
						$("#cName").val(data.company_name);
						$("#address_line_1").val(data.address_line_1);
						$("#address_line_2").val(data.address_line_2);
						$("#cty").val(data.city);
						$("#pcode").val(data.postcode);
						//$("#state").val(data.state);
						$("#ste").html(data.state_options);
						$("#cntry").html(data.country_options);
						$("#tel").val(data.telephone);
						
						$("#email_add").val(data.email);
						
						$("#status").html(data.select_status);
						
						$("#security_question").val(data.security_question);
						$("#security_answer").val(data.security_answer);
						
						$(".btn-add").hide();
						$(".btn-update").removeClass('hidden');

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
		
						
		//function to submit edited details
		//to db via ajax
		function updateUser(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addUserForm'));
			
			var validate_url = $('#updateUserForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: baseurl+'admin/update_user',
				//data: form,
				data: form,
				//data: dataString,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){
					
					if(data.success == true){
						
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$("#userID").val('');
						$("#avatar").val('');
						$('#first_name').val('');
						
						$("#last_name").val('');
						$("#address").val('');
						$("#city").val('');
						$("#postcode").val('');
						$("#state").val('');
						$("#countries").val('');
						$("#telephone").val('');
						$("#fax").val('');
						$("#mobile").val('');
						$("#marital_status").val('');
						$("#occupation").val('');
						$("#dob").val('');
						$("#account_type").val('');
						$("#new_password").val('');
						$("#email").val('');
						$("#currencies").val('');
						$("#username").val('');
						
						$( "#load" ).hide();
						
						$(".notif").html(data.notif);
					
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
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




		//Function to suspend User
		function suspendUser(id, url){
			
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
						//document.updateUserForm.userID.value = data.id;
						$("#user-id").val(data.id);
						
						//document.updateClientForm.avatar.value = data.avatar_name;
						$("#u-name").html(data.fullName);
						//$("#username").val(data.username);
					

					}else{
						alert('false');
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
				
		
								
		//function to submit suspend
		//to db via ajax
		function suspendConfirm(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('suspendForm'));
			
			//alert($('#user-id').val());
			
			var dataString = { 
				userID : $('#user-id').val()
			};		

			var validate_url = $('#suspendForm').attr('action');
			
			$.ajax({
				type: "POST",
				url: validate_url,
				//data: form,
				//data: form,
				data: dataString,
				dataType: "json",
				cache : false,
				//contentType: false,
				//processData: false,
				
				success: function(data){
					
					if(data.success == true){
						$( "#load" ).hide();
						$("#user-id").val('');
						$("#u-name").html('');
						//$("#suspendModal").modal('hide');
						$('#suspendModal').hide();
						$('.modal-backdrop').hide();
						
						//alert('TRUE');
						$(".notif").html(data.notif);
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
						
						
					}else if(data.success == false){
						//alert('FALSE');
						$( "#load" ).hide();
						$(".form-errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}


		//Function to reactivate User
		function reactivateUser(id, url){
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			//$('#reactivateModal').modal('show');
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
						//document.updateUserForm.userID.value = data.id;
						$("#r-user-id").val(data.id);
						
						//document.updateClientForm.avatar.value = data.avatar_name;
						$("#r-u-name").html(data.fullName);
						//$("#username").val(data.username);
					

					}else{
						alert('false');
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		
								
		//function to submit reactivation
		//to db via ajax
		function reactivateConfirm(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('reactivateForm'));
			
			var validate_url = $('#reactivateForm').attr('action');
			
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
						$("#r-u-name").val('');
						$("#r-user-id").html('');
						$( "#load" ).hide();
						//$("#reactivateModal").modal('hide');
						$('#reactivateModal').hide();
						$('.modal-backdrop').hide();
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
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

		
		//Function to Activate User
		//
		function activateUser(id, url){
			
			//CHECK IF EMPTY, DONT PROCEED
			if(id === '' || url === ''){
				$( "#load" ).hide();
				return;
			}	
			
			//$('#reactivateModal').modal('show');
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
						$("#temp-user-id").val(data.id);

						$("#temp-u-name").html(data.fullName);
						
					}else{
						alert('false');
						$( "#load" ).hide();
						$(".error-message").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		
								
		//function to submit activation
		//MOVE USER FROM TEMP USER DB TO ACTIVE USER DB
		function activateConfirm(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('activateForm'));
			
			var validate_url = $('#activateForm').attr('action');
			
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
						//$("#reactivateModal").modal('hide');
						$('#activateModal').hide();
						$('.modal-backdrop').hide();
						
						$("#temp-u-name").val('');
						$("#temp-user-id").html('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".error-message").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}

		
	/*
	**==============END USER FUNCTIONS===============***\\	
	*/ 
	
				

		/*
		**====================START VEHICLE MAKES FUNCTIONS==========***\\\	
		*/ 
		//function to add new VehicleMake
		function addVehicleMake() { 

			var form = new FormData(document.getElementById('addVehicleMakeForm'));
			
			var validate_url = $('#addVehicleMakeForm').attr('action');
			
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
						
						$( "#load" ).hide();
						//$("#addModal").modal('hide');
						$('#addModal').hide();
						$('.modal-backdrop').hide();
						
						$("#code").val('');
						$("#title").val('');
						 
						$(".notif").html(data.notif);
	
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		

		//Function to edit VehicleMake details
		function editVehicleMake(id, url){
			
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
						$("#type_id").val(data.id);
						
						$("#make_code").val(data.code);
						$("#make_title").val(data.title);
								

					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
						$(".form-errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Errors!</div>');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		
				
		//function to submit edited details
		//to db via ajax
		function updateVehicleMake(){
			
			var form = new FormData(document.getElementById('updateVehicleMakeForm'));
			
			var validate_url = $('#updateVehicleMakeForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$("#type_id").val('');
						$('#make_code').val('');
						$("#make_title").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		/*
		**====================END VEHICLE MAKES FUNCTIONS==========***\\\	
		*/ 


		/*
		**====================START VEHICLE MODEL FUNCTIONS==========***\\\	
		*/ 
		//FUNCTION TO ADD NEW VEHICLE MODEL
		function addVehicleModel() { 

			var form = new FormData(document.getElementById('addVehicleModelForm'));
			
			var validate_url = $('#addVehicleModelForm').attr('action');
			
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
						
						$( "#load" ).hide();
						//$("#addModal").modal('hide');
						$('#addModal').hide();
						$('.modal-backdrop').hide();
						
						$("#make_id").val('0');
						$("#code").val('');
						$("#title").val('');
						 
						$(".notif").html(data.notif);
	
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		

		//FUNCTION TO EDIT VEHICLE MODEL DETAILS
		function editVehicleModel(id, url){
			
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
						$("#model_id").val(data.id);
						$("#makeID").html(data.select_make);
						$("#model_code").val(data.code);
						$("#model_title").val(data.title);
								

					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
						$(".form-errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Errors!</div>');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		
				
		//function to submit edited details
		//to db via ajax
		function updateVehicleModel(){
			
			var form = new FormData(document.getElementById('updateVehicleModelForm'));
			
			var validate_url = $('#updateVehicleModelForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$("#model_id").val('');
						
						$("#makeID").val('');
						$('#model_code').val('');
						$("#model_title").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		/*
		**====================END VEHICLE MODEL FUNCTIONS==========***\\\	
		*/ 


		/*
		**====================START VEHICLE TYPE FUNCTIONS==========***\\\	
		*/ 
		//FUNCTION TO ADD NEW VEHICLE TYPE
		function addVehicleType() { 

			var form = new FormData(document.getElementById('addVehicleTypeForm'));
			
			var validate_url = $('#addVehicleTypeForm').attr('action');
			
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
						
						$( "#load" ).hide();
						//$("#addModal").modal('hide');
						$('#addModal').hide();
						$('.modal-backdrop').hide();
						
						$("#vName").val('');
						 
						$(".notif").html(data.notif);
	
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		

		//FUNCTION TO EDIT VEHICLE TYPE DETAILS
		function editVehicleType(id, url){
			
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
						$("#type_id").val(data.id);
						$("#vehicle_name").val(data.name);
								

					}else{
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
						$(".form-errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Errors!</div>');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		
				
		//function to submit edited details
		//to db via ajax
		function updateVehicleType(){
			
			var form = new FormData(document.getElementById('updateVehicleTypeForm'));
			
			var validate_url = $('#updateVehicleTypeForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$("#type_id").val('');

						$('#vehicle_name').val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		/*
		**====================END VEHICLE TYPE FUNCTIONS==========***\\\	
		*/ 
		


		//*****************START ORDER FUNCTIONS*************//	

								
		
		//input
		$(document).ready(function() {
			
			//$(".label_payment_method").hide();
			//$('.payment_method"]').hide();
			
			$('.total_priceOLD').on("change", function(){ //
				//e.preventDefault(); 
				//alert($(this).val());
				var totalPrice = $(this).val();
				var tax = $("#tax").val();
				var shippingFee = $("#shipping_n_handling_fee").val();
				var paymentGross = totalPrice + tax + shippingFee;
				$("#payment_gross").val(paymentGross);
			});
		
			$('#shipping_status,#shippingStatus').on("change", function(){ //
			
				var status = $(this).val();
				
				if(status === '' || status === '0'){
					$(".delivery_date").addClass('hidden');
					$('label[for="estimated_delivery_date"]').addClass('hidden');
					//$(".label_payment_method").hide();
					//$('.payment_method"]').hide();
					return;
				}else{
					$(".delivery_date").removeClass('hidden');
					$('label[for="estimated_delivery_date"]').removeClass('hidden');
					//$(".label_payment_method").show();
					//$('.payment_method"]').show();
				}	
				
			});
			
			
			$('#payment_status,#paymentStatus').on("change", function(){ //
			
				var status = $(this).val();
				
				if(status === '' || status === '0'){
					$(".payment_method").addClass('hidden');
					$('label[for="payment_method"]').addClass('hidden');
					//$(".label_payment_method").hide();
					//$('.payment_method"]').hide();
					return;
				}else{
					$(".payment_method").removeClass('hidden');
					$('label[for="payment_method"]').removeClass('hidden');
					//$(".label_payment_method").show();
					//$('.payment_method"]').show();
				}	
				
			});
		
		});	
		
		
		$(document).ready(function() {
			
			var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Åland Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barthélemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"Côte d’Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"Réunion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"São Tomé and Príncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

			var countriesArray = $.map(countries, function(value, key) {
			  return {
				value: value,
				data: key
			  };
			});

			// initialize autocomplete with custom appendTo
			$('#autocomplete-custom-append').autocomplete({
			  lookup: countriesArray
			});
			
			$('#estimatedDeliveryDate').daterangepicker({
				singleDatePicker: true,
				timePicker: true,
				timePickerIncrement: 30,
				//startDate: "2017-08-16",
				//endDate: "2019-08-16",
				locale: {
					format: 'YYYY-MM-DD h:mm A'
				},
				calender_style: "picker_2"
			});
			
			$('#estimated_delivery_date').daterangepicker({
				autoUpdateInput: false,
				singleDatePicker: true,
				timePicker: true,
				timePickerIncrement: 30,
				//startDate: "2017-08-16",
				//endDate: "2019-08-16",
				locale: {
					format: 'YYYY-MM-DD h:mm A'
				},
				calender_style: "picker_2"
			});/*,function(start, end, label) {
					//console.log(start.toISOString(), end.toISOString(), label);
					console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
			});*/
			$('#estimated_delivery_date').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('YYYY-MM-DD h:mm A'));
			});

			$('#estimated_delivery_date').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
			});
			$('.add_order').on('click', function() {
				$("#payment_status").val('');
				$(".payment_method").addClass('hidden');
				$('label[for="payment_method"]').addClass('hidden');
			});
			
			//*/
      });		
				
		//function to add new Order 
		//via ajax
		function addOrder() { 
		
			$( "#load" ).show();

			var form = new FormData(document.getElementById('addOrderForm'));
			
			var validate_url = $('#addOrderForm').attr('action');
			
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
						$( "#load" ).hide();
						//$("#addOrderModal").modal('hide');
						$('#addOrderModal').hide();
						$('.modal-backdrop').hide();
						
						$("#reference").val('');
						$("#order_description").val('');
						$("#total_price").val('');
						$("#num_of_items").val('');
						$(".customer_email").val('');
						$("#customer_contact_phone").val('');
						$("#shipping_method").val('');
						$("#shipping_fee").val('');
						$("#tax").val('');
						$("#origin_city").val('');
						$("#origin_country").val('');
						$("#destination_city").val('');
						$("#destination_country").val('');
						$("#shipping_status").val('0');
						$("#payment_status").val('0');
						$("#payment_method").val('');
						$("#estimated_delivery_date").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
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
						$("#view-customer").html(data.customer);
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
		
		//ajax function to edit Order details
		//
		function editOrder(id, url){
			
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
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#order_id").val(data.id);
						$("#shipping_id").val(data.shipping_id);
						$("#transaction_id").val(data.transaction_id);
						$("#payment_id").val(data.payment_id);
						
						$("#edit-header").html(data.headerTitle);
						
						$("#ref").val(data.reference);
						$("#orderDescription").val(data.order_description);
						$("#totalPrice").val(data.totalPrice);
						$("#numOfItems").val(data.num_of_items);
						$(".customerEmail").html(data.customer_options);
						 
						$("#customerContactPhone").val(data.customer_contact_phone);
						$("#shippingMethod").html(data.shipping_method_options);
						$("#shippingFee").val(data.shipping_fee);
						$("#tx").val(data.tax);
						$("#originCity").val(data.origin_city);
						$("#originCountry").html(data.origin_country_options);
						$("#destinationCity").val(data.destination_city);
						$("#destinationCountry").html(data.destination_country_options);
						$("#shippingStatus").html(data.shipping_status_options);
						$("#paymentStatus").html(data.payment_status_options);
						
						if(data.edit_shipping_status === '' || data.edit_shipping_status === '0'){
							$(".delivery_date").addClass('hidden');
							$('label[for="estimated_delivery_date"]').addClass('hidden');
							
						}else{
							$(".delivery_date").removeClass('hidden');
							$('label[for="estimated_delivery_date"]').removeClass('hidden');
						}	
				
						if(data.edit_payment_status === '' || data.edit_payment_status === '0'){
							$(".payment_method").addClass('hidden');
							$('label[for="payment_method"]').addClass('hidden');
							
						}else{
							$(".payment_method").removeClass('hidden');
							$('label[for="payment_method"]').removeClass('hidden');
							
						}	
						$("#paymentMethod").html(data.payment_method_options);
						
						
						//alert(data.edit_delivery_date);
						
						//$("#estimatedDeliveryDate").val(data.edit_delivery_date);
						if(data.edit_delivery_date != ''){
							$('#estimatedDeliveryDate').daterangepicker({
								singleDatePicker: true,
								timePicker: true,
								timePickerIncrement: 30,
								startDate: data.edit_delivery_date,
								endDate: data.edit_delivery_date,
								locale: {
									format: 'YYYY-MM-DD h:mm A'
								},//*/
								calender_style: "picker_2"
							});
							$("#estimatedDeliveryDate").val(data.edit_delivery_date);
						}else{
							$("#estimatedDeliveryDate").val('');
						}
						
			
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
		
		//function to submit edited details
		//to db via ajax
		function updateOrder(){
					
			$( "#load" ).show();

			var form = new FormData(document.getElementById('updateOrderForm'));
			
			var validate_url = $('#updateOrderForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$("#order_id").val('');
					
						$("#ref").val('');
						$("#orderDescription").val('');
						$("#totalPrice").val('');
						$("#numOfItems").val('');
						$(".customerEmail").html('');
						 
						$("#customerContactPhone").val('');
						$("#shippingMethod").html('');
						$("#shippingFee").val('');
						$("#tx").val('');
						$("#originCity").val('');
						$("#originCountry").html('');
						$("#destinationCity").val('');
						$("#destinationCountry").html('');
						$("#shippingStatus").html('');
						$("#paymentStatus").html('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}

		//*****************END ORDER FUNCTIONS*************//	



		//*****************START SHIPPING FUNCTIONS*************//		 

		$(document).ready(function() {
			
			//GET EXISTING ORDER 
			//$(document).on('change', '#existing_orders', function() {
			$('#existing_orders').on("change", function(){ //
				//e.preventDefault(); 
				//alert($(this).val());
				
				var existingOrder = $(this).val().trim();
				var order = existingOrder.split("-");
				var ref = order[0];
				var email = order[1];
				
				var dataString = { 
					reference : ref,
					email : email
				};	
				
				$.ajax({
					
					type: "POST",
					url: baseurl+"admin/existing_order_details",
					data: dataString,
					dataType: "json",
					cache : false,
					success: function(data){

						if(data.success == true){
							$( "#load" ).hide();
							$("#reference").val(data.reference);
							$("#destination_city").val(data.destination_city);
							$("#destination_country").val(data.destination_country);
							$("#total_amount").val(data.total_amount);
							$("#customer_email").val(data.customer_email);
						}
					},error: function(xhr, status, error) {
						$( "#load" ).hide();
						alert(error);
					},

				});	
			});
			
			
			
			
		});	

		
		//GET EXISTING ORDER 	
		function getExistingOrder(obj, url){ //
			
			//e.preventDefault(); 
			//alert($(this).val());
			var existingOrder = $(obj).val().trim();
			var order = existingOrder.split("-");
			var ref = order[0];
			var email = order[1];
				
			var dataString = { 
				reference : ref,
				email : email
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
						$("#reference").val(data.reference);
						$("#destination_city").val(data.destination_city);
						$("#destination_country").val(data.destination_country);
						$("#total_amount").val(data.total_amount);
						$("#customer_email").val(data.customer_email);
					}
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});	
		}
		
		
		//GET SHIPPING COST BASED ON SELECTED SHIPPING METHOD
		function getShippingCost(obj, url){ //
				//e.preventDefault(); 
				//alert($(this).val());
				
			var id = $(obj).val();
				
			if(id === ''){
				$(".form_errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a shipping method!</div>')
				return;
			}	
				
			var dataString = { 
				id : id,
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
						//$("#shipping_company").val(data.shipping_company);
						var $elem = $(obj).attr('id');
						if($elem == 'shipping_method'){
							$("#shipping_fee").val(data.shipping_costs);
						}else{
							$("#shippingFee").val(data.shipping_costs);
						}
						
						//$("#shipping_duration").val(data.shipping_duration);
					}
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});	
		}
		
					
		//GET CUSTOMER DETAILS FROM EMAIL
		function getCustomerDetails(obj, url){ //
			
			//e.preventDefault(); 
			//alert($(this).val());
			
			var email = $(obj).val();
			
			if(email === ''){
				$(".form_errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Please select a customer!</div>')
					
				return;
			}	
			
			var dataString = { 
				email : email,
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
						
						var $elem = $(obj).attr('id');
						if($elem == 'customer_email'){
							$("#customer_contact_phone").val(data.telephone);
						}else{
							$("#customerContactPhone").val(data.telephone);
						}
						
						
					}
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});	
		}
		
  		//function to view Shipping details
		function viewShipping(id, url) {
			
			
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
		
		//function to add new Shipping Method 
		//via ajax
		function addShippingMethod() { 

			var form = new FormData(document.getElementById('addShippingMethodForm'));
			
			var validate_url = $('#addShippingMethodForm').attr('action');
			
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
						$( "#load" ).hide();
						//$("#addShippingMethodModal").modal('hide');
						$('#addShippingMethodModal').hide();
						$('.modal-backdrop').hide();
						
						$("#shipping_company").val('');
						$("#shipping_costs").val('');
						$("#shipping_duration").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		

		//ajax function to edit Shipping Method details
		//
		function editShippingMethod(id, url){
			
			
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
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#shipping_method_id").val(data.id);
						
						$("#edit-header").html(data.headerTitle);
						$("#shippingCompany").val(data.shipping_company);
						$("#shippingCosts").val(data.shipping_costs);
						$("#shippingDuration").val(data.shipping_duration);
						
						
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
		
		//function to submit edited details
		//to db via ajax
		function updateShippingMethod(){
			
			var form = new FormData(document.getElementById('updateShippingMethodForm'));
			
			var validate_url = $('#updateShippingMethodForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editShippingMethodModal').hide();
						$('.modal-backdrop').hide();
						
						$("#shipping_method_id").val('');
					
						$("#shippingCompany").val('');
						$("#shippingCosts").val('');
						$("#shippingDuration").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		

		//ajax function to get Shipping details
		//
		function getShippingStatus(id, url){
			
			
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
					
						$("#reference").val(data.reference);
						$("#location").val(data.location);
						$("#customer_email").val(data.customer_email);
						
					}else{
						$( "#load" ).hide();
						$(".form_errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//function to add new Shipping Status 
		//via ajax
		function addShippingStatus() { 

			var form = new FormData(document.getElementById('addShippingStatusForm'));
			
			var validate_url = $('#addShippingStatusForm').attr('action');
			
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
						$( "#load" ).hide();
						//$("#addShippingStatusModal").modal('hide');
						$('#addShippingStatusModal').hide();
						$('.modal-backdrop').hide();
						
						$("#reference").val('');
						$("#status_description").val('');
						$("#location").val('');
						$("#customer_email").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
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
		

				
			
  		//function to view Shipping Status details
		function viewShippingStatus(id) {
			
			if(id === '')
				return;
					
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/shipping_status_main",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();

						$("#viewShippingStatusTitle").html(data.headerTitle);
						
						$("#view-shipping-status-details").html(data.details);
						
					}else{
						$( "#load" ).hide();
						$("#viewShippingStatusTitle").html('Errors!');
					} 	 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});					
		}

		//ajax function to edit Shipping Status details
		//
		function editShippingStatus(id){
			$( "#load" ).show();

			var dataString = { 
				id : id
			};				
			$.ajax({
				
				type: "POST",
				url: baseurl+"admin/shipping_status_main",
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){

					if(data.success == true){
						$( "#load" ).hide();
					
						//populate the hidden fields
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#shipping_status_id").val(data.id);
						
						$("#edit-header").html(data.headerTitle);
						$("#ref").val(data.order_reference);
						$("#statusDescription").val(data.status_description);
						$("#locatn").val(data.location);
						$("#customerEmail").val(data.customer_email);
						
					}else{
						$( "#load" ).hide();
						$(".form_errors").html('Errors!');
					} 	 
	  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});								
		}
		
		//function to submit edited details
		//to db via ajax
		function updateShippingStatus(){
			
			var form = new FormData(document.getElementById('updateShippingStatusForm'));
			
			var validate_url = $('#updateShippingStatusForm').attr('action');
			
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
						//$("#editShippingStatusModal").modal('hide');
						$('#editShippingStatusModal').hide();
						$('.modal-backdrop').hide();
						
						$("#shipping_status_id").val('');
					
						$("#ref").val('');
						$("#statusDescription").val('');
						$("#locatn").val('');
						$("#customerEmail").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		//*****************END SHIPPING FUNCTIONS*************//		
			

						
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
		
		
		//*****************PAYMENT METHOD FUNCTIONS*************//		
		//function to add new PAYMENT METHOD 
		//via ajax
		function addPaymentMethod() { 

			var form = new FormData(document.getElementById('addPaymentMethodForm'));
			
			var validate_url = $('#addPaymentMethodForm').attr('action');
			
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
						$( "#load" ).hide();
						//$("#addPaymentMethodModal").modal('hide');
						$('#addPaymentMethodModal').hide();
						$('.modal-backdrop').hide();
						
						$("#method_name").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		

		//ajax function to edit Payment Method details
		//
		function editPaymentMethod(id, url){
			
			
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
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#methodID").val(data.id);
						
						$("#method").html(data.headerTitle);
						$("#methodName").val(data.method_name);
						
						
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
		
		//function to submit edited details
		//to db via ajax
		function updatePaymentMethod(){
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updatePaymentMethodForm'));
			
			var validate_url = $('#updatePaymentMethodForm').attr('action');
			
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
						//$("#editPaymentMethodModal").modal('hide');
						$('#editPaymentMethodModal').hide();
						$('.modal-backdrop').hide();
						
						$("#methodID").val('');
					
						$("#methodName").val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		/*
		**====================END PAYMENT METHOD FUNCTIONS==========***\\\	
		*/ 
		

		/*
		**==============START SECURITY QUESTION FUNCTIONS===============***\\	
		*/ 	
		//function to handle add security question
		function addSecurityQuestion() { 
		
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('addQuestionForm'));

			var validate_url = $('#addQuestionForm').attr('action');
			
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

					$("#question").val('');
					
					if(data.success == true){
						
						//$("#addQuestionModal").modal('hide');
						$("#addQuestionModal").hide();
						$('.modal-backdrop').hide();
						
						$( "#load" ).hide();
						//window.location.reload(true);		  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);

					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					//alert(error);
					//location.reload();
				},
			});
			return false;
		}	

		
		//FUNCTION TO EDIT SECURITY QUESTION DETAILS
		function editSecurityQuestion(id, url){
			
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
				url: baseurl+''+url,
				data: dataString,
				dataType: "json",
				cache : false,
				success: function(data){
					
					if(data.success == true){
						
						$( "#load" ).hide();
						
						//populate the hidden fields
						$("#questionID").val(data.id);
						
						$("#questn").val(data.question);
								

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
		
				
		//function to submit edited details
		//to db via ajax
		function updateSecurityQuestion() { 
			
			$( "#load" ).show();
			
			var form = new FormData(document.getElementById('updateSecurityQuestionForm'));
			
			$.ajax({
				type: "POST",
				url: baseurl+"admin/update_security_question",
				data: form,
				//data: formData,
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					$("#questionID").val('');
					$("#questn").val('');
					
					if(data.success == true){
						
						//$("#editModal").modal('hide');
						$("#editSecurityQuestionModal").hide();
						$('.modal-backdrop').hide();
						
						$( "#load" ).hide();
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000);

					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
		
		}	
		/*
		**==============END SECURITY QUESTION FUNCTIONS===============***\\	
		*/ 

		
		
		//*****************START PAGE METADATA FUNCTIONS*************//	
		 		
  		//function to view Page Metadata details
		function viewPageMetadata(id, url) {
			
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
						
						$("#view-page").html(data.page);
						$("#view-keywords").html(data.keywords);
						$("#view-description").html(data.description);
						
						
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
		
		//function to add new Page Metadata
		//via ajax
		function addPageMetadata() { 

			var form = new FormData(document.getElementById('addMetadataForm'));
			
			var validate_url = $('#addMetadataForm').attr('action');
			
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
						$( "#load" ).hide();
						//$("#addMetadataModal").modal('hide');
						$('#addMetadataModal').hide();
						$('.modal-backdrop').hide();
						
						$("#page").val('');
						$("#keywords").val('');
						$("#description").val('');
							  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 
						//window.location.reload(true);

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}
		
		//ajax function to edit Page Metadata details
		//
		function editPageMetadata(id, url){
			
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
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#page_metadata_id").val(data.id);
						
						$("#edit-header").html(data.headerTitle);
						$("#u-page").val(data.page);
						$("#u-keywords").val(data.keywords);
						
						$("#u-description").val(data.description);
						
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
		
		//function to submit edited details
		//to db via ajax
		function updatePageMetadata(){
			
			var form = new FormData(document.getElementById('updateMetadataForm'));
			
			//get text from wysi editor
			//var editor = $("#metadata-description").html();
			
			//insert into hidden textarea 
			//$("#u-description").val(editor);
			
			var validate_url = $('#updateMetadataForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$('#editModal').hide();
						$('.modal-backdrop').hide();
						
						$('#u-page').val('');
						$('#u-keywords').val('');
						$('#u-description').val('');
						$("#page_metadata_id").val('');

						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$("#notif").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		//*****************END PAGE METADATA FUNCTIONS*************//		
			
	

		/*
		**====================START COLOUR FUNCTIONS==========***\\\	
		*/ 
		//FUNCTION TO ADD NEW COLOUR
		function addColour() { 

			var form = new FormData(document.getElementById('addColourForm'));
			
			var validate_url = $('#addColourForm').attr('action');
			
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
						
						$( "#load" ).hide();
						//$("#addColourModal").modal('hide');
						$("#addColourModal").hide();
						$('.modal-backdrop').hide();
						
						$("#cName").val('');
						 
						$(".notif").html(data.notif);
	
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 2000); 

					}else if(data.success == false){
						$( "#load" ).hide();
						$("#alert-msg").html(data.notif);
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
				},
			});
			return false;
		}	
		

		//FUNCTION TO EDIT COLOUR DETAILS
		function editColour(id, url){
			
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
						$("#colourID").val(data.id);
						
						$("#colour_name").val(data.colour_name);
								

					}else{
						$( "#load" ).hide();
						
						$(".form-errors").html('<div class="alert alert-danger text-center" role="alert"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Errors!</div>');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		
				
		//function to submit edited details
		//to db via ajax
		function updateColour(){
			
			var form = new FormData(document.getElementById('updateColourForm'));
			
			var validate_url = $('#updateColourForm').attr('action');
			
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
						
						//$("#editColourModal").modal('hide');
						$("#editColourModal").hide();
						$('.modal-backdrop').hide();
						
						$("#colourID").val('');

						$('#colour_name').val('');
						
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
	
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}
		
		/*
		**====================END COLOUR FUNCTIONS==========***\\\	
		*/ 
				
							
		/*
		**==============START KEYWORDS FUNCTIONS===============***\\	
		*/ 
		
		//function to add new keyword
		//via ajax
		function addKeyword() { 

			var form = new FormData(document.getElementById('addKeywordForm'));
			
			var validate_url = $('#addKeywordForm').attr('action');
			
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
						$( "#load" ).hide();
						//$("#addKeywordModal").modal('hide');
						$("#addKeywordModal").hide();
						$('.modal-backdrop').hide();
						
						$("#keywd").val('');
						$("#icon").val('');
							  
						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
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
		
		//ajax function to edit Keyword details
		//
		function editKeyword(id, url){
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
						//document.updateKeywordForm.keyword_id.value = data.id;
						$("#keyword_id").val(data.id);
						
						$("#header").html(data.headerTitle);
						$("#keyword").val(data.keyword);
						$("#keyword_icon").val(data.icon);
						
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
		
		//function to submit edited details
		//to db via ajax
		function updateKeyword(){
			
			var form = new FormData(document.getElementById('updateKeywordForm'));
			
			//var form = $('#updateKeywordForm').get(0);
			
			var validate_url = $('#updateKeywordForm').attr('action');
			
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
						//$("#editModal").modal('hide');
						$("#editModal").hide();
						$('.modal-backdrop').hide();
						
						$('#keyword').val('');
						$('#keyword_icon').val('');
						$("#keyword_id").val('');

						$(".notif").html(data.notif);
						
						setTimeout(function() { 
							$(".notif").slideUp({ opacity: "hide" }, "slow");
							
							window.location.reload(true);
						}, 5000);
						
					}else if(data.success == false){
						$( "#load" ).hide();
						$(".form_errors").html(data.notif);
						
					}
						
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},
			});
						
		}		
		/*
		**==============END KEYWORDS FUNCTIONS=================***\\	
		*/ 
			
			
	/*
		**	START CONTACT US MESSAGE FUNCTIONS	
		*/ 
		
		//view contact us message
		function viewContactMessage(id, url){
			
			if(id === '' || url === ''){
				return;
			}
				
			
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
						$("#contact_name").html(data.contact_name);
						$("#contact_telephone").html(data.contact_telephone);
						$("#contact_email").html(data.contact_email);
						$("#contact_company").html(data.contact_company);
						$("#contact_message").html(data.contact_message);
						$("#ip_address").html(data.ip_address);
						$("#opened").html(data.opened);
						$("#contact_us_date").html(data.contact_us_date);				

					}else{
						alert('false');
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		/*
		**	END CONTACT US MESSAGE FUNCTIONS	
		*/ 
			
		
		//VIEW REVIEW
		function viewReview(id, url){
			
			if(id === '' || url === ''){
				return;
			}
				
			
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
						$("#reviewed_seller").html(data.seller);
						
						$("#review_date").html(data.review_date);				

					}else{
						alert('false');
						$( "#load" ).hide();
						$("#headerTitle").html('Errors!');
					} 
						  
				},error: function(xhr, status, error) {
					$( "#load" ).hide();
					alert(error);
				},

			});
		}
		/*
		**	END REVIEW FUNCTIONS	
		*/ 
						
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

		
	
		//function to handle multi delete
		function multiDeleteRecord(obj) { 
			
			$( "#load" ).show();
			
			var htmlForm = $(obj).closest('form');
			
			var form_id = htmlForm.attr('id');
			
			//var form = new FormData(form_id);
			//var form = $(form_id).get(0);
			
			//var formUrl = htmlForm.attr('action');
			var formUrl = $('#'+form_id).attr('action');
			//var form_id = htmlForm.attr('id');
			
			var form = new FormData($('#'+form_id).get(0));

			/*
			var checkboxes = htmlForm.find('[name="cb[]"]');
			var model = htmlForm.find('[name=model]').val();
			
			var dataString = { 
				'cb[]' : [],
				model : model,
			};	
			
			var ids = [];
			
			checkboxes.each(function () {
				if ($(this).is(":checked")) {
					dataString['cb[]'].push($(this).val());
				}
			});
			*/
			
			//alert('URL: '+formUrl+', ID: '+ids+', Model: '+model);
			
			$.ajax({
				type: "POST",
				url: formUrl,
				//data: dataString,
				data: form,
				dataType: "json",
				cache : false,
				contentType: false,
				processData: false,
				
				success: function(data){

					if(data.success == true){
						
						var modal = $(obj).closest('.modal');
			
						var modal_id = modal.attr('id');
						
						//$(modal_id).modal('hide');
						$('#'+modal_id).hide();
						$('.modal-backdrop').hide();
						
						
						$(".notif").html(data.notif);
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						  
						
						
						
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
			//*/
		}
		
	
		//function to handle multi delete
		function multiToggleDelete(obj) { 
			
			$( "#load" ).show();
			
			var htmlForm = $(obj).closest('form');
			
			//alert(htmlForm);
			
			var form_id = htmlForm.attr('id');
			
			//alert(form_id);
			
			var form = new FormData($('#'+form_id).get(0));

			var form_url = $('#'+form_id).attr('action');
			
			//alert(form_url);
			//var form = new FormData($('#multi_delete_form').get(0));

			//var form_url = $('#multi_delete_form').attr('action');
			
			
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
						$('.modal').hide();
						$('.modal-backdrop').hide();
						
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
							
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
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
						
						$(".notif").html(data.notif);
						setTimeout(function() { 
							//$("#alert-msg").hide(600);
							$('.notif').slideUp({ opacity: "hide" }, "slow");
							window.location.reload(true);
						}, 5000);
						
						
						
						$("#messageDeleteModal").modal('hide');  
						$('#messageDeleteModal').hide();
						$('.modal-backdrop').hide();
						
						
						
						//remove deleted rows dynamically
						$('table tr').has('input[name="cb[]"]:checked').remove();
						
						
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
	
			
		/*
		**==============END DELETE FUNCTIONS=================***\\	
		*/ 
		