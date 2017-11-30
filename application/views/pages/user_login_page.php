	
	<!-- .section .fade .section-background -->
	<div class="section fade section-background">
	
		<!-- .row .container-medium -->
		<div class="row container-large">
			
			<div class="">
				
				<div class="row">
					<div class="col-md-4 col-md-offset-1 col-sm-5 ">
						<div class="card">
							<div class="card-content">
								<h4 class="teal-text text-lighten-2 text-center"><i class="fa fa-user-plus" aria-hidden="true"></i> REGISTER</h4>
								<br/>
								
								<p>By creating an account you will be able to receive and send direct messages, manage, track and be up to date on all your orders.</p>
								<br/>
								<p class="text-center"><a href="javascript:void(0);" onclick="location.href='<?php echo base_url('signup');?>'" title="REGISTER" class="btn btn-primary">REGISTER</a></p>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-sm-6 ">
						<div class="card">
						
							<div class="card-content form-content">
							
								
								<div class="row">
									<div class="col s12">
										<h4 class="teal-text text-lighten-2 text-center"><i class="fa fa-sign-in" aria-hidden="true"></i> LOGIN</h4>
									</div>
								</div>
								
								<br/>
								
								<div class="row">
									<div class="col s12">
										<p>Login to see your alerts, manage new and previous orders.</p>
									</div>
								</div>
								
								<?php
									$login_form = array(
										'name' => 'login_form',
										'id' => 'login_form',
									);
									echo form_open('login/validation',$login_form);
									echo validation_errors();
								?>
								<div id="notif"></div>
								
								<div class="row">
									<div class="input-field col s12">
										<i class="material-icons prefix">account_circle</i>
										<input type="email" name="email" id="login-email" value="<?php echo set_value('email');?>" title="Please enter your email address" class="validate">
										<label for="email">Enter your email address</label>
									</div>
								</div>
								
								<div class="row">
									<div class="input-field col s12">
										<i class="material-icons prefix">lock</i>
										<input type="password" name="password" id="upass" value="<?php echo set_value('password');?>" class="validate">
										<label for="password">Enter your password</label>
										<span class="show-password-wrap">
											<a  class="teal-text text-lighten-2 show-password" href="#">Show</a>
										</span>
									</div>
								</div>
										
								<div class="row">
									<div class="input-field col s12">
										<button type="submit" class="btn btn-primary" >LOGIN<i class="material-icons right">send</i>
										</button>
									</div>
								</div>
								
								<?php	
									echo form_close();
								?>	

								<br/>
								
								<div class="row">
									<div class="col s12">
										<p>Forgot your password? No worries, click <strong><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('forgot-password');?>'">here</a></strong> to reset your password.<p>
									</div>
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.fade /.section-background -->
	

		
		
		