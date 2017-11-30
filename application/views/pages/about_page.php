
	
	<!-- .section .white -->
	<div class="section white fade">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			
			<!-- .header-->
			<h4 class="header">WHO WE ARE</h4>
			
			<div class="col s12 m7 l8">
					<p>Serving the greater local area car and truck market, our company carries the full line of Cars & Vehicles under one roof. Our friendly and knowledgeable staff will help make your purchase a pleasant experience for you and your wallet.</p>
			
					<p>We are known for providing superior automotive customer service and features no other car dealer can offer, including an extensive inventory of new and pre-owned vehicles. We offer weekly sales and lease specials and incentives that ensure you are receiving the best possible price for your vehicle purchase. Our Cars & Vehicles dealership in the local area is driven by our dedication to selling only the highest quality trucks, cars, and SUVs.</p>
					
					<p><a href="<?php echo base_url('services');?>" title="ALL SERVICES" class="waves-effect waves-light btn-large btn-success z-depth-5">LEARN MORE</a></p>
			
				</div>
				<div class="col s12 m5 l4">
					<div class="section-image">
						<img class="img-responsive" src="<?php echo base_url('assets/images/banners/unnamed.jpg');?>">
					</div>
				</div>
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
		
		<div class="container-medium">
			
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
	<div class="section team-section white fade">

		<!-- .row .container-medium -->
		<div class="row container-medium">
			
		<?php
			if($members_array){
		?>		
			<!-- .header-->
			<h4 class="header">PROFESSIONAL TEAM</h4>
			
			<?php
				//item count initialised
				$x = 0;
				//start row
				echo '<div class="row">';
				//get items from array
				foreach($members_array as $member){
					
					//generate random number
					$thisRandNum = md5(uniqid());
					
					//$profile_link = base_url().'team/'.$member->id.'/'.url_title(strtolower($member->first_name .' '.$member->last_name)).'/'.$thisRandNum;
					echo '<a href="#" onclick="location.href=\''.base_url().'team/'.$member->id.'/'.url_title(strtolower($member->first_name .' '.$member->last_name)).'/'.$thisRandNum.'\'">';
					
					echo '<div class="col-lg-3 col-sm-6 col-xs-6">';
					
			?>
				
						
					<div class="card hoverable">
						<!-- .card-image-->
						<div class="card-image">
							<img class="img-responsive" src="<?php echo base_url();?>uploads/members/<?php echo html_escape($member->id);?>/<?php echo html_escape($member->avatar);?>" title="<?php echo html_escape($member->first_name .' '.$member->last_name);?>">
							
						</div>
						<!-- /.card-image-->
						
						<!-- .card-content-->
						<div class="card-content">
							<span class="card-title">
							<a class="green-text text-lighten-1" href="#" onclick="location.href='<?php echo base_url();?>team/<?php echo $member->id;?>/<?php echo url_title(strtolower($member->first_name .' '.$member->last_name));?>/<?php echo $thisRandNum; ?>'" title="<?php echo html_escape($member->first_name .' '.$member->last_name);?>"><?php echo html_escape($member->first_name .' '.$member->last_name);?></a>
							
							</span>
							
							<p class="grey-text text-lighten-1"><?php echo html_escape($member->position);?></p>
							
							<div class="user-bio">
								<p class="black-text"><?php echo html_escape($member->bio_short);?></p>
							</div>
							<div class="social-icons">
								<a target="_blank" href="<?php echo html_escape($member->facebook);?>"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a>
								<a target="_blank" href="<?php echo html_escape($member->twitter);?>"><i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a>
								<a target="_blank" href="<?php echo html_escape($member->google);?>"><i class="fa fa-google fa-lg" aria-hidden="true"></i></a>
								
							</div>
						</div>
						<!-- /.card-content-->
						
					</div>
					<!-- /.card-->
					</a>
				</div>
		<?php
				//$x++;
				//if($x % 3 == 0){
				//	echo '</div><br/><div class="row">';
				//}
				}//END FOREACH LOOP
				echo '</div><br/>';
			}
			//END IF 
		?>			
			
	
			
		</div>
		<!-- /.row /.container-medium -->		
	</div>
	<!-- /.section /.white -->

	
	
	<!-- .section .white -->
	<div class="section white fade">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
		
			<!-- .header-->
			<h4 class="header">WHAT WE OFFER</h4>
			
			<!-- .row -->
			<div class="row">
				<!-- .col-lg-4 -->
				<div class="col-lg-4">
					<!-- no -->
					<div class="col-lg-3 col-md-12">
						<div class="huge no">
							01.
						</div>
					</div>
					<!-- /no -->
					
					<!-- content -->
					<div class="col-lg-9 col-md-12">
						<h5 class="">Auto Finance</h5>
						<p>Quick, flexible credit decisions and fast, local funding of your purchase.</p>
					</div>
					<!-- /content -->	
				</div>
				<!-- /.col-lg-4 -->
				
				<!-- .col-lg-4 -->
				<div class="col-lg-4">
					<!-- no -->
					<div class="col-lg-3 col-md-12">
						<div class="huge no">
							02.
						</div>
					</div>
					<!-- /no -->
					
					<!-- content -->
					<div class="col-lg-9 col-md-12">
						<h5 class="">History Check</h5>
						<p>Trustworthy information about your vehicle including previous owners etc.</p>
					</div>
					<!-- /content -->	
				</div>
				<!-- /.col-lg-4 -->
				
				<!-- .col-lg-4 -->
				<div class="col-lg-4">
					<!-- no -->
					<div class="col-lg-3 col-md-12">
						<div class="huge no">
							03.
						</div>
					</div>
					<!-- /no -->
					
					<!-- content -->
					<div class="col-lg-9 col-md-12">
						<h5 class="">Maintenance</h5>
						<p>Full technical inspection of your car, with discounts available to our customers.</p>
					</div>
					<!-- /content -->
					
				</div>
				<!-- /.col-lg-4 -->
				
			</div>	
			<!-- /.row -->
			
			<!-- .row -->
			<div class="row">
				<!-- .col-lg-4 -->
				<div class="col-lg-4">
					<!-- no -->
					<div class="col-lg-3 col-md-12">
						<div class="huge no">
							04.
						</div>
					</div>
					<!-- /no -->
					
					<!-- content -->
					<div class="col-lg-9 col-md-12">
						<h5 class="">Insurance</h5>
						<p>Cost-effective risk management solutions and affordable insurance services.</p>
					</div>
					<!-- /content -->	
				</div>
				<!-- /.col-lg-4 -->
				
				<!-- .col-lg-4 -->
				<div class="col-lg-4">
					<!-- no -->
					<div class="col-lg-3 col-md-12">
						<div class="huge no">
							05.
						</div>
					</div>
					<!-- /no -->
					
					<!-- content -->
					<div class="col-lg-9 col-md-12">
						<h5 class="">24/7 Support</h5>
						<p>Our experts work day and night to solve all your car-related problems.</p>
					</div>
					<!-- /content -->	
				</div>
				<!-- /.col-lg-4 -->
				
				<!-- .col-lg-4 -->
				<div class="col-lg-4">
					<!-- no -->
					<div class="col-lg-3 col-md-12">
						<div class="huge no">
							06.
						</div>
					</div>
					<!-- /no -->
					
					<!-- content -->
					<div class="col-lg-9 col-md-12">
						<h5 class="">Test Drive</h5>
						<p>You can check how your car behaves on the road to help you decide on your purchase.</p>
					</div>
					<!-- /content -->
					
				</div>
				<!-- /.col-lg-4 -->
				
			</div>	
			<!-- /.row -->
			
			
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.white -->
	
		
		
		
		
		
		
		
		
		