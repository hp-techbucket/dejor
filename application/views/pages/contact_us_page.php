	
		
	
	<!-- .section .white -->
	<div class="section white fade">
		<!-- .row .container-medium -->
		<div class="row container-medium">
			
			<div class="col-md-4 col-sm-5 col-xs-12">
				<div class="map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11213.71428509093!2d3.4556208574331087!3d6.439396879394741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x476b2b8df034f5b!2sElim+Motors!5e0!3m2!1sen!2sng!4v1500544862844" width="" height="650" frameborder="0" style="border:0" allowfullscreen></iframe>
					
				</div>
			</div>
			<div class="col-md-8 col-sm-7">
				<!-- .header-->
				<h4 class="header">GET IN TOUCH</h4>
				<br/>
				<p class="">You can contact us any way that is convenient for you. We are available 24/7 via fax or email. You can also use a quick contact form below or visit our office personally.</p>
				<p class="">Email us with any questions or inquiries or use our contact data. We would be happy to answer your questions.</p>
				
				<br/>
				<!-- .row -->
				<div class="row">
					<div class="col-sm-1 col-xs-2">
						<i class="small material-icons">drafts</i>
					</div>
					<div class="col-sm-5 col-xs-10">
						<p class="lead light-green-text text-darken-2">Email</p>
						<p class=""><a class="grey-text text-darken-4" href="mailto:info@dejor.com">info [@] dejor.com</a></p>
					</div>
					<div class="col-sm-1 col-xs-2">
						<i class="fa fa-share-alt fa-fw fa-2x" aria-hidden="true"></i>
					</div>
					<div class="col-sm-5 col-xs-10">
						<p class="lead light-green-text text-darken-2">Follow Us</p>
								
						<div class="social-icons-contact">
							<a target="_blank" href="https://www.facebook.com/Dejor"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a>
							<a target="_blank" href="https://www.twitter.com/Dejor"><i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a>
							<a target="_blank" href="https://www.pinterest.com/Dejor"><i class="fa fa-pinterest-p fa-lg" aria-hidden="true"></i></a>
							<a target="_blank" href="https://www.vimeo.com/Dejor"><i class="fa fa-vimeo fa-lg" aria-hidden="true"></i></a>
							<a target="_blank" href="https://plus.google.com/b/12121/+Dejor"><i class="fa fa-google fa-lg" aria-hidden="true"></i></a>
							<a target="_blank" href="https://www.twitter.com/Dejor"><i class="fa fa-rss fa-lg" aria-hidden="true"></i></a>
						</div>
					</div>
					
				</div>
				<!-- /.row -->
				
				<!-- .row -->
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<p class="lead light-green-text text-darken-2">Contact Form</p>
					</div>
					
				</div>
				<!-- /.row -->
				<?php 
					$attributes = array('class' => 'contact_us_form', 'role' => 'form');
					echo form_open('main/contact_us_validation',$attributes); 					
				?>
				
				<!-- .row -->
				<div class="row">
					<div class="col s12 m6">
						<div class="form-group form-group-lg">
							<div class="textinput">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user" aria-hidden="true"></i>
									</div>
									<input type="text" name="contact_us_name" value="<?php echo set_value('contact_us_name'); ?>" class="form-control browser-default floatLabel" id="contact_us_name"required>
								</div>
								
								<label class="" for="contact_us_name">Full Name</label>
							</div>
						</div>
					</div>
					<div class="col s12 m6">
						<div class="textinput form-group form-group-lg">
							
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</div>
								<input type="email" name="contact_us_email" value="<?php echo set_value('contact_us_email'); ?>" class="form-control browser-default floatLabel" id="contact_us_email" required>
							</div>
							
							<label class="" for="contact_us_email">Email Address</label>
							
						</div>
					</div>
				</div>
				<!-- /.row -->
				
				<!-- .row -->
				<div class="row">
					<div class="col s12 m6">
						<div class="textinput form-group form-group-lg">
							
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-building" aria-hidden="true"></i>
								</div>
								<input type="text" name="contact_us_company" value="<?php echo set_value('contact_us_company'); ?>" class="form-control browser-default floatLabel" id="contact_us_company" >
							</div>
							<label class="" for="contact_us_company">Company (Optional)</label>
						</div>	
					</div>
					<div class="col s12 m6">
						<div class="textinput form-group form-group-lg">
							
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone" aria-hidden="true"></i>
								</div>
								<input type="tel" name="contact_us_telephone" value="<?php echo set_value('contact_us_telephone'); ?>" class="form-control browser-default floatLabel" id="contact_us_telephone" required>
							</div>
							<label class="" for="contact_us_telephone">(845)555-1212</label>
						</div>
							
					</div>
				</div>
				<!-- /.row -->
		
				<!-- .row -->
				<div class="row">
					<div class="col s12 m12">
				
						<div class="form-group form-group-lg">
							<label class="" for="contact_us_message">Your Message</label>
							<textarea name="contact_us_message" id="contact_us_message" class="form-control textarea-control" data-length="200" required><?php echo set_value('contact_us_message'); ?></textarea>
							
							
						</div>
						
					</div>
				</div>
				<!-- /.row -->
				
				<!-- .row -->
				<div class="row">
					<div class="input-field col s12 m12">
						<button type="submit" class="waves-effect waves-light btn-large btn-success z-depth-5">SEND MESSAGE</button>
					</div>
					
				</div>
				<!-- /.row -->
				<?php 
					echo form_close();
					//echo br(3);
				?>
						
			</div>	
		</div>
		<!-- /.row /.container-medium -->	
	</div>
	<!-- /.section /.white -->
	
	
	<!-- .parallax-container -->
	<div class="parallax-container parallax-container-sm fade">
		
		<div class="parallax-overlay"></div>
		
		<!-- .parallax -->
		<div class="parallax">
			<img src="<?php echo base_url('assets/images/banners/IMG_115975.jpg');?>">
			
		</div>
		<!-- /.parallax -->
		
		<div class="container-medium">
			
			<div class="parallax-caption">
				<div class="row">
					<div class="col-sm-1 col-xs-2">
						<i class="fa fa-envelope fa-fw fa-3x" aria-hidden="true"></i>
					</div>
					<div class="col-sm-3 col-xs-10">
						<p class="lead light-green-text text-darken-2">Post Address</p>
						<p class="grey-text text-lighten-5">9863 - 9867 Mill Road, Cambridge, MG09 99HT.</p>
					</div>
					<div class="col-sm-1 col-xs-2">
						<i class="fa fa-phone fa-fw fa-3x" aria-hidden="true"></i>
					</div>
					<div class="col-sm-3 col-xs-10">
						<p class="lead light-green-text text-darken-2">Phones</p>
						<p class="grey-text text-lighten-5">
							Phone:<a class="grey-text text-lighten-5" href="callto:#">+1 800 603 6035</a><br/>
							Fax:<a class="grey-text text-lighten-5" href="callto:#">+1 800 889 9898
						</p>
					</div>
					<div class="col-sm-1 col-xs-2">
						<i class="fa fa-clock-o fa-fw fa-3x" aria-hidden="true"></i>
					</div>
					<div class="col-sm-3 col-xs-10">
						<p class="lead light-green-text text-darken-2">Opening Hours</p>
						<p class="grey-text text-lighten-5">8:00 - 18:00 Mon - Sat</p>
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<!-- /.parallax-container -->
		
		
		
		
		
		
		
		
		
		