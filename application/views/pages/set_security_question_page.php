

	
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
						
						<p align="center">Please set your account security question and answer below:</p>
						<br/>
						
						<?php 
							$atts = array(
								'class' => 'form-horizontal form-label-left input_mask', 
								'id'=>'set_security_form',
								
							);
													
							//start form
							echo form_open('account/security_update',$atts);
												
						?>	
							
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Security Question</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<select name="security_question" class="form-control select2" id="security_question" >
									<option value="" >Please Select a Question</option>
									<?php echo $select_security_questions ; ?>
									
								</select>
											
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Security Answer</label>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<input type="password" class="form-control" id="security_answer" name="security_answer">
								<span class="show-password-wrap">
									<a  class="teal-text text-lighten-2 show-answer" href="#">Show</a>
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-7 col-md-offset-3 col-sm-7  col-sm-offset-3 col-xs-12">
								<button type="button" class="btn btn-success" onclick="javascript:updateSecurity();">Submit</button>
							</div>
						</div>
												
											
							<?php 
								echo form_close();
							?>	
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
		
		<div class="container-medium">
			
			<div class="parallax-caption">
			
			</div>
		
		</div>
	</div>
	<!-- /.parallax-container -->
		
		
		
		
		
		
		

