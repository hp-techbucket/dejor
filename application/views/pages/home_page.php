
	<!-- Carousel
    ================================================== --> 
	<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
		
			
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			
			<div class="item active one">
		  
			<div class="overlay"></div>
			
				<div class="container-medium">
					<div class="carousel-caption animated slideInUp">
						<h4>New and Used Cars</h4>
						<p>Explore the vast model range of new and used cars by widely known manufacturers on our website.</p>
						<p><a href="#" class="waves-effect waves-light btn-large btn-trans z-depth-5">LEARN MORE</a></p>
					</div>
				</div>
			</div>

			<div class="item two">
			
				<div class=""></div>
			
				<div class="container-medium">
					<div class="carousel-caption animated slideInUp">
						<h4>Latest Car Reviews</h4>
						<p>Read the latest car reviews written by our clients or submit your own car review to our website's blog!</p>
						<p><a href="#" class="waves-effect waves-light btn-large btn-trans z-depth-5">LEARN MORE</a></p>
					</div>
				</div>
			</div>
			
			<div class="item three">
			
				
				<div class="container-medium">
					<div class="carousel-caption animated slideInUp">
						<h4>Locate a Car Dealer</h4>
						<p>We can help you find an appropriate car dealership according to your preferences and location.</p>
						<p><a href="#" class="waves-effect waves-light btn-large btn-trans z-depth-5">LEARN MORE</a></p>
					</div>
				</div>
			</div>
	  
	  
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		  <span class="glyphicon glyphicon-chevron-left"></span>
		  <span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">
		  <span class="glyphicon glyphicon-chevron-right"></span>
		  <span class="sr-only">Next</span>
		</a>
	</div>
	<!-- /Carousel========================================== --> 
	
	
	
	
	<!-- .section .white -->
	<div class="section white fade">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			<!-- .header-->
			<h4 class="header">CAR SEARCH</h4>
			<p>Please complete and submit this form to search. Thank You!</p>
			<div id="search-error"></div>
			<br/>
			<form action="<?php echo base_url('vehicles-search');?>" id="multi_search_form" name="multi_search_form" method="post">
			
			<?php echo validation_errors(); ?>
			<!-- .row-->
			<div class="row">
			
				<div class="col-lg-4 col-sm-6  col-xs-6">
					<div class="form-group">
						<label for="vehicle_type">Vehicle Type:</label>
						<select name="vehicle_type" id="vehicle_type" class="form-control select2 browser-default">
							<option value="" selected>Select Type</option>
							<?php 
								$this->db->from('vehicle_types');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										echo '<option value="'.$row['name'].'" >'.$row['name'].'</option>';
									}
								}
										
							?>
						</select>
					</div>
					
				</div>
				<div class="col-lg-4 col-sm-6  col-xs-6">
					<div class="form-group">
						<label for="vehicle_make">Make:</label>
						<select name="vehicle_make" class="form-control select2 browser-default" id="vehicle_make" onchange="getVehicleModels(this, '<?php echo base_url('vehicle/get_models');?>')">
							<option value="" selected>Select Make...</option>
							<?php 
								$this->db->from('vehicle_makes');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										echo '<option value="'.$row['id'].'">'.ucwords($row['title']).'</option>';			
									}
								}
										
							?>
						</select>
					</div>
					
				</div>
				<div class="col-lg-4 col-sm-6  col-xs-6">
					<div class="form-group">
						<label for="vehicle_model">Model:</label>
						<select name="vehicle_model" class="form-control select2" id="vehicle_model">
							<option value="" selected>Select Model...</option>
						</select>
					</div>
					
				</div>
			
				<div class="col-lg-4 col-sm-6 col-xs-6">
					<div class="form-group">
						<label for="vehicle_colour">Colour:</label>
						<select name="vehicle_colour" class="form-control select2" id="vehicle_colour">
							<option value="" selected>Select Colour...</option>
							<?php 
								$this->db->from('colours');
								$this->db->order_by('id');
								$result = $this->db->get();
								if($result->num_rows() > 0) {
									foreach($result->result_array() as $row){
										echo '<option value="'.$row['colour_name'].'">'.ucwords($row['colour_name']).'</option>';			
									}
								}
										
							?>
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<label for="vehicle_min_year">Min Year:</label>
						<select name="vehicle_min_year" class="form-control select2">
							<option value="" selected>Select Min Year</option>
							<?php
								for($i=date("Y")-50; $i<=date("Y"); $i++) {
									$sel = ($i == date('Y') - 15) ? 'selected' : '';
									echo "<option value=".$i." ".$sel.">".$i."</option>";      
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<label for="vehicle_max_year">Max Year:</label>
						<select name="vehicle_max_year" class="form-control select2 browser-default">
							<option value="" selected>Select Max Year</option>
							<?php
								for($i=date("Y")-50; $i<=date("Y"); $i++) {
									$sel = ($i == date('Y')) ? 'selected' : '';
									echo "<option value=".$i." ".$sel.">".$i."</option>";        
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<label for="vehicle_min_price">Min Price:</label>
						<select name="vehicle_min_price" class="form-control select2">
							<option value="" selected>Min Price</option>
							<?php
								for($x=500; $x<=20000; $x+=500) {
									//
									echo "<option value=".$x." > $".number_format($x, 0)."</option>";        
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-sm-3 col-xs-6">
					<div class="form-group">
						<label for="vehicle_max_price">Max Price:</label>
						<select name="vehicle_max_price" class="form-control select2">
							<option value="" selected>Max Price</option>
							<?php
								for($y=500; $y<=20000; $y+=500) {
									//
									echo "<option value=".$y." > $".number_format($y, 0)."</option>";      
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<!-- /.row-->
			
			<!-- .row-->
			<div class="row">
				<div class="col-lg-4 col-sm-6 col-xs-12">
					<div class="form-group">
						<button type="button" id="search-btn" class="btn-large waves-effect waves-light light-green darken-1 " ><i class="fa fa-search"></i> SEARCH</button>
					</div>
				</div>
			</div>	
			<!-- /.row-->
			
		
							
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.white -->
	
	
	<!-- .parallax-container -->
	<div class="parallax-container parallax-container-md fade">
		<div class="parallax-overlay"></div>
		<!-- .parallax -->
		<div class="parallax">
			<img src="<?php echo base_url('assets/images/banners/tints-banner-background21.jpg');?>">
			
		</div>
		<!-- /.parallax -->
		
		<div class="row container-medium">
			<div class="parallax-caption">
				<h4 class="header">COUNTERS</h4>	
				<div class="row counter-row" align="center">
					<div class="col-lg-3 col-sm-6 col-xs-6">
						<h4 class="huge models-count">132</h4>
						<p>Types of models</p>
					</div>
					<div class="col-lg-3 col-sm-6 col-xs-6">
						<h4 class="huge consultants-count">15</h4>
						<p>Certified consultants</p>
					</div>
					<div class="col-lg-3 col-sm-6 col-xs-6">
						<h4 class="huge models-sale">26</h4>
						<p>Models we sell</p>
					</div>
					<div class="col-lg-3 col-sm-6 col-xs-6">
						<h4 class="huge clients-count">795</h4>
						<p>Happy clients</p>
					</div>
				</div>
			</div>
		</div>
		
		
	</div>
	<!-- /.parallax-container -->
	
	
	<!-- .section .white -->
	<div class="section white fade">
		<!-- .row .container -->
		<div class="row container-medium">
			<!-- .header-->
			<h4 class="header">OUR SERVICES</h4>
			<p>We strive to provide our customers with the best services possible.</p>
			
			<div class="row">
				
			</div>
			
			<div class="row">
				<div class="col s12 m6 l4">
					<a href="#history-check" title="History Check">
						<div class="card hoverable">
							<div class="card-image">
								<img src="<?php echo base_url('assets/images/banners/163266_the_new_volvo_xc90.jpg');?>" class="responsive-img">
							</div>
							
							<div class="card-action light-green darken-1 text-center">
								<a class="white-text" href="#">History Check</a>
							</div>
						</div>
					</a>
				</div>
				<div class="col s12 m6 l4">
					<a href="#buyers-guide" title="Buyers Guide">
						<div class="card hoverable">
							<div class="card-image">
								<img src="<?php echo base_url('assets/images/banners/Screen shot 2014-03-21 at 12.06.55.png');?>" class="responsive-img">
							</div>
							
							<div class="card-action light-green darken-1 text-center">
								<a class="white-text" href="#">Buyers Guide</a>
							</div>
						</div>
					</a>
				</div>
				<div class="col s12 m6 l4">
					<a href="#car-insurance" title="Car Insurance">
					<div class="card hoverable">
						<div class="card-image">
							<img src="<?php echo base_url('assets/images/banners/f7ab233f0a0d02b701d50fd26fbdb26f.jpg');?>" class="responsive-img">
						</div>
						
						<div class="card-action light-green darken-1 text-center">
							<a class="white-text" href="#">Car Insurance</a>
						</div>
					</div>
					</a>
				</div>
			
				<div class="col s12 m6 l4">
					<a href="#vehicle-check" title="Car Check">
						<div class="card hoverable">
							<div class="card-image">
								<img src="<?php echo base_url('assets/images/banners/vehicle-check-updated.png');?>" class="responsive-img">
							</div>
							
							<div class="card-action light-green darken-1 text-center">
								<a class="white-text" href="#">Car Check</a>
							</div>
							
						</div>
					</a>
				</div>
				<div class="col s12 m6 l4">
					<a href="<?php echo base_url('warranty');?>" title="Warranty Programs">
						<div class="card hoverable">
							<div class="card-image">
								<img src="<?php echo base_url('assets/images/banners/extended-car-warranty.jpg');?>" class="responsive-img">
							</div>
							
							<div class="card-action light-green darken-1 text-center">
								<a class="white-text" href="#">Warranty Programs</a>
							</div>
						</div>
					</a>
				</div>
				<div class="col s12 m6 l4">
					<a class="tooltipped" data-position="top" href="<?php echo base_url('contact_us');?>" title="Customer Support">
						<div class="card hoverable">
							<div class="card-image">
								<img src="<?php echo base_url('assets/images/banners/contact_us.jpg');?>" class="responsive-img">
							</div>
							
							<div class="card-action light-green darken-1 text-center">
								<a class="white-text" href="#">Customer Support</a>
							</div>
						</div>
					</a>
				</div>
			</div>
			<p align="center"><a href="<?php echo base_url('services');?>" title="ALL SERVICES" class="waves-effect waves-light btn-large btn-trans-success z-depth-5">VIEW ALL SERVICES</a></p>
		</div>
		<!-- /.row /.container -->

	</div>
	<!-- /.section /.white -->
	
	
	
	<!-- .parallax-container -->
	<div class="parallax-container parallax-container-md fade">
		<div class="parallax-overlay"></div>
		<!-- .parallax -->
		<div class="parallax">
			<img src="<?php echo base_url('assets/images/banners/IMG_115975.jpg');?>">
			
		</div>
		<!-- /.parallax -->
		
		<div class="container-medium testimonial-container">
			<?php
			if($testimonials_array){
							
		?>
			<div class="parallax-caption2">
				<h4 class="header">TESTIMONIALS</h4>	
				<!-- Carousel
				================================================== --> 
				<div id="testimonialCarousel" class="carousel slide carousel-custom" data-ride="carousel" data-interval="4000">
					<div class=""></div>
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#testimonialCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#testimonialCarousel" data-slide-to="1"></li>
						<li data-target="#testimonialCarousel" data-slide-to="2"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
					<?php
					
						//item count initialised
						$a = 1;
						//get items from array
						foreach($testimonials_array as $testimonial){
							
							$active = '';
							$image_class = '';
							$image_alt = '';
							switch ($a) {
								case 1:
									$active = 'active';
									$image_class = 'first-slide';
									$image_alt = 'First slide';
									break;
								case 2:
									$image_class = 'second-slide';
									$image_alt = 'Second slide';
									break;
								case 3:
									$image_class = 'third-slide';
									$image_alt = 'Third slide';
									break;
								case 4:
									$image_class = 'fourth-slide';
									$image_alt = 'Fourth slide';
									break;
								case 5:
									$image_class = 'fifth-slide';
									$image_alt = 'Fifth slide';
									break;
								case 6:
									$image_class = 'sixth-slide';
									$image_alt = 'Sixth slide';
									break;

								default:
									$image_class = '';
									$image_alt = '';
							}
							//substr($testimonial->comment, 0, 135).'...'
					?>
					
							<div class="item <?php echo $active ; ?>">
								<div class="row valign-wrapper">
									<div class="col s3 m2 l2">
										<div class="user_avatar">
											<img class="img-circle <?php echo $image_class; ?> img-responsive" src="<?php echo base_url('uploads/testimonials');?>/<?php echo $testimonial->avatar; ?>" alt="<?php echo $image_alt; ?>">
										</div>
									</div>
									<div class="col s9 m10 l10 left-align">
											
										<div class="blockquote">
											<blockquote>
												<p><em><?php echo $testimonial->comment; ?></em></p>
											</blockquote>
										</div>
										<p><strong> - <?php echo $testimonial->fullname; ?></strong></p>
										
									</div>
								</div>
								
							</div>
							<?php
								$a++;
							}
							?>
					
					</div>

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#testimonialCarousel" data-slide="prev">
					  <i class="fa fa-angle-left fa-5x" aria-hidden="true"></i>
					  <span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#testimonialCarousel" data-slide="next">
					  <i class="fa fa-angle-right fa-5x" aria-hidden="true"></i>
					  <span class="sr-only">Next</span>
					</a>
				</div>
				<!-- /.carousel -->
			
		<?php 
			}
		?>
			</div>
		</div>
	</div>
	<!-- /.parallax-container -->
