<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
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
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
													<i class="fa fa-home"></i> Dashboard
												</a>
											</li>	
											<li>
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/profile'" title="Profile"><i class="fa fa-user"></i> Profile</a>
											
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
								
								<div>	
									<div class="notif"></div>
								</div>
								
								<div class="row">
									<div class="col-lg-12">
										
										<?php 
											$attributes = array(
												'class' => 'form-horizontal',
												'id' => 'settings_update',
											);
											//start message form
											echo form_open('admin/password_update',$attributes);
										
										?>	
										<div class="form-group">
											
											<div class="col-sm-4">
												<label for="old_password">Old Password</label>

												<input type="password" class="form-control" id="old_password" value="<?php echo set_value('old_password'); ?>" name="old_password">
											</div>
										</div>
									  
										<div class="form-group">
											
											<div class="col-sm-4">
												<label for="new_password">New Password</label>

												<input type="password" class="form-control" id="new_password" value="<?php echo set_value('new_password'); ?>" name="new_password">
											</div>
										</div>
									  
										<div class="form-group">
											
											<div class="col-sm-4">
												<label for="confirm_new_password" >Confirm New Password</label>

												<input type="password" class="form-control" id="confirm_new_password" value="<?php echo set_value('confirm_new_password'); ?>" name="confirm_new_password">
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-sm-4">
												
											<input type="button" class="btn btn-primary btn-block" onclick="javascript:updatePassword();" value="Update">
											</div>
										</div>
									  
													
										
						<?php 
							echo form_close();
						?>	
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
