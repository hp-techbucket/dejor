	
	
	<!-- .section .fade .section-background -->
	<div class="section fade section-background">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
		
			<div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
			
				<div class="card">
				
					<div class="card-content form-content">
					
						
						<div id="notif"></div>
						
						<h5 class="teal-text text-lighten-2 text-center"><i class="fa fa-lock" aria-hidden="true"></i> FORGOT YOUR PASSWORD?</h5>
						
						
					
	<div class="row">	
						<!-- .wizard -->
						<div class="wizard">
						
							<!-- .wizard-inner -->
							<div class="wizard-inner">
								<div class="connecting-line"></div>
								
								<!-- .nav nav-tabs -->
								<ul class="nav nav-tabs" role="tablist">

									<li role="presentation" class="active">
										<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
											<span class="round-tab">
												<i class="fa fa-user" aria-hidden="true"></i>
											</span>
										</a>
									</li>

									<li role="presentation" class="disabled">
										<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
											<span class="round-tab">
												<i class="fa fa-lock" aria-hidden="true"></i>
											</span>
										</a>
									</li>
									<li role="presentation" class="disabled">
										<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
											<span class="round-tab">
												<i class="glyphicon glyphicon-pencil"></i>
											</span>
										</a>
									</li>
									<li role="presentation" class="disabled">
										<a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
											<span class="round-tab">
												<i class="glyphicon glyphicon-ok"></i>
											</span>
										</a>
									</li>
								</ul>
								<!-- /.nav nav-tabs -->
								
							</div>
							<!-- /.wizard-inner -->
							
						<?php
							$reset_form = array(
								'name' => 'forgotPasswordForm',
								'id' => 'forgotPasswordForm',
								//'autocomplete'=>'off'
							);
							echo form_open('forgot-password/validation',$reset_form);
							$hidden = array(
								'validate_email' => 'main/validate_email',
								'validate_answer' => 'main/validate_security_answer',
							);	
							echo form_hidden($hidden);
						?>
						
							<!-- .tab-content -->
							<div class="tab-content">
							
								<!-- #step1 -->
								<div class="tab-pane active" role="tabpanel" id="step1">

									<h5 class="text-center">Step 1</h5>
									
									<br/>
									
									<p id="email-error"></p>
									
									<p>Enter the e-mail address associated with your account and click continue to reset your password.</p>
									
									<br/>
									
									<div class="row">
										<div class="form-group input-field col s12">
											<i class="material-icons prefix">email</i>
											<input type="email" name="email" id="fp-email" value="<?php echo set_value('email');?>" title="Please enter your registered email address" class="validate">
											<label for="email">Enter your registered email address</label>
											
										</div>
									</div>
									<ul class="list-inline pull-right">
										<li>
											<button type="button" class="btn waves-effect waves-light white-text"  onclick="validateEmail()"> Next <i class="material-icons right">chevron_right</i></i>
											</button>
											
											
											<button type="button" class="next-step hidden" >Next</button>
										</li>
									</ul>
									
								</div>
								<!-- /#step1 -->
								
								<!-- #step2 -->
								<div class="tab-pane" role="tabpanel" id="step2">
									
									<h5 class="text-center">Step 2</h5>		
									
									<br/>
									
									<p id="error-message"></p>
									
									<p id="security-question"></p>
									
									<br/>
									
									<div class="row">
										<div class="form-group input-field col s12">
											<i class="material-icons prefix">question_answer</i>
											<input type="text" name="security_answer" id="fp-security-answer" value="<?php echo set_value('security_answer');?>" title="Enter Your Security Answer" class="validate">
											<label for="security_answer">Enter Your Answer</label>
											<input type="hidden" name="question" id="fp-security-question" >
										</div>
									</div>	

									<ul class="list-inline pull-right">
										<li>
											<button type="button" class="btn waves-effect waves-light  blue-grey darken-4 white-text prev-step">
												<i class="material-icons left">chevron_left</i> 
												Previous
											</button>
											
											<button type="button" class="btn waves-effect waves-light white-text" onclick="validateAnswer()"> Next 
												<i class="material-icons right">chevron_right</i>
											</button>
										</li>
									</ul>
								</div>
								<!-- /#step2 -->
								
								<!-- #step3 -->
								<div class="tab-pane" role="tabpanel" id="step3">
									
									<h5 class="text-center">Step 3</h5>
									
									<br/>
									
									<p id="password_error"></p>
									
									<p><strong>You can set a new password below: </strong></p>
									
									<br/>
									
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">lock</i>
											<input type="password" name="password" id="fp-password" class="validate togglePassword">
											<label for="password">Enter New Password</label>
											<span class="show-password-wrap">
												<a class="teal-text text-lighten-2" href="#" onclick="togglePassword(this, event);">Show</a>
											</span>
										</div>
									</div>
																	
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">lock</i>
											<input type="password" name="confirm_password" id="fp-confirm-password" class="validate togglePassword">
											<label for="confirm_password">Confirm New Password</label>
											<span class="show-password-wrap">
												<a class="teal-text text-lighten-2" href="#" onclick="togglePassword(this, event);">Show</a>
											</span>
										</div>
									</div>
								
								
									<ul class="list-inline pull-right">
										<li>
											<button type="button" class="btn waves-effect waves-light blue-grey darken-4 white-text prev-step">
												<i class="material-icons left">chevron_left</i> Previous
											</button>
										</li>
										<li>
											<button type="button" class="btn waves-effect waves-light white-text" onclick="newPassword()">Update
												<i class="material-icons right">chevron_right</i> 
											</button>
										</li>
										<li><button type="button" class="btn btn-primary next-step-btn hidden"></button></li>
									</ul>
								</div>
								<!-- /#step3 -->
								
								<!-- #complete -->
								<div class="tab-pane" role="tabpanel" id="complete">
								
									<h5 class="text-center">Complete</h5>
									
									<br/>
									
									<p id="complete-message"></p>
								</div>
								<!-- /#complete -->
								<div class="clearfix"></div>
								
							</div>
							<!-- /.tab-content -->
							
						<?php	
							echo form_close();
						?>		
						</div>
						<!-- /.wizard -->
					</div>
					
					</div>
				</div>
			</div>		
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.fade /.section-background -->
	
	