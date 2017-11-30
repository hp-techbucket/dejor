

	
	<!-- .section .grey darken-3 -->
	<div class="section grey darken-3 fade">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			<div class="col-md-8 col-md-offset-2">
				<div class="card">
						
					<div class="card-content">
						<div id="response-message">	
						<?php 
							$message = '';
							if($this->session->flashdata('updated') != ''){
							$message = $this->session->flashdata('updated');
							}	
							echo $message;	
							echo validation_errors();	
										
						?>	
						</div>	
						
					</div>
				</div>
			</div>
							
					
					
							
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.white -->
	
	
	<!-- .parallax-container -->
	<div class="parallax-container parallax-container-custom fade">
		
		<div class="parallax-overlay"></div>
		
		<!-- .parallax -->
		<div class="parallax">
			<img src="<?php echo base_url('assets/images/banners/IMG_115975.jpg');?>">
			
		</div>
		<!-- /.parallax -->
		
	</div>
	<!-- /.parallax-container -->
		
		
		
		
		
		
		

