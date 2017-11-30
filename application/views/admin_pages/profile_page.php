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
											<li class="active">
												<i class="fa fa-user"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/settings'" title="Settings"><i class="fa fa-cog"></i> Settings</a>
											
											</li>															
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
							</div>
							<div class="x_content">
							<div>	
								<?php 
									$message = '';
									if($this->session->flashdata('updated') != ''){
										$message = $this->session->flashdata('updated');
									}	
									if($this->session->flashdata('errors') != ''){
										$message = $this->session->flashdata('errors');
									}	
									echo $message;	
										
								?>	
								<div class="notif"></div>
							</div>	
							
							<!-- Main content -->
							<section class="container">
								
								<div class="row">
									
									<!-- /.col -->
									<div class="col-md-12">
									<br/>
									
									<div class="nav-tabs-custom">
										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active">
												<a href="#user-profile" aria-controls="user-profile" role="tab" data-toggle="tab"><h4><i class="fa fa-user" aria-hidden="true"></i> Profile </h4></a>
											</li>
											<li role="presentation">
												<a href="#user-edit" aria-controls="user-edit" role="tab" data-toggle="tab"><h4><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Profile </h4></a>
											</li>
											
										</ul>
										<!-- /Nav tabs -->
							
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="user-profile">
								<br/>
									<div class="row">
										<div class="col-md-5 col-sm-6 col-xs-12">
											
											
											<div class="card" align="center">
												<br/>
												<?php echo $thumbnail; ?>
												<br/>
												<div class="card-action text-center">
												
													<table class="display">
														<tr>
															<td class="text-right">
																<h3 class="profile-username"><strong>Name <span class="glyphicon glyphicon-user"></span> </strong></h3>
															</td>
															<td class="text-left">
																<h3 class="profile-username"><?php echo $user->admin_name; ?></h3>
															</td>
														</tr>
														<tr>
															<td class="text-right">
																<h3 class="profile-username"><strong>Username <i class="fa fa-user" aria-hidden="true"></i> </strong></h3>
															</td>
															<td class="text-left">
																<h3 class="profile-username"><?php echo $user->admin_username; ?></h3>
															</td>
														</tr>
														<tr>
															<td class="text-right">
																<h3 class="profile-username"><strong>Access Level <i class="fa fa-key" aria-hidden="true"></i> </strong> </h3>
															</td>
															<td class="text-left">
																<h3 class="profile-username"><?php echo $user->access_level; ?></h3>
															</td>
														</tr>
														<tr>
															<td class="text-right">
																<h3 class="profile-username"><strong>Joined <i class="fa fa-calendar-o" aria-hidden="true"></i> </strong></h3>
															</td>
															<td class="text-left">
																<h3 class="profile-username"><?php echo date("F j, Y", strtotime($user->date_created)); ?></h3>
															</td>
														</tr>
														
													</table>
													
												</div>
											</div>
									
										</div>
									</div>

								</div>
								<div role="tabpanel" class="tab-pane" id="user-edit">
									
									<br/>
									<h3>Edit Profile</h3>
									
									<form action="<?php echo base_url('account/update_profile');?>" id="profile_update" name="profile_update" class="form-horizontal" method="post" enctype="multipart/form-data">
										<div class="form-group">
											
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="update_photo"></label>
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
										
										<div class="col-sm-4">
											<label for="admin_name" >Admin Name</label>

											<input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo $user->admin_name; ?>">
										</div>
									  </div>
									  <div class="form-group">
										
										<div class="col-sm-4">
											<label for="admin_username">Username</label>

											<input type="text" class="form-control" id="admin_username" value="<?php echo $user->admin_username; ?>" name="admin_username" readonly>
										</div>
									  </div>
									  
									  <div class="form-group">
										<div class="col-sm-12">
										  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal" title="Click to Update Profile">Update Profile</button>
										</div>
									  </div>
										<!-- /.row -->
									  
		<!-- Update Profile Modal -->
		<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Update Profile?</h3>
					</div>
					<div class="modal-body">
						<strong>Are you sure you want to update your profile?</strong>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
						<input type="button" class="btn btn-success" onclick="javascript:updateProfile();" value="Update">
					</div>
				</div>
			</div>
		</div>  
									  
									</form>
								</div>
								
								<br/><br/>
							</div>
							<!-- /Tab panes -->
										</div>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</section>
							<!-- /.content -->
								
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

													