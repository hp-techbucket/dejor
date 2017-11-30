
	
	<!-- .section .fade .section-background -->
	<div class="section fade section-background">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
			
				<div class="card">
				
					<div class="card-content form-content">
					
						<h4 class="teal-text text-lighten-2 text-center"><i class="fa fa-user-plus" aria-hidden="true"></i> SIGNUP</h4>
								<br/>
						
						<div id="signup-form">		
						
							<p>By creating an account you will be able to receive and send direct messages, manage, track and be up to date on all your orders.</p>
						
							<br/>
							
							<p>If you already have an account with us, please login at the <strong><a href="javascript:void(0);" onclick="location.href='<?php echo base_url('login');?>'">login page</a></strong>.<p>
							
							<br/>
		
							<?php
								$signup_form = array('name' => 'signup_form','id' => 'signup_form',);
								echo form_open('signup/validation',$signup_form);
							?>
							<div id="notif"></div>
							
							<div class="row">
								<div class="form-group input-field col m6 s12">
									<i class="material-icons prefix">account_circle</i>
									<input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name');?>" title="Please enter your first name" class="validate">
									<label for="first_name">First Name</label>
								</div>
								
								<div class="form-group input-field col m6 s12">
									<i class="material-icons prefix">account_circle</i>
									<input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name');?>" title="Please enter your last name" class="validate">
									<label for="last_name">Last Name</label>
								</div>
							</div>
							
							
							
							<div class="row">
								<div class="form-group input-field col m6 s12">
									<i class="material-icons prefix">email</i>
									<input type="email" name="email_address" id="email_address" value="<?php echo set_value('email_address');?>" title="Please enter your email address" class="validate">
									<label for="email_address">Email Address</label>
								</div>
								
								<div class="form-group input-field col m6 s12">
									<i class="material-icons prefix">phone</i>
									<input type="tel" name="telephone" id="telephone" value="<?php echo set_value('telephone');?>" title="Please enter your telephone number" class="validate">
									<label for="telephone">Telephone</label>
								</div>
							</div>
							
							
							<div class="row">
								<div class="form-group input-field col m6 s12">
									<i class="material-icons prefix">lock</i>
									<input type="password" name="password" id="password" value="<?php echo set_value('password');?>" title="Please enter a password" class="validate togglePassword">
									<label for="password">Password</label>
									<span class="show-password-wrap">
										<a class="teal-text text-lighten-2" href="#" onclick="togglePassword(this, event);">Show</a>
									</span>
								</div>
								
								<div class="form-group input-field col m6 s12">
									<i class="material-icons prefix">lock</i>
									<input type="password" name="confirm_password" id="confirm_password" value="<?php echo set_value('confirm_password');?>" title="Please re-enter the password" class="validate togglePassword">
									<label for="confirm_password">Password Confirm</label>
									<span class="show-password-wrap">
										<a class="teal-text text-lighten-2" href="#" onclick="togglePassword(this, event);">Show</a>
									</span>
								</div>
							</div>
							
							<div class="row">
								<div class="input-field col s12">
									<button type="submit" class="btn btn-primary btn-block" >CREATE ACCOUNT</button>
								</div>
							</div>
							
							<?php	
								echo form_close();
							?>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.fade /.section-background -->
	
		
		
		
		
		
		
		