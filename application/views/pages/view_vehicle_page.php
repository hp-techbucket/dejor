
	
<!-- .section .white -->
<div class="section white">

	<!-- .container-fluid -->
	<div class="container">
	
		<!-- .row -->
		<div class="row">
			
			<div class="col-md-6 col-xs-12">
				<div class="product-image">
					<?php echo $image; ?>
				</div>
			</div>
			
			<div class="col-md-2 col-xs-12 gallery-container">
				<div class="">
					<?php echo $image_gallery; ?>	
				</div>
			</div>
			
			<div class="col-md-4 col-xs-12">
				
				<h3 class="product-title"><?php echo html_escape($pageTitle);?></h3>
				
				<div class="product-price">
					<?php echo $price;?>	
					
				</div>
				
				<p><strong><i class="fa fa-taxi" aria-hidden="true"></i></strong> <?php echo $vehicle_type; ?></p>
							  
				<p><i class="fa fa-calendar" aria-hidden="true"></i></strong> <?php echo $year_of_manufacture; ?></p>
							  
				<?php echo $colour;?>
				
				<br/>
				
				<hr/>
				
				<br/>
				
				<div class="reviews">
					
					<a onclick="scrollToTab(this)" href="#tab3">
						<?php echo $rating_box; ?>
					</a>
				</div>
				
				<br/>
				
				<p><a href="#!" class="link" onclick="location.href='<?php echo base_url();?>store/<?php echo url_title(strtolower($fullname.' '.$company_name));?>/<?php echo $user_id;?>/<?php echo md5(uniqid()); ?>'" title="View"><strong>Seller <span class="glyphicon glyphicon-user"></span></strong> <?php echo $fullname.' '.$company_name; ?></a></p>
							
				<p><strong><i class="fa fa-thumb-tack" aria-hidden="true"></i></strong> <?php echo $vehicle_location_city .', '.$vehicle_location_country; ?></p>
							    
				<div class="">
					<a class="btn waves-effect waves-light white-text" onclick="scrollToTab(this)" href="#tab2"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact Seller</a>
				</div>
				<?php echo br(6); ?>
			</div>
		</div>
		<!-- /.row -->
		
		<hr/>
				
		<!-- .container details-container -->
		<div class="container-fluid">
		
			<!-- .row -->
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
				
					<!-- .nav nav-pills -->
					<ul class="nav nav-pills">
						<li class="active"><a data-toggle="pill" href="#tab1">DESCRIPTION </a></li>
						<li><a data-toggle="pill" href="#tab2" >SEND ENQUIRY </a></li>
						<li><a data-toggle="pill" href="#tab3">CUSTOMER REVIEWS</a></li>
					</ul>
					<!-- /.nav nav-pills -->
				
					<!-- .tab-content -->	  
					<div class="tab-content">
					
						
						<!-- #tab1 -->
						<div id="tab1" class="tab-pane fade in active">
							 
				
							  <p><?php echo $vehicle_description; ?></p>
						</div>
						<!-- /#tab1 -->
						
						<!-- #tab2 -->
						<div id="tab2" class="tab-pane fade">
							 
							<div id="enquiry-form">
							
								<div class="notif"></div>	
								
							<?php
								$attrs = array('class' => 'enquiry_form form_horizontal', 'id' => 'enquiry_form', 'name' => 'enquiry_form', 'role' => 'form');
								echo form_open('main/submit_enquiry', $attrs);
							?>
								
								<div class="row">	
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h4>Contact Seller</h4>
									</div>
								</div>	
								
								<div class="row">
									<div class="form-group input-field col m4 s12">
										<i class="material-icons prefix">person</i>
										<input type="text" name="customer_name" id="customer_name" value="<?php echo set_value('customer_name');?>" title="Please enter your name" class="validate">
										<label for="customer_name">Enter your name</label>
									</div>
											
									<div class="form-group input-field col m4 s12">
										<i class="material-icons prefix">email</i>
										<input type="text" name="customer_email" id="customer_email" value="<?php echo set_value('customer_email');?>" title="Please enter your email address" class="validate">
										<label for="customer_email">Enter your email address</label>
									</div>
								</div>
								
								<div class="row">
									<div class="form-group input-field col m4 s12">
										<i class="material-icons prefix">phone</i>
										<input type="text" name="customer_telephone" id="customer_telephone" value="<?php echo set_value('customer_telephone');?>" title="Please enter your telephone number" class="validate">
										<label for="customer_telephone">Enter your telephone number</label>
									</div>
											
									<div class="col m4 s12">
										<label for="">Preferred method of communication?</label>
											
										<div class="checkbox">
											<input type="checkbox" name="contact_method[]" value="Phone" id="phone_method">
															
											<label class="checkbox_label" for="phone_method">Phone</label>
											<?php echo nbs(5); ?>
												
											<input type="checkbox" name="contact_method[]" value="Email" id="email_method">
															
											<label class="checkbox_label" for="email_method">Email</label>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="form-group input-field col m8 s12">
										<i class="material-icons prefix">comment</i>
										<textarea id="comment" name="comment" class="materialize-textarea textarea-control" data-length="500" required></textarea>
										<input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo $id; ?>" >
										<label for="comment">Write your message here</label>
									</div>
									
								</div>
								
							
								<div class="row">	
									<div class="col-md-6 col-sm-6 col-xs-12">
										<button type="button" onclick="submitEnquiry();" class="btn waves-effect waves-light white-text">SEND ENQUIRY <i class="material-icons right">send</i></button>
									</div>
								</div>	
									
								<?php
									echo form_close();
								?>
							</div>
						</div>
						<!-- /#tab2 -->
						
						
						<!-- #tab3 -->
						<div id="tab3" class="tab-pane fade">
							
							<div id="notif"></div>
							
							<div id="review-form" >
								
								<div class="row">	
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h4>Leave a review</h4>
									</div>
								</div>	
								
								<?php
									$attrs = array('class' => 'review_form form_horizontal', 'id' => 'review_form', 'name' => 'review_form', 'role' => 'form');
									echo form_open('main/submit_review', $attrs);
								?>
								
								<div class="row">
									<div class="form-group input-field col m4 s12">
										<i class="material-icons prefix">person</i>
										<input type="text" name="review_name" id="review_name" value="<?php echo set_value('review_name');?>" title="Please enter your name" class="validate">
										<label for="review_name">Enter your name</label>
									</div>
											
									<div class="form-group input-field col m6 s12">
										<i class="material-icons prefix">email</i>
										<input type="text" name="review_email" id="review_email" value="<?php echo set_value('review_email');?>" title="Please enter your email address" class="validate">
										<label for="review_email">Enter your email address</label>
									</div>
								</div>
								
								<div class="row">
									<div class="form-group input-field col m6 s12">
										<i class="material-icons prefix">comment</i>
										<textarea id="review-comment" name="review_comment" class="materialize-textarea textarea-control" data-length="200" required></textarea>
										
										<label for="review-comment">Write your review here</label>
									</div>
									<div class="col m6 s12">
										<label for="review-rating">Rating</label>
										<?php
											echo $new_rating;
										?>
									</div>
								</div>
					
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<input type="hidden" name="vID" id="vID" value="<?php echo $id; ?>" >
										<button type="button" onclick="submitReview();" class="btn btn-primary">SUBMIT REVIEW</button>
										
									</div>
									
								</div>
								
								<?php
									echo form_close();
								?>
							</div> 
						</div>
						<!-- /#tab3 -->
						
					</div>
					<!-- /.tab-content -->
					
				</div>
			</div>
			<!-- /.row -->
			
		</div>
		<!-- /.container details-container -->
		
	</div>
	<!-- /.container-fluid -->
	
</div>
<!-- /.section /.white -->
	