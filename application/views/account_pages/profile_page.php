<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
			$company_name = strtoupper($user->company_name);
			$profile_name = strtoupper($user->first_name.' '.$user->last_name);
			
			$line_1 = $user->address_line_1;
			$line_2 = $user->address_line_2;
			
			$address_line_1 = strlen($user->address_line_2) < 1 ? $user->address_line_1 : $user->address_line_1.', ';
			
			$address_line_2 = $user->address_line_2 == '' ? '' : $user->address_line_2;
			$city = $user->city;
			
			$postcode = $user->postcode;
			$ste = $user->state;
			$city_n_postcode = strtoupper($user->city.' '.$user->postcode);
			$state = strtoupper($user->state);
			$country = strtoupper($user->country);
			$tel = $user->telephone;

			$email = $user->email_address;
			
			$facebook = $user->facebook;
			$twitter = $user->twitter;
			$google = $user->google;

?>

		
        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $pageTitle;?></h3>
					</div>
					
				</div>

				<div class="clearfix"></div>
				
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								
								<div class="clearfix"></div>
								
								<!-- breadcrumb -->
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<ol class="breadcrumb">
											<li>
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'" title="Dashboard">
													<i class="fa fa-home"></i> Dashboard
												</a>
											</li>						
											<li class="active">
												<i class="fa fa-user"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>account/settings'" title="Settings"><i class="fa fa-cog"></i> Settings</a>
											
											</li>															
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
							</div>
							<!-- .x_content -->
							<div class="x_content">
							
								<!-- .container -->
								<div class="container">
								
									<!-- .row -->
									<div class="row">
										<div class="col-md-2 col-sm-3 col-xs-3">
											<div class="card">
												<div class="card-image">
													<?php echo $thumbnail; ?>
												</div>
												
											</div>
										</div>
									</div>		
									<!-- /.row -->
									
									<hr/>

									<!-- .row -->
									<div class="row">
									
										<!-- .col-md-6 -->
										<div class="col-md-6">
											<h3 class="text-primary profile-header">YOUR PERSONAL DETAILS</h3>
											<br/>
											
											<div class="row">
												<div class="col-sm-6">
													<p class="text-muted"><?php echo html_escape($profile_name);?></p>
													
													
													<?php
														if($address_line_1 != '' || $address_line_1 != null){
													?>
													<p class="text-muted"> <?php echo html_escape(strtoupper($address_line_1)); ?></p>
													<p class="text-muted"> <?php echo html_escape(strtoupper($address_line_2)); ?></p>
													<p class="text-muted"><?php echo html_escape($city_n_postcode); ?></p>
													<p class="text-muted"><?php echo html_escape($state);  ?></p>
													<p class="text-muted"><?php echo html_escape($country);  ?></p>
													<?php
														}else{
													?>
													<p>
														<strong><a class="text-primary" href="#!" title="Add address" onclick="location.href='<?php echo base_url('account/settings/');?>'"><i class="fa fa-chevron-right"></i> Add address</a></strong>
													</p>
													<?php
														}
													?>
													<?php
														if($tel != '' || $tel != null){
													?>
													<p class="text-muted"> <?php echo html_escape($tel);  ?></p>
													<?php
														}else{
													?>
													<p>
														<strong><a class="text-primary" href="#!" title="Add phone number" onclick="location.href='<?php echo base_url('account/settings/');?>'"><i class="fa fa-chevron-right"></i> Add phone number</a></strong>
													</p>
													<?php
														}
													?>
													
													
												</div>
												<div class="col-sm-6">
													
													<p class="text-muted"><i class="fa fa-envelope-o fa-lg margin-r-5"></i> <?php echo html_escape($email); ?></p>
													
													<br/><br/>
													
													<div class="social-icons">
														<?php echo $social_icons;?>
													</div>
												</div>
											</div>
											
										
										
											<p>
												<strong>
													<a class="text-primary" href="#!" title="Change details" onclick="location.href='<?php echo base_url('account/settings/');?>'">
														<span><i class="fa fa-chevron-right"></i></span>
														Change details <i class="fa fa-cog fa-lg" aria-hidden="true"></i>
													</a>
												</strong>
											</p>
										</div>
										<!-- /.col-md-6 -->
										
										<!-- .col-md-6 -->
										<div class="col-md-6">
											<h3 class="text-primary profile-header">YOUR ACCOUNT DETAILS</h3>
											<br/>
											<p>
												<strong>
													<a class="text-primary" href="javascript:void(0)" title="Change your password" onclick="location.href='<?php echo base_url('account/settings/');?>'">
														<i class="fa fa-chevron-right"></i> Change your password
													</a>
												</strong>
											</p>
											
											<p>
												<strong>
													<a class="text-primary" href="javascript:void(0)" title="Change security information" onclick="location.href='<?php echo base_url('account/security/');?>'">
														<i class="fa fa-chevron-right"></i> Change security information
													</a>
												</strong>
											</p>
											<br/>
											<p><strong><i class="fa fa-bell-o" aria-hidden="true"></i> Email Alerts</strong></p>
											<div class="notif"></div>
											<div class='switch'>
												<label>
													Off
													<?php echo $switch;?>
													<span class="lever"></span>
													On
												</label>
											</div>
											
										</div>
										<!-- /.col-md-6 -->
										
									</div>
									<!-- /.row -->
									
									<hr/>

								</div>
								<!-- /.container -->
								
							</div>
							<!-- /x_content -->
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->

<?php   
		}
	}								
?>

													