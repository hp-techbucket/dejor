
		
        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $pageTitle;?></h3>
					</div>
					
				</div>

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
								<i class="fa fa-users"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="javascript:void(0)" data-toggle="modal" data-target="#addUserModal" title="Add User"><i class="fa fa-plus"></i> Add User</a>
							</li>															
						</ol>
					</div>
				</div>
				<!-- /breadcrumb -->
				
				
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $pageTitle;?></h2>
							   
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
							
					<div class="nav-tabs-custom">

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#active-users" aria-controls="active-users" role="tab" data-toggle="tab"><h4>Active Users</h4></a>
							</li>
							<li role="presentation">
								<a href="#temp-users" aria-controls="temp-users" role="tab" data-toggle="tab"><h4>Temp Users</h4></a>
							</li>
							<li role="presentation">
								<a href="#suspended-users" aria-controls="suspended-users" role="tab" data-toggle="tab"><h4>Suspended Users</h4></a>
							</li>	
											
						</ul>
						<!-- /Nav tabs -->
								
						<!-- Tab panes -->
						<div class="tab-content">
						
							<!-- .tab-pane #active-users -->
							<div role="tabpanel" class="tab-pane active" id="active-users">
							<br/>
									
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'users',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<?php echo nbs(2);?> 
											<?php echo img('assets/images/icons/crookedArrow.png');?> 
											<a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton"  class="deleteButton" >
											<i class="fa fa-trash-o"></i> Delete
											</a>
										</div>
										<div class="col-xs-4">
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
											<div class="notif"></div>
											<div class="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- users-table -->
										<table id="active-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>Avatar</th>
													<th>Name (email)</th>
													<th>Address</th>
													
													<th>Last Login</th>
													
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /users-table -->
										
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
							<br/>
									
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'temp_users',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<?php echo nbs(2);?> 
											<?php echo img('assets/images/icons/crookedArrow.png');?> 
											<a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" class="deleteButton" >
											<i class="fa fa-trash-o"></i> Delete
											</a>
										</div>
										<div class="col-xs-4">
										<?php 
											$message = '';
											
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
										
											echo $message;
											
										?>
											<div class="notif"></div>
											<div class="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- temp-users-table -->
										<table id="temp-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>Name</th>
													<th>Address</th>
													<th>Mobile</th>
													
													<th>Date Joined</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /temp-users-table -->
										
										
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
							<br/>
										
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'users',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<?php echo nbs(2);?> 
											<?php echo img('assets/images/icons/crookedArrow.png');?> 
											<a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" class="deleteButton" >
											<i class="fa fa-trash-o"></i> Delete
											</a>
										</div>
										<div class="col-xs-4">
										<?php 
											$message = '';
											
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
											
											echo $message;
											
										?>
											<div class="notif"></div>
											<div class="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
															
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- suspended-users-table -->
										<table id="suspended-users-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>Avatar</th>
													<th>Name</th>
													
													<th>Last Login</th>
													<th>Date</th>
													<th>#Reactivate</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /suspended-users-table -->
										
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
		<form action="<?php echo base_url('admin/add_user'); ?>" id="addClientForm" name="addClientForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 align="center">Add New User</h3>
						</div>
						<div class="modal-body">
							<div class="form_errors"></div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Avatar</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
										</div>
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="client_photo" id="client_photo">
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Title</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									
									<select name="title" class="form-control"  id="title_add">
										<option value="Dr.">Dr.</option>
										<option value="Mr.">Mr.</option>
										<option value="Mrs.">Mrs.</option>
										<option value="Ms.">Ms.</option>
										<option value="Miss">Miss</option>
									</select>   
								</div>
								
								<label class="control-label col-md-2 col-sm-2 col-xs-6">First Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="first_name" id="fName" placeholder="First Name">
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Middle Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="middle_name" id="mName" placeholder="Middle Name">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Last Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="last_name" id="lName" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Address</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="address" id="add" placeholder="Address">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">City</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="city" id="cty" placeholder="City">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Postcode</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="postcode" id="pcode" placeholder="Postcode">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">State</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="state" id="ste" placeholder="State">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Country</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<?php echo $country_options; ?>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Telephone</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="telephone" id="tel" placeholder="Telephone">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Fax</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="fax" id="fx" placeholder="Fax">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Mobile</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="mobile" id="mob" placeholder="Mobile">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Marital Status</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<select name="marital_status" class="form-control" id="m_status">
									        
										<option value="Married">Married</option>
										<option value="Single">Single</option>
										<option value="Separated">Separated</option>
										<option value="Divorced">Divorced</option>
										<option value="Widowed">Widowed</option>
									</select>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Occupation</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="occupation" id="occupatn" placeholder="Occupation">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Date of Birth</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control datepicker" name="dob" id="date-of-birth" placeholder="Date of Birth">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Account Type</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									
									<select class="form-control" name="account_type" id="a_type">
									        
										<option value="Offshore Transit">Offshore Transit</option>
										<option value="Current Account">Current Account</option>
										<option value="Savings Account">Savings Account</option>
										<option value="Platinum Account">Platinum Account</option>
										
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Password</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="password" id="passwd" value="<?php echo $password_string; ?>" placeholder="Password">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Email</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="email" id="email_add" placeholder="Email">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Currency</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<?php echo $select_currency; ?>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Claim Amount</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="claim_amount" id="c_amount" placeholder="Claim Amount">
								</div>
							</div>
					
							
					
							
							<div id="alert-msg"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
							<input type="button" class="btn btn-success" onclick="javascript:addUser();" value="Add">
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
								  <h3 class="widget-user-username"><span id="fullName"></span></h3>
								  <h5 class="widget-user-desc"><i class="fa fa-map-marker" aria-hidden="true"></i> <span id="complete_address"></span></h5>
								  
								</div>
								<div class="widget-user-image">
								  <!-- Current avatar -->
									<span id="thumbnail" ></span>
								</div>
								
								<br/>
									
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-phone-square" aria-hidden="true"></i> Tel</h5>
										<span class="description-text">
											<span id="view-telephone" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-fax" aria-hidden="true"></i> Fax</h5>
										<span class="description-text">
											<span id="view-fax" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-mobile" aria-hidden="true"></i> Mobile</h5>
										<span class="description-text">
											<span id="view-mobile" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
								  </div>
								  <!-- /.row -->
								</div>
								
																
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-3">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-calendar" aria-hidden="true"></i> Birthday</h5>
										<span class="description-text">
											<span id="birthday" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-3">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-venus-mars" aria-hidden="true"></i> Marital Status</h5>
										<span class="description-text">
											<span id="view-marital_status" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-3">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-at" aria-hidden="true"></i> Username</h5>
										<span class="description-text">
											<span id="view-username" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-3">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</h5>
										<span class="description-text">
											<span id="view-email" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
								  </div>
								  <!-- /.row -->
								</div>
								
								
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-cc" aria-hidden="true"></i> Account #</h5>
										<span class="description-text">
											<span id="view-account_number" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-lock" aria-hidden="true"></i> PIN</h5>
										<span class="description-text">
											<span id="view-account_pin" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-money" aria-hidden="true"></i> Account Balance</h5>
										<span class="description-text">
											<span id="view-account_balance" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
								  </div>
								  <!-- /.row -->
								</div>
								
								
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-question-circle" aria-hidden="true"></i> Question</h5>
										<span class="description-text">
											<span id="view-security-question" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-key" aria-hidden="true"></i> Answer</h5>
										<span class="description-text">
											<span id="view-security-answer" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-star" aria-hidden="true"></i> Status</h5>
										<span class="description-text">
											<span id="view-status" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
								  </div>
								  <!-- /.row -->
								</div>
								
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-flag-checkered" aria-hidden="true"></i> Stamp</h5>
										<span class="description-text">
											<span id="view-stamp" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-flag-checkered" aria-hidden="true"></i> COT</h5>
										<span class="description-text">
											<span id="view-cot" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-4">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-flag-checkered" aria-hidden="true"></i> AML</h5>
										<span class="description-text">
											<span id="view-aml" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
								  </div>
								  <!-- /.row -->
								</div>
								
								<div class="box-footer">
								  <div class="row">
									<div class="col-sm-6">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-calendar-o"></i> Last Login</h5>
										<span class="description-text">
											<span id="view-last-login" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
									<div class="col-sm-6">
									  <div class="description-block">
										<h5 class="description-header"><i class="fa fa-calendar-o"></i> Joined</h5>
										<span class="description-text">
											<span id="view-date-created" ></span>
										</span>
									  </div>
									  <!-- /.description-block -->
									</div>
									<!-- /.col -->
									
								  </div>
								  <!-- /.row -->
								</div>
								
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
										<div class="fileinput-preview thumbnail u-thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
										</div>
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
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Title</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									   
									<span id="u_title"></span>
								</div>
								
								<label class="control-label col-md-2 col-sm-2 col-xs-6">First Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
									<input type="hidden" name="userID" id="userID">
									<input type="hidden" name="avatar" id="avatar">
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Middle Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Last Name</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Address</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="address" id="address" placeholder="Address">
								</div>
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
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Fax</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="fax" id="fax" placeholder="Fax">
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Mobile</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Marital Status</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									
									<span id="u_marital_status"></span>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Occupation</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="occupation" id="occupation" placeholder="Occupation">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Date of Birth</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control datepicker" name="dob" id="dob" placeholder="Date of Birth">
								</div>
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
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Username</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="username" id="username" >
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">New Password</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="new_password" class="form-control" name="new_password" id="new_password">
								</div>
								
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Account Type</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<span id="u_account_type"></span>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Status</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<span id="u_status"></span>
								</div>
								
								
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Account #</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="account_number" id="account_number" >
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Account Pin</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="account_pin" id="account_pin" >
								</div>
							</div>
							<div class="form-group">
								
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Currency</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<span id="u_currency"></span>
								</div>
								<label class="control-label col-md-2 col-sm-2 col-xs-6">Account Balance</label>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<input type="text" class="form-control" name="account_balance" id="account_balance" >
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
			
				


	<!-- Transaction Modal -->
	<form action="<?php echo base_url('admin/new_transaction'); ?>" id="transactionForm" name="transactionForm" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
		<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="tTitle"></h3>
						
					</div>
					<div class="modal-body">
						<span class="error-message"></span>
						<div class="form-group">
							<select name="action" class="form-control" id="action">
								<option value="Credit">Credit</option>
								<option value="Debit">Debit</option>
							</select>
						</div>
						<div class="form-group">
							<label for="reference">Users Reference:</label>
							<input name="reference" type="text" class="form-control" id="reference" placeholder="PWB/2017/JAN/72812" />
							<input name="userID" id="uid" type="hidden" />
							<input name="username" id="t-username" type="hidden" />
						</div>
						<div class="form-group">
							<label for="amount">Amount:</label>
							<input type="number" class="form-control" name="amount" id="t_amount" />
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default close-modal" data-dismiss="modal">
							<i class="fa fa-times"></i> Discard
						</button>
						
						<button type="button" class="btn btn-success" onclick="javascript:submitTransaction();">
						Submit
						</button>
						 
					</div>
				</div>
			</div>
		</div>	
	</form>
	<!-- Transaction Modal -->
			
	



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
							<i class="fa fa-times"></i> Discard
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
							<i class="fa fa-times"></i> Discard
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
	<!-- Suspend Modal -->
			
										