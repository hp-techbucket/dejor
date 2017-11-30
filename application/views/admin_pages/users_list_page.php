
		
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
									<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
										<i class="fa fa-home"></i> Dashboard
									</a>
								</li>	
								
								<li class="active">
									<i class="fa fa-users"></i> <?php echo $pageTitle;?>
								</li>
								<li>
									<a href="!#" class="add_user" data-toggle="modal" data-target="#addUserModal" title="Add User"><i class="fa fa-plus"></i> Add User</a>
								</li>															
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->
					
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
							
					<div class="nav-tabs-custom">

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#active-users" aria-controls="active-users" role="tab" data-toggle="tab"><h4>Active Users (<span id="record-count"><?php echo $users_count; ?></span>)</h4></a>
							</li>
							<li role="presentation">
								<a href="#temp-users" aria-controls="temp-users" role="tab" data-toggle="tab"><h4>Temp Users (<span id="record-count"><?php echo $temp_users_count; ?></span>)</h4></a>
							</li>
							<li role="presentation">
								<a href="#suspended-users" aria-controls="suspended-users" role="tab" data-toggle="tab"><h4>Suspended Users (<span id="record-count"><?php echo $suspended_users_count; ?></span>)</h4></a>
							</li>	
											
						</ul>
						<!-- /Nav tabs -->
								
						<!-- Tab panes -->
						<div class="tab-content">
						
							<!-- .tab-pane #active-users -->
							<div role="tabpanel" class="tab-pane active" id="active-users">
							
							<div class="notif"></div>
							<div class="errors"></div>
							
							<br/>
							<?php
							
								//start multi delete form
								$form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form1', 'role' => 'form');
								echo form_open('admin/multi_delete',$form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'users',);	
								echo form_hidden($hidden);	
								
								$disabled = 'disabled';	
								$disabled2 = 'disabled';
								$disabled3 = 'disabled';
								
								if($users_count > 0){
									$disabled = '';
								}		
								if($temp_users_count > 0){
									$disabled2 = '';
								}	
								if($suspended_users_count > 0){
									$disabled3 = '';
								}	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										
										<div class="col-md-12 col-xs-12">
										<?php 
											$message = '';
											if($this->session->flashdata('user_added') != ''){
												$message = $this->session->flashdata('user_added');
											}	
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
											if($this->session->flashdata('user_updated') != ''){
												$message = $this->session->flashdata('user_updated');
											}	
											
											echo $message;
											
										?>
											
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- users-table -->
										<table id="active-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="10%">
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th width="10%">Name (email)</th>
													<th width="20%">Profile Completion</th>
													<th width="10%">Rating</th>
													<th width="10%">Last Updated</th>
													<th width="10%">Last Login</th>
													
													<th width="10%">#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /users-table -->
		
		
		<!-- Multi Delete Modal -->
		<div class="modal fade " id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
						<button type="button" class="btn btn-danger" onclick="multiDeleteRecord(this)" >Delete</button>
						
					</div>
				</div>
			</div>
		</div>		
		<!-- /Multi Delete Modal -->
		
										<?php 	
													
											//close the form
											echo form_close();	
										?>		
	

									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
								
							</div>
							<!-- /tab-pane -->
							
							
							<!-- .tab-pane #temp-users -->
							<div role="tabpanel" class="tab-pane" id="temp-users">
							
							<div class="notif"></div>
							<div class="errors"></div>
							
							<br/>		
							<?php
								//start multi delete form
								$form_attributes2 = array('class' => 'multi_delete_form','id' => 'multi_delete_form2', 'role' => 'form');
								echo form_open('admin/multi_delete',$form_attributes2);
								//hidden item - model name
								$hidden = array('model' => 'temp_users',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										
										<div class="col-md-12 col-xs-12">
										<?php 
											$message = '';
											
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
										
											echo $message;
											
										?>
											
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- temp-users-table -->
										<table id="temp-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="10%">
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th width="10%">Name</th>
													<th width="20%">Address</th>
													<th width="10%">Mobile</th>
													<th width="20%">Location</th>
													<th width="20%">Date Joined</th>
													<th width="10%">Activate</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /temp-users-table -->
										
										
		<!-- Multi Delete Modal2 -->
		<div class="modal fade " id="multiDeleteModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
						<button type="button" class="btn btn-danger" onclick="multiDelete()" >Delete</button>
					</div>
				</div>
			</div>
		</div>		
		<!-- /Multi Delete Modal2 -->
		
										<?php 	
													
											//close the form
											echo form_close();	
										?>		
	

									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
								
							</div>
							<!-- /tab-pane -->
							
							
							<!-- .tab-pane #suspended-users -->
							<div role="tabpanel" class="tab-pane" id="suspended-users">
							
							<div class="notif"></div>
							<div class="errors"></div>
							
							<br/>			
							<?php
								//start multi delete form
								$form_attributes3 = array('class' => 'multi_delete_form','id' => 'multi_delete_form3', 'role' => 'form');
								echo form_open('admin/multi_delete',$form_attributes3);
								//hidden item - model name
								$hidden = array('model' => 'users',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										
										<div class="col-md-12 col-xs-12">
										<?php 
											$message = '';
											
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
											
											echo $message;
											
										?>
											
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- suspended-users-table -->
										<table id="suspended-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="10%">
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th width="10%">Name</th>
													<th width="20%">Rating</th>
													<th width="20%">Last Updated</th>
													<th width="20%">Last Login</th>
													<th width="10%">Date</th>
													<th width="10%">#Reactivate</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /suspended-users-table -->
										
										
		<!-- Multi Delete Modal 3-->
		<div class="modal fade " id="multiDeleteModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
						<button type="button" class="btn btn-danger" onclick="multiDelete()" >Delete</button>
					</div>
				</div>
			</div>
		</div>		
		<!-- /Multi Delete Modal 3-->
		
		
										<?php 	
													
											//close the form
											echo form_close();	
										?>		
	

									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->

							</div>
							<!-- /tab-pane #suspended-users -->
							
							
						</div>
						<!-- /Tab panes -->
								
					</div>
					<!-- /nav-tabs-custom -->
							
				</div>
				<!-- /x_content -->
				
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->
		
	
										
	<!-- ADD User -->
	<form action="<?php echo base_url('admin/add_user'); ?>" id="addUserForm" name="addUserForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
		<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="headerTitle" align="center">Add New User</h3>
					</div>
					<div class="modal-body">
					
						<div class="form_errors"></div>
						
						<div class="scrollable">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Avatar</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail u-thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
										</div>
										
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="user_photo" id="user_photo">
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="first_name">First Name</label>
									<input type="text" class="form-control" name="first_name" id="fName" placeholder="First Name">
									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="last_name">Last Name</label>
									<input type="text" class="form-control" name="last_name" id="lName" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="company_name">Company Name</label>
									<input type="text" class="form-control" name="company_name" id="cName" placeholder="Company Name">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="address_line_1">Address Line 1</label>
									<input type="text" class="form-control" name="address_line_1" id="address_line_1" placeholder="Address">
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="address_line_2">Address Line 2</label>
									<input type="text" class="form-control" name="address_line_2" id="address_line_2" placeholder="Address">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="city">City</label>
									<input type="text" class="form-control" name="city" id="cty" placeholder="City">
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="postcode">Postcode</label>
									<input type="text" class="form-control" name="postcode" id="pcode" placeholder="Postcode">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="country">Country</label>
									<select name="country" class="form-control" id="cntry" onchange="getStates(this, '<?php echo base_url('location/get_states');?>')">
										<option value="" selected="selected">Select Country</option>
										<?php 
											$this->db->from('countries');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													echo '<option value="'.$row['id'].'">'.ucwords($row['name']).'</option>';			
												}
											}
										//echo $country_options; 
										
										?>
									</select>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="state">State</label>
									<select name="state" id="ste" class="form-control states">
										<option value="">Select State</option>
									</select>
								</div>	
							</div>
							<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label for="telephone">Telephone</label>
										<input type="text" class="form-control" name="telephone" id="tel" placeholder="Telephone">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<label for="email_address">Email</label>
										<input type="text" class="form-control" name="email_address" id="email_add" placeholder="Email">
									</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="password">Password</label>
									<input type="text" class="form-control" name="password" id="passwd" placeholder="Password">
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="status">Status</label>
									<select name="status" class="form-control select2" id="status">
											<?php 
											$this->db->from('status');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													
													echo '<option value="'.$row['status'].'">'.$row['status'].'</option>';
												}
											}
											
											//echo $select_status; 
											
											?>
									</select>
								</div>
							</div>

							<div id="alert-msg"></div>
							
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<input type="hidden" name="userID" id="userID">
							<input type="hidden" name="avatar" id="avatar">
							<input type="button" class="btn btn-primary btn-update hidden" onclick="javascript:updateUser();" value="Update">
							
							<input type="button" class="btn btn-success btn-add" onclick="javascript:addUser();" value="Add">
						</div>
					</div>
				</div>
			</div>
		</div>	
	</form>		
	<!-- Add User -->
		


		
	<!-- View User -->
	<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body med-scrollable">
					
					<div class="clearfix"></div>
					
					<div class="row">
						<div class="col-md-12">
							<!-- Widget: user widget style 1 -->
							<div class="widget-user">
								<!-- Add the bg color to the header using any of the bg-* classes -->
								<div class="widget-user-header bg-black" style="background: url('<?php echo base_url();?>assets/images/img/photo1.png') center center;">
								  <h3 class="widget-user-username"><span class="fullName"></span></h3>
								  <h5 class="widget-user-desc"><i class="fa fa-calendar-o"></i> Last Login: <span id="view-last-login" ></span></h5>
								  
								</div>
								<div class="widget-user-image">
								  <!-- Current avatar -->
									<span id="thumbnail" ></span>
								</div>
								
								<br/><br/><br/>
								<h3>Account Information</h3>
								
								<table class="table">	
									
									<tr>
										<td><h5><strong><i class="fa fa-question-circle" aria-hidden="true"></i> Question:</strong> <span class="huge" id="view-security-question" ></span></h5></td>
										
									</tr>
									<tr>
										<td><h5><strong><i class="fa fa-key" aria-hidden="true"></i> Answer:</strong> <span class="huge" id="view-security-answer" ></span></h5></td>
										
									</tr>
									<tr>
										<td><h5><strong><i class="fa fa-star" aria-hidden="true"></i> Status: </strong> <span id="view-status" ></span></h5></td>
									</tr>
									
									<tr>
										<td><h5><strong><i class="fa fa-calendar-o"></i> Joined: </strong> <span id="view-date-created" ></span></h5></td>
										
									</tr>
									
									<tr>
										<td><h5><strong><i class="fa fa-calendar-o"></i> Last Login: </strong> <span id="view-last-login" ></span></h5></td>
										
									</tr>
									
									
								</table>
								
								<br/>
								<h3>Personal Information</h3>
								<table class="table">
									<tr>
										<td><h5><strong><i class="fa fa-building" aria-hidden="true"></i> Company Name: </strong> <span id="companyName"></span></h5></td>
										
									</tr>	
									<tr>
										<td><h5><strong><i class="fa fa-user" aria-hidden="true"></i> Name: </strong> <span class="fullName"></span></h5></td>
										
									</tr>	
									<tr>
										<td><h5><strong><i class="fa fa-map-marker" aria-hidden="true"></i> Address: </strong> <span id="complete_address"></span></h5></td>
									</tr>
									<tr>
										<td><h5><strong><i class="fa fa-phone-square" aria-hidden="true"></i> Tel: </strong> <span id="view-telephone" ></span></h5></td>
										
									</tr>
									
									
									<tr>
										<td><h5><strong><i class="fa fa-envelope-o" aria-hidden="true"></i> Email: </strong> <span id="view-email" ></span></h5></td>
									</tr>
									
								</table>
								
								<br/>
							
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
	<!-- View User -->





	<!-- Edit Modal -->
	<form action="<?php echo base_url('admin/update_user'); ?>" id="updateUserForm" name="updateUserForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="header" align="center"></h3>
				  </div>
					<div class="modal-body">
					<div class="form-errors"></div>
						<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Avatar</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-new thumbnail " data-trigger="fileinput" style="width: 165px; height: 150px;">
											<div class="u-thumbnail"></div>
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 165px; max-height: 150px;"></div>
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="new_user_photo" id="new_user_photo" >
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								
								</div>
							</div>
							<div class="form-group">
								
								<label class="control-label col-md-2 col-sm-2 col-xs-6">First Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
									
								</div>
								
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Last Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Address 1</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="address" id="address" placeholder="Address">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Address 2</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="address" id="address" placeholder="Address">
								</div>
							</div>
							<div class="form-group">
								
								<label class="control-label col-md-2 col-sm-2 col-xs-6">City</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="city" id="city" placeholder="City">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Postcode</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">State</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="state" id="state" placeholder="State">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Country</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<span id="u_country"></span>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Telephone</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Telephone">
								</div>
							</div>
							
							<div class="form-group">
							
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Email</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="email" id="email" placeholder="Email">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Security Question</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="security_question" id="security_question" >
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Security Answer</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="security_answer" id="security_answer" >
								</div>
							</div>
							
							
							<div class="form-group">
							
								<div class="col-md-4 col-sm-4 col-xs-6">
									<label class="">New Password</label>
									<input type="new_password" class="form-control" name="new_password" id="new_password">
								</div>
								
							</div>
							
							<div class="form-group">
								<div class="col-md-4 col-sm-4 col-xs-6">
									<label class="">Status</label>
									<span id="u_status"></span>
								</div>
							</div>
							
							
					</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateUser();" value="Update">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Modal -->
			
	
		
					


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
							<textarea name="message_details" id="message_details" class="form-control messageDetails" style="height: 100px"></textarea>
							
							<input type="hidden" name="sender_name" id="sender_name">
							<input type="hidden" name="sender_email" id="sender_email" >
							<input type="hidden" name="receiver_name" id="receiver_name" >
							<input type="hidden" name="receiver_email" id="receiver_email" >
						</div>
						<p class="small">Attach files below (allowed types:pdf, doc, docx, jpg, jpeg and png)</p>
						
						<div class="input_file_wrap">
							<div class="form-group">
								<div class="fileinput fileinput-new" data-provides="fileinput">
								  <span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Attach file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="documents[]"></span>
								  <span class="fileinput-filename"></span>
								  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
								</div>
							</div>
						</div>
						<p><a href="!#" class="upload_more_button"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close-modal" data-dismiss="modal">
							<i class="fa fa-times"></i> Cancel
						</button>
						
						<button type="button" class="btn btn-primary" onclick="javascript:submitMessage();" id="messageBtn">
						Send
							<i class="fa fa-arrow-circle-right"></i>
						</button>
						
						<button type="submit" class="btn btn-success">
						Send
							<i class="fa fa-arrow-circle-right"></i>
						</button>
						  
					</div>
				</div>
			</div>
		</div>	
	</form>
	<!-- Send Message -->
			
		


	<!-- suspend Modal -->
	<form action="<?php echo base_url('admin/suspend_user'); ?>" id="suspendForm" name="suspendForm" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
		<div class="modal fade" id="suspendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Suspend User</h3>
						
					</div>
					<div class="modal-body">
						<span class="error-message"></span>
						<p>Do you wish to suspend user <span id="u-name"></span></p>
						<div class="form-group">
							<input name="userID" id="user-id" type="hidden" />
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close-modal" data-dismiss="modal">
							<i class="fa fa-times"></i> Cancel
						</button>
						
						<button type="button" class="btn btn-danger" onclick="javascript:suspendConfirm();">
						Suspend
						<i class="fa fa-ban" aria-hidden="true"></i>
						</button>
						 
					</div>
				</div>
			</div>
		</div>	
	</form>
	<!-- Suspend Modal -->
			




	<!-- reactivate Modal -->
	<form action="<?php echo base_url('admin/reactivate_user'); ?>" id="reactivateForm" name="reactivateForm" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
		<div class="modal fade" id="reactivateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Reactivate User</h3>
						
					</div>
					<div class="modal-body">
						<span class="error-message"></span>
						<p>Do you wish to reactivate user <span id="r-u-name"></span></p>
						<div class="form-group">
							<input name="userID" id="r-user-id" type="hidden" />
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close-modal" data-dismiss="modal">
							<i class="fa fa-times"></i> Cancel
						</button>
						
						<button type="button" class="btn btn-success" onclick="javascript:reactivateConfirm();">
						Reactivate
							<i class="fa fa-undo" aria-hidden="true"></i>
						</button>
						 
					</div>
				</div>
			</div>
		</div>	
	</form>
	<!-- reactivate Modal -->
			


	<!-- Activate Modal -->
	<form action="<?php echo base_url('admin/activate_user'); ?>" id="activateForm" name="activateForm" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
		<div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3>Activate User</h3>
						
					</div>
					<div class="modal-body">
						<span class="error-message"></span>
						<p>Do you wish to activate user <span id="temp-u-name"></span></p>
						<div class="form-group">
							<input name="userID" id="temp-user-id" type="hidden" />
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close-modal" data-dismiss="modal">
							<i class="fa fa-times"></i> Cancel
						</button>
						
						<button type="button" class="btn btn-success" onclick="javascript:activateConfirm();">
						Activate
							<i class="fa fa-undo" aria-hidden="true"></i>
						</button>
						 
					</div>
				</div>
			</div>
		</div>	
	</form>
	<!-- Activate Modal -->
													