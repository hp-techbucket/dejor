/* Start of file bootstrapFormValidator.js */			
		
		//Contact us message form 
		//bootstrap validator	
		 $(document).ready(function() {
			
			
			//////******************CONTACT US FORM*************////////
			$('.contact_us_form').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					contact_us_name: {
						validators: {
							notEmpty: {
								message: 'Please enter your full name!'
							}
						}
					},
					contact_us_telephone: {
						validators: {
							notEmpty: {
								message: 'Please enter your telephone number!'
							}
						}
					},
					contact_us_email: {
						validators: {
							notEmpty: {
								message: 'Please enter your email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address!'
							}
						}
					},
					contact_us_message: {
						validators: {
							stringLength: {
								min: 10,
								max: 120,
								message:'Please enter at least 10 characters and no more than 120'
							},
							notEmpty: {
								message: 'Please enter your message!'
							}
						}
					}
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$(".contact_us_form").data('bootstrapValidator').resetForm();
					contactUsMessage();
				}
			});
			//////******************CONTACT US FORM*************////////
			
			
			//////******************PASSWORD RESET FORM*************////////
									
			$('#reset_form').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					}
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#reset_form").data('bootstrapValidator').resetForm();
					forgotPassword();
				}
			});
			
			//////******************PASSWORD RESET FORM*************////////
					
			
			
			//////******************LOGIN FORM*************////////		
			$('#login_form2').bootstrapValidator({
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					},
					password: {
						validators: {
							
							notEmpty: {
								message: 'Please enter a password!'
							}
						}
					}
					
				}/*,
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#login_form").data('bootstrapValidator').resetForm();
					customerLogin();
				}*/
			});
			//////******************LOGIN FORM*************////////	
			
			
			//////******************SIGNUP FORM*************////////	
			$('#signup_form').bootstrapValidator({
				
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					first_name: {
						validators: {
							notEmpty: {
								message: 'Please enter a first name!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					last_name: {
						validators: {
							notEmpty: {
								message: 'Please enter a last name!'
							},
							placeholder: {
								message: 'The value cannot be the same as placeholder'
							}
						}
					},
					email_address: {
						validators: {
							notEmpty: {
								message: 'Please enter an email address!'
							},
							emailAddress: {
								message: 'Please enter a valid email address'
							}
						}
					},
					telephone: {
						validators: {
							notEmpty: {
								message: 'Please enter a telephone number!'
							}
						}
					},
					password: {
						validators: {
							
							notEmpty: {
								message: 'Please enter a password!'
							}
						}
					},
					confirm_password: {
						validators: {
							notEmpty: {
								message: 'Please confirm your password'
							},
							identical: {
								field: 'password',
								message: 'Passwords do not match'
							}
						}
					}
					
				},
				submitHandler: function(validator, form, submitButton) {
					//alert('Testing');
					$("#signup_form").data('bootstrapValidator').resetForm();
					//form.data('bootstrapValidator').resetForm();
					userSignup();
					//$("#signup_form").submit();
					
				}
			});
			//////******************SIGNUP FORM*************////////
			
			
		});
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
/* End of file bootstrapFormValidator.js */		
		