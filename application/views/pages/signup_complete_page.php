
	
	<!-- .section .fade .section-background -->
	<div class="section fade section-background">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			
			<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
			
				<div class="card">
				
					<div class="card-content form-content">
					
						<h4 class="teal-text text-lighten-2 text-center"><i class="fa fa-user-plus" aria-hidden="true"></i> SIGNUP COMPLETE</h4>
								<br/>
						<?php 
							$message = '';
							if($this->session->flashdata('signup') != ''){
								$message = $this->session->flashdata('signup');
							}
							echo $message; 
						
						?>	
						<div class="alert alert-success text-center" role="alert"> 
							<h5 class="text-success text-center"><i class="fa fa-check-circle"></i> Signup Success</h5>
							<br/>
							<p>Thank you for signing up. Your account will be activated shortly by our staff upon complete review.</p>
						</div>						
					</div>
				</div>
			</div>
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.fade /.section-background -->
	
		
		
		
		
		
		
		