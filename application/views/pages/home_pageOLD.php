
	<!-- Carousel
    ================================================== --> 
	<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
		<div class=""></div>
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner">

			<div class="item active">
		  
				<div class="overlay"></div>
			
				<img src="<?php echo base_url('assets/images/banners/car4-lowres.jpg');?>" alt="New and Used Cars" style="width:100%;">
				<div class="container-medium">
					<div class="carousel-caption animated slideInUp">
						<h3>New and Used Cars</h3>
						<p>Explore the vast model range of new and used cars by widely known manufacturers on our website.</p>
						<p><a href="#" class="waves-effect waves-light btn-large btn-trans z-depth-5">LEARN MORE</a></p>
					</div>
				</div>
			</div>

			<div class="item">
			
				<div class="overlay"></div>
			
				<img src="<?php echo base_url('assets/images/banners/00_Preview.__large_preview.jpg');?>" alt="Latest Car Reviews" style="width:100%;">
				<div class="container-medium">
					<div class="carousel-caption animated slideInUp">
						<h3>Latest Car Reviews</h3>
						<p>Read the latest car reviews written by our clients or submit your own car review to our website's blog!</p>
						<p><a href="#" class="waves-effect waves-light btn-large btn-trans z-depth-5">LEARN MORE</a></p>
					</div>
				</div>
			</div>
			
			<div class="item">
			
				<div class="overlay"></div>
			
				<img src="<?php echo base_url('assets/images/banners/dixie.jpg');?>" alt="Locate a Car Dealer" style="width:100%;">
				<div class="container-medium">
					<div class="carousel-caption animated slideInUp">
						<h3>Locate a Car Dealer</h3>
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
	<!-- /.carousel -->
	
	
	<!-- .section .white -->
	<div class="section white fade">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			<!-- .header-->
			<h3 class="header">CAR SEARCH</h3>
			<p>Please complete and submit this form to search. Thank You!</p>
			<?php
				$search_form = array(
					'name' => 'search_form',
					'class' => '',
					'id' => 'search_form',
				);
				echo form_open('main/search',$search_form);
			?>
			<!-- .row-->
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<label for="vehicle_make">Make:</label>
						<select name="vehicle_make" class="form-control select2">
							<option value="0" selected>Enter car make...</option>
						</select>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
						<label for="vehicle_model">Model:</label>
						<select name="vehicle_model" class="form-control select2">
							<option value="0" selected>Enter model...</option>
						</select>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="form-group">
						<label for="vehicle_colour">Colour:</label>
						<select name="vehicle_colour" class="form-control select2">
							<option value="0" selected>Enter colour...</option>
						</select>
					</div>
				</div>
			</div>
			<!-- /.row-->
			
			<!-- .row-->
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<label for="vehicle_body_take">Body Type:</label>
						<select name="vehicle_body_take" class="form-control select2">
							<option value="0" selected>Enter body take</option>
						</select>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label for="vehicle_min_year">Min Year:</label>
						<select name="vehicle_min_year" class="form-control select2">
							<option value="0" selected>0</option>
						</select>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label for="vehicle_max_year">Max Year:</label>
						<select name="vehicle_max_year" class="form-control select2">
							<option value="0" selected>0</option>
						</select>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label for="vehicle_min_price">Min Price:</label>
						<select name="vehicle_min_price" class="form-control select2">
							<option value="0" selected>0</option>
						</select>
					</div>
				</div>
				<div class="col-lg-2">
					<div class="form-group">
						<label for="vehicle_max_price">Max Price:</label>
						<select name="vehicle_max_price" class="form-control select2">
							<option value="0" selected>0</option>
						</select>
					</div>
				</div>
			</div>
			<!-- /.row-->
			
			<!-- .row-->
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<button class="btn-large waves-effect waves-light light-green darken-1 " type="button">SEARCH</button>
					</div>
				</div>
			</div>	
			<!-- /.row-->
			<?php
				echo form_close();
			?>
							
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.white -->
	
	
	<!-- .parallax-container -->
	<div class="parallax-container  parallax-container-custom fade">
		<div class="parallax-overlay"></div>
		<!-- .parallax -->
		<div class="parallax">
			<img src="<?php echo base_url('assets/images/banners/car4-lowres.jpg');?>">
			
		</div>
		<!-- /.parallax -->
		
		<div class="row container-medium">
			<div class="parallax-caption">
				<h3 class="header">COUNTERS</h3>	
				<div class="row counter-row" align="center">
					<div class="col-lg-3">
						<h4 class="huge models-count">132</h4>
						<p>Types of models</p>
					</div>
					<div class="col-lg-3">
						<h4 class="huge consultants-count">15</h4>
						<p>Certified consultants</p>
					</div>
					<div class="col-lg-3">
						<h4 class="huge models-sale">26</h4>
						<p>Models we sell</p>
					</div>
					<div class="col-lg-3">
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
			<h2 class="header">OUR SERVICES</h2>
			<p>We strive to provide our customers with the best services possible.</p>
			
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
			</div>
			
			<div class="row">
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
					<a href="<?php echo base_url('contact_us');?>" title="Customer Support">
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
	<div class="parallax-container parallax-container-custom fade">
		<div class="parallax-overlay"></div>
		<!-- .parallax -->
		<div class="parallax">
			<img src="<?php echo base_url('assets/images/banners/16m6_hero_540_03.ts.1703021844539970.jpg');?>">
			
		</div>
		<!-- /.parallax -->
		
		<div class="row container-medium testimonial-container">
			<?php
			if($testimonials_array){
							
		?>
			<div class="parallax-caption2">
				<h3 class="header">TESTIMONIALS</h3>	
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
								<div class="user_avatar">
									<img class="img-circle <?php echo $image_class; ?>" src="<?php echo base_url('uploads/testimonials');?>/<?php echo $testimonial->avatar; ?>" alt="<?php echo $image_alt; ?>">
								</div>
								<div class="blockquote">
									<blockquote>
										<p><em><?php echo $testimonial->comment; ?></em></p>
									</blockquote>
								</div>
								<p><strong> - <?php echo $testimonial->fullname; ?></strong></p>
								
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

	<!-- .section .white -->
	<div class="section white fade">
		<!-- .row .container -->
		<div class="row container-medium">
			<!-- .header-->
			<h2 class="header"><?php echo $pageTitle; ?></h2>
			<p class="grey-text text-darken-3 lighten-3">Welcome to <?php echo $pageTitle; ?>.</p>
		</div>
		<!-- /.row /.container -->

		  
		<ul id="slide-out" class="side-nav">
			<li><div class="user-view">
			  <div class="background">
				<img src="<?php echo base_url('assets/images/img/photo1.png');?>">
			  </div>
			  <a href="#!user"><img class="circle" src="<?php echo base_url('assets/images/img/user7-128x128.jpg');?>"></a>
			  <a href="#!name"><span class="white-text name">Ash</span></a>
			  <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
			</div></li>
			<li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
			<li><a href="#!">Second Link</a></li>
			<li><div class="divider"></div></li>
			<li><a class="subheader">Subheader</a></li>
			<li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
		</ul>
		<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
				
	</div>
	<!-- /.section /.white -->
	
	<!-- Page Layout here -->
    <div class="row fade">

      <div class="col s12 m4 l3 brown lighten-5"> <!-- Note that "m4 l3" was added -->
        <!-- Grey navigation panel

              This content will be:
          3-columns-wide on large screens,
          4-columns-wide on medium screens,
          12-columns-wide on small screens  -->
			<div class="card-panel grey lighten-5 z-depth-1">
				<div class="row valign-wrapper">
					<div class="col s2">
					
						<img src="<?php echo base_url('assets/images/img/user1-128x128.jpg');?>" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
					</div>
					<div class="col s10">
					  <span class="black-text">
						This is a square image. Add the "circle" class to it to make it appear circular.
					  </span>
					</div>
				</div>
			</div>
      </div>

      <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->
        <!-- Teal page content

              This content will be:
          9-columns-wide on large screens,
          8-columns-wide on medium screens,
          12-columns-wide on small screens  -->
			<div class="card-panel deep-orange lighten-4 hoverable">
			  <span class="blue-text text-darken-2">This is a card panel with dark blue text</span>
			</div>
      </div>

    </div>
	
