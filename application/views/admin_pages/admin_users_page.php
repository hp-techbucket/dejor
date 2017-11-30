
		
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
								
								<!-- breadcrumb -->
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<ol class="breadcrumb">
											<li>
												<a href="!#" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
													<i class="fa fa-home"></i> Dashboard
												</a>
											</li>						
											<li class="active">
												<i class="fa fa-users"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="!#" data-toggle="modal" data-target="#addAdminModal" title="Add Admin"><i class="fa fa-user-plus"></i> Add Admin</a>
											</li>															
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
							   
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'admin_users',);	
								echo form_hidden($hidden);	
								$disabled = 'disabled';		
								if($count_records > 0){
									$disabled = '';
								}		
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										
										<div class="col-xs-12">
										
											<div id="notif"></div>
											<div id="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
								
								<!-- table container -->
								<div class="container">
									<!-- /table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- admin users-table -->
										<table id="admin-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" ><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													<th>Name (Username)</th>
													<th>Access Level</th>
													<th>Last Updated</th>
													<th>Last Login</th>
													
													<th>Date Created</th>
													<th>#Edit</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /admin users-table -->
		
										<!-- Multi Delete Modal -->
										<div class="modal fade" id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												Delete Records?
												<div id="delete-errors"></div>
											  </div>
											  <div class="modal-body">
												<strong>Are you sure you want to permanently delete the selected records?</strong>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
												
												<input type="button" onclick="multiDelete()" class="btn btn-danger" value="Delete">
											  </div>
											</div>
										  </div>
										</div>		
										<?php 	
													
											//	close the form
											echo form_close();	
										?>		
												
										
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->


		<!-- ADD Admin -->
		<form action="<?php echo base_url('admin/add_admin'); ?>" id="addAdminForm" name="addAdminForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Admin</h3>
				  </div>
					<div class="modal-body">
						<div class="form_errors"></div>
						
						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12" align="center">
								<label class="">Upload Avatar</label>
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
									</div>
									<div>
										<span class="btn btn-primary btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="newUserPhoto" id="userPhotoUpload" >
										</span>
										<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
								
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">Admin Name</label>
								<input type="text" class="form-control" name="admin_name" id="name_of_admin" placeholder="Admin Name">
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">Username</label>
								<input type="text" class="form-control" name="admin_username" id="admin_username" placeholder="Admin Username">
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">Password</label>
								<input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Admin Password">
							</div>
						</div>
					
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:addAdmin();" value="Add New Admin">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Admin -->
		


	<!-- SEND MESSAGE -->
	<form action="<?php echo base_url('message/new_message_validation'); ?>" id="message_form" name="messageForm" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
		<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="messageTitle"></h3>
						
					</div>
					<div class="modal-body">
						<span class="error-message"></span>
						
						<div class="form-group">
							<input class="form-control" id="email_to" placeholder="Email To:" readonly>
						</div>
						<div class="form-group">
							<input class="form-control" name="message_subject" id="message_subject" placeholder="Subject:">
						</div>
						<div class="form-group">
							<textarea name="message_details" id="message_details" class="form-control messageDetails" style="height: 100px">
							</textarea>
							
							<input type="hidden" name="sender_name" id="sender_name">
							<input type="hidden" name="sender_username" id="sender_username" >
							<input type="hidden" name="receiver_name" id="receiver_name" >
							<input type="hidden" name="receiver_username" id="receiver_username" >
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close-modal" data-dismiss="modal">
							<i class="fa fa-times"></i> Discard
						</button>
						
						<button type="button" class="btn btn-primary" onclick="javascript:submitMessage();" id="messageBtn">
						Send
							<i class="fa fa-arrow-circle-right"></i>
						</button>
						 
					</div>
				</div>
			</div>
		</div>	
	</form>
	<!-- Send Message -->
		
		<!-- View Admin -->
			<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
				  
					<div class="row">
						<div class="col-md-12">
							<!-- Widget: user widget style 1 -->
							<div class="widget-user">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-black" style="background: url('<?php echo base_url();?>assets/images/img/photo1.png') center center;">
								  <h3 class="widget-user-username">
									<span id="adminName" ></span>
								  </h3>
								  <h5 class="widget-user-desc">
								  Access: <span id="accessLevel" ></span>
								  </h5>
								</div>
								<div class="widget-user-image">
								  <!-- Current avatar -->
									<span id="thumbnail" ></span>
								</div>
								
								<br/>
								
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-4 border-right">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-user"></i> Username</h5>
										<span class="description-text">
											<span id="adminUserName" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-4 border-right">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-clock-o"></i> Last Login</h5>
										<span class="description-text">
											<span id="lastLogin" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-calendar-o"></i> Joined</h5>
										<span class="description-text">
											<span id="dateJoined" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
								  </div>
								  <!-- /.row -->
								</div>
							</div>
							<!-- /.widget-user -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				  
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
				</div>
			  </div>
			</div>	
		<!-- View Admin -->

		<!-- Edit Admin -->
		<form action="<?php echo base_url('admin/update_admin');?>" id="updateAdminForm" name="updateAdminForm"  class="form-horizontal form-label-left input_mask"  method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 align="center" id="name">Update</h3>
					</div>
					<div class="modal-body">
						<div class="form_errors"></div>
						
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12" align="center">
								<label class=""></label>
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-preview thumbnail u-thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; ">
									</div>
									<div>
										<span class="btn btn-primary btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="uploadPhoto" id="photoUpload">
										</span>
										<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">Admin Name:</label>
								<span id="admin_name"></span>
								<input type="hidden" name="adminID" id="adminID">
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">Username</label>
								<span id="username"></span>
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">Access Level</label>
								<span id="a_level"></span>
							</div>
						</div>
						<div class="form-group">
							
							<div class="col-md-8 col-md-offset-2 col-xs-12">
								<label class="">New Password</label>
								<input type="password" name="new_password" id="new_password" class="form-control">
								<input type="hidden" name="old_password" id="old_password">
							</div>
						</div>
						
				
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
						<input type="button" class="btn btn-primary" onclick="javascript:updateAdmin();" value="Update Admin">
					</div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Admin -->

