
		
	
	<!-- .section .white -->
	<div class="section white fade">
	
		<!-- .row .container-medium -->
		<div class="row container-medium profile-container">
		
			<!-- .header-->
			<h4 class="header"><?php echo html_escape(strtoupper($pageTitle)); ?></h4>
			
			<div class="row">
				<div class="col s5 m6 l4">
					<div class="section-image">
						<?php echo $avatar;?>
					</div>
				</div>
				<div class="col s7 m6 l8">
					<h5 class="green-text text-lighten-1"><?php echo $member_name;?></h5>
					<p class="black-text"><?php echo $position;?></p>
					
					<div class="social-icons">
						<a target="_blank" href="<?php echo html_escape($facebook);?>"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a>
						<a target="_blank" href="<?php echo html_escape($twitter);?>"><i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a>
						<a target="_blank" href="<?php echo html_escape($google);?>"><i class="fa fa-google fa-lg" aria-hidden="true"></i></a>
								
					</div>
					<div class="black-text"><?php echo $bio_long;?></div>
				</div>
				
			</div>
							
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.white -->
	

		
		
		
		
		
		