<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{
			$company_name = ucwords($user->company_name);
			$profile_name = strtoupper($user->first_name.' '.$user->last_name);
			$first_name = $user->first_name;
			$last_name = $user->last_name;
			
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
									<li>
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>account/profile'" title="Profile"><i class="fa fa-user"></i> Profile</a>
											
									</li>		
									<li class="active">
										<i class="fa fa-cog"></i> <?php echo $pageTitle;?>
									</li>
								</ol>
							</div>
						</div>
						<!-- /breadcrumb -->
					</div>
					<div class="x_content">
						<div class="notif"></div>
									
						<div class="row">
							<div class="col-lg-12">
								
								<div align="center">
									
									<a href="#update-password" title="Change Password" class="btn btn-success btn-settings"><i class="fa fa-lock" aria-hidden="true"></i> Change Password</a>
									
								</div>		
						
								<div class="" id="edit-profile">
											
									<h3 class="text-primary profile-header">EDIT PERSONAL DETAILS</h3>
												
									<br/>
								<?php
									if($profile_completion < 100){
								?>
									<div class="row">
										<div class="col-sm-6">
											<div class="">
												<div class="progress " style="width: 100%;">
													<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $profile_completion ; ?>">Your profile is <?php echo $profile_completion ; ?>% complete</div>
													
												</div>
												
											</div>
									
										</div>
									</div>
								<?php
									}
								?>	
									<?php 
										$attributes = array(
											'class' => 'form-horizontal',
											'id' => 'update_profile',
										);
										//start form
										echo form_open('account/update_profile',$attributes);
									?>	
									
									<div class="form-group">
										<div class="col-sm-6 col-xs-12">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; ">
													<?php echo $mini_thumbnail; ?>
												</div>
												<div>
													<span class="btn btn-primary btn-file">
														<span class="fileinput-new">Select new image</span>
														<span class="fileinput-exists">Change</span>
														<input type="file" name="update_photo" id="update_photo" >
													</span>
													<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
												</div>
											</div>
										</div>
									</div>
										  
									<div class="form-group">
										<div class="col-sm-6 col-xs-12">
											<label for="company_name">Company Name <i class="fa fa-building-o" aria-hidden="true"></i></label>

											<input type="text" name="company_name" class="form-control" id="company_name" value="<?php echo $company_name; ?>">
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-3 col-xs-6">
											<label for="first_name">First Name <i class="fa fa-user" aria-hidden="true"></i></label>

											<input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo ucwords($first_name); ?>" readonly>
										</div>
										<div class="col-sm-3 col-xs-6">
											<label for="last_name">Last Name <i class="fa fa-user" aria-hidden="true"></i></label>

											<input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo ucwords($last_name); ?>" readonly>
										</div>
									</div>
									    
									<div class="form-group">
										<div class="col-sm-6 col-xs-12">
											<label for="address_line_1">Address Line 1 <i class="fa fa-street-view" aria-hidden="true"></i></label>

											<input type="text" name="address_line_1" class="form-control" id="address_line_1" value="<?php echo $line_1; ?>">
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-6 col-xs-12">
											<label for="address_line_2">Address Line 2 <i class="fa fa-street-view" aria-hidden="true"></i></label>

											<input type="text" name="address_line_2" class="form-control" id="address_line_2" value="<?php echo $line_2; ?>">
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-3 col-xs-6">
											<label for="city">City <i class="fa fa-map-marker" aria-hidden="true"></i></label>

											<input type="text" name="city" class="form-control" id="city" value="<?php echo ucwords($city); ?>" placeholder="">
										</div>
										<div class="col-sm-3 col-xs-6">
											<label for="postcode">Postcode <i class="fa fa-compass" aria-hidden="true"></i></label>

											<input type="text" name="postcode" class="form-control" id="postcode" value="<?php echo ucwords($postcode); ?>" placeholder="12345">
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-3 col-xs-6">
											<label for="country">Country <i class="fa fa-globe" aria-hidden="true"></i></label>
											
											<select name="country" class="form-control" id="cntry" onchange="getStates(this, '<?php echo base_url('location/get_states');?>')">
												
												<option value="" >Select Country</option>
												<?php 
													$this->db->from('countries');
													$this->db->order_by('id');
													$result = $this->db->get();
													if($result->num_rows() > 0) {
														foreach($result->result_array() as $row){
																		
															$default = (strtolower($row['name']) == strtolower($country))?'selected':'';
																		
															echo '<option value="'.$row['id'].'" '.$default.'>'.ucwords($row['name']).'</option>';			
														}
													}
															
												?>
											</select>
														
										</div>
										<div class="col-sm-3 col-xs-6">
											<label for="state">State <i class="fa fa-compass" aria-hidden="true"></i></label>
											<select name="state" id="ste" class="form-control states">
												<option value="" >Select State</option>
												<?php
												$d = ($ste != '')?'selected':'';
												?>
												<option value="<?php echo $ste; ?>" <?php echo $d; ?>><?php echo $ste; ?></option>
											</select>
														
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-3 col-xs-6">
											<label for="telephone">Telephone <i class="fa fa-phone" aria-hidden="true"></i></label>

											<input type="text" name="telephone" class="form-control" id="telephone" value="<?php echo $tel; ?>" placeholder="08123456789">
										</div>
										<div class="col-sm-3 col-xs-6">
											<label for="facebook">Facebook Username <i class="fa fa-facebook" aria-hidden="true"></i></label>

											<input type="text" name="facebook" class="form-control" id="facebook" value="<?php echo $facebook; ?>" placeholder="www.facebook.com/John+Doe">
										</div>
									</div>
												
									<div class="form-group">
										<div class="col-sm-3 col-xs-6">
											<label for="twitter">Twitter Username <i class="fa fa-twitter" aria-hidden="true"></i></label>

											<input type="text" name="twitter" class="form-control" id="twitter" value="<?php echo $twitter; ?>" placeholder="www.twitter.com/John+Doe">
										</div>
										<div class="col-sm-3 col-xs-6">
											<label for="google">Google Username <i class="fa fa-google-plus" aria-hidden="true"></i></label>

											<input type="text" name="google" class="form-control" id="google" value="<?php echo $google; ?>" placeholder="plus.google.com/b/John+Doe">
										</div>
									</div>
												
									<div class="form-group">
										<div class="col-sm-6 col-xs-12">
											<input type="button" class="btn btn-primary btn-block" onclick="javascript:updateUser();" value="Update">
										</div>
									</div>
									
										  
								<?php 
									echo form_close();
								?>	

								</div>
								
								<div class="settings-section" id="update-password">
								<h3 class="text-primary profile-header">CHANGE PASSWORD</h3>
								
								<br/><br/>
								
							<?php 
									$attributes = array(
										'class' => 'form-horizontal',
										'id' => 'password_update',
									);
									//start message form
									echo form_open('account/password_update',$attributes);
								?>	
									<div class="form-group">
										<div class="col-sm-5 col-xs-6">
											<label for="old_password">Old Password</label>

											<input type="password" class="form-control" id="old_password" value="<?php echo set_value('old_password'); ?>" name="old_password">
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-5 col-xs-6">
											<label for="new_password">New Password</label>

											<input type="password" class="form-control" id="new_password" value="<?php echo set_value('new_password'); ?>" name="new_password">
										</div>
									</div>
									  
									<div class="form-group">
										<div class="col-sm-5 col-xs-6">
											<label for="confirm_new_password" >Confirm New Password</label>

											<input type="password" class="form-control" id="confirm_new_password" value="<?php echo set_value('confirm_new_password'); ?>" name="confirm_new_password">
										</div>
									</div>
										
									<div class="form-group">
										<div class="col-sm-5 col-xs-6">
												
											<input type="button" class="btn btn-primary btn-block" onclick="javascript:updatePassword();" value="Update">
										</div>
									</div>
									  
								<?php 
									echo form_close();
								?>	

								</div>
								
							</div>
						</div>
						<!-- /.row -->
					</div>
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
