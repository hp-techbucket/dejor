
		
        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $pageTitle;?></h3>
					</div>
					<div class="title_right">
						<div class="pull-right">
							<span>Last Login: <?php echo $last_login;?></span>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2><?php echo $pageTitle;?></h2>
							   
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="row top_tiles">
									<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/transactions/');?>'">
											<div class="tile-stats">
												<div class="icon"><i class="fa fa-exchange"></i></div>
												<div class="count"><?php echo $transactions_count; ?></div>
												<h3>New Transactions</h3>
												<p align="center"><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/transactions/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a></p>
											</div>
										</a>
									</div>
									
									<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/contact_us/');?>'">
											<div class="tile-stats">
												<div class="icon"><i class="fa fa-envelope"></i></div>
												<div class="count"><?php echo $contact_us_count; ?></div>
												<h3>New Web Messages</h3>
												<p align="center"><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/contact_us/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a></p>
											</div>
										</a>
									</div>
									<div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox/');?>'">
											<div class="tile-stats">
												<div class="icon"><i class="fa fa-inbox"></i></div>
												<div class="count"><?php echo $messages_unread; ?></div>
												<h3>New Inbox Messages</h3>
												<p align="center"><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a></p>
											</div>
										</a>
									</div>
								</div>
								
							</div>
						</div>	
					</div>	
				</div>
				
				
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_panel fixed_height_320">
							<div class="x_title">
								<h2>Latest Users</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li class="pull-right">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</li>
									
								</ul>
								<div class="clearfix"></div>
							</div>
							
							<div class="x_content">
							
								<table class="table table-striped">
									<tbody>
											  
								<?php
										if($users_array){
										foreach($users_array as $user){
											$thumbnail =  '';
											
										$filename = FCPATH.'uploads/users/'.$user->id.'/'.$user->avatar;
										if($user->avatar == '' || $user->avatar == null || !file_exists($filename)){
											$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class=" img-circle img-responsive" width="30" height="30" >';
											
										}
										else{
											$thumbnail =  '<img src="'.base_url('uploads/users').'/'. $user->id.'/'. $user->avatar.'" class="img-circle img-responsive" width="30" height="30" alt="User Image" >';
										}	
										?>
										<tr>
											<td><?php echo $thumbnail;?></td>
											<td>
												<a  href="javascript:void(0)" class="link product-title" data-toggle="modal" data-target="#viewUser" onclick="viewUser(<?php echo $user->id; ?>);"><?php echo $user->first_name .' '.$user->last_name; ?></a>
												
											</td>
											<td><strong>Tag Line:</strong> <?php echo $user->tagline; ?></td>
										</tr>
									<?php 
										
										}
									}else{
										?>
										<tr>
											<td colspan="8" align="center">No users!</td>
										</tr>
										
										<?php 
									}
										?>
										
									</tbody>
								</table>
							
							</div>
							<!-- /.x_body -->
							<div class="x_footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/users');?>'" class="uppercase">View All Users</a>
							</div>
							<!-- /.x_footer -->
							
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_panel fixed_height_320">
							<div class="x_title">
								<h2>Latest Transactions</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li class="pull-right">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</li>
									
								</ul>
								<div class="clearfix"></div>
							</div>
							
							
							<div class="x_content">
								
								<table class="table table-striped">
								  <thead>
									<tr>
									  
									  <th>Ref#</th>
									  <th>User</th>
									  
									  <th>Amount</th>
									  <th>Status</th>
									  <th>IP</th>
									  <th>Date</th>
									</tr>
								  </thead>
								  <tbody>
								 <?php 
								 
								if($transactions_array){
									$row = 1;
									foreach($transactions_array as $transaction){
										$fullname = '';
										$currency = '';
										$user_array = $this->Users->get_user($transaction->username);
										foreach($user_array as $user){
											$fullname = $user->first_name.' '.$user->last_name;
											
										}
								 ?>
									<tr>
									  
									  <td><?php echo $transaction->reference; ?></td>
									  <td><?php echo $fullname; ?></td>
									  
									  <td><?php echo $currency.''.number_format($transaction->amount, 0); ?></td>
									  
									  <td><?php echo $transaction->status; ?></td>
									  <td><?php echo $transaction->ip_address; ?></td>
									  <td><?php echo date("d M y", strtotime($transaction->transaction_date)); ?></td>
									</tr>
								<?php 
									$row++;
									}
								}else{
									?>
									<tr>
										<td colspan="8" align="center">No transactions yet!</td>
									</tr>
									
									<?php 
								}
									?>
									
								  </tbody>
								</table>
							</div>
							<!-- /.x_body -->
							<div class="x_footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/transactions');?>'" class="uppercase">View All Transactions</a>
							</div>
							<!-- /.x_footer -->
							
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-md-8 col-sm-8 col-xs-12">
						<!-- quick email widget -->
						<div class="x_panel ">
							<div class="x_title">
								<h2><i class="fa fa-envelope"></i> Quick Email</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li class="pull-right">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</li>
									
								</ul>
								<div class="clearfix"></div>
								<div id="success-message"></div>
								<div class="error-message"></div>
							</div>
							
							<div class="x_content">
								<form action="<?php echo base_url('message/new_message_validation'); ?>" id="message_form" name="message_form" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
									<div class="form-group">
										<select name="address_book" class="form-control select2" style="width: 100%;" id="address_book">
											<option value="0">Select Recipient</option>
											
												<optgroup label="Users">
												<?php
													$this->db->from('users');
													$this->db->order_by('id','desc');
													$result = $this->db->get();
													if($result->num_rows() > 0) {
														foreach($result->result_array() as $row){
															echo '<option value="'.$row['first_name'].' '.$row['last_name'].' - '.$row['username'].'" >'.$row['first_name'].' '.$row['last_name'].' - '.$row['username'].'</option>';
															
														}
													}
												?>
												</optgroup>
												
										</select>
										<input type="hidden" name="sender_name" id="name" value="<?php echo $admin_name; ?>">
										<input type="hidden" name="sender_username" id="username" value="<?php echo $admin_username; ?>">
									</div>
									<div class="form-group">
										<input class="form-control" name="message_subject" id="message_subject" placeholder="Subject:">
									</div>
									<div class="form-group message-body">
										<textarea name="message_details" id="message_details" class="form-control message_details" style="width: 100%; height: 85px;" placeholder="Message">
										</textarea>
										
									</div>
									<div class="form-group">
										<button type="button" class="pull-right btn btn-default" onclick="javascript:newMessage();" id="sendEmail">
										Send
										<i class="fa fa-arrow-circle-right"></i>
										</button>
									</div>
								</form>
							</div>
							
						</div>
					</div>

					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="x_panel <?php echo $activity_class; ?>">
							<div class="x_title">
								<h2>Recent Activities</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li class="pull-right">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</li>
									
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
								<div class="list-group">
									<?php echo $activity_group; ?>										
								</div>
							</div>
							
						</div>
					</div>

				</div>
				
				
				<div class="row">
					
					<div class="col-md-6 col-sm-6 col-xs-12">
						<!-- Latest Logins -->
						<div class="x_panel ">
							<div class="x_title">
								<h2>Latest Logins</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li class="pull-right">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</li>
									
								</ul>
								<div class="clearfix"></div>
							</div>
							
							<div class="x_content">
								
								<table class="table table-striped">
								  <thead>
									<tr>
									  <th>#</th>
									  <th>IP Address</th>
									  <th>Username</th>
									 
									  <th>Date</th>
									</tr>
								  </thead>
								  <tbody>
								 <?php 
								 
								if($logins_array){
									$row = 1;
									foreach($logins_array as $login){
										
								 ?>
									<tr>
									  <th scope="row"><?php echo $row; ?></th>
									  <td><?php echo $login->ip_address; ?></td>
									  
									  <td><?php echo $login->username; ?></td>
									  
									  <td><?php echo date("F j, Y, g:i a", strtotime($login->login_time)); ?></td>
									</tr>
								<?php 
									$row++;
									}
								}else{
									?>
									<tr>
										<td colspan="4" align="center">No logins yet!</td>
									</tr>
									
									<?php 
								}
									?>
									
								  </tbody>
								</table>
							</div>
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/logins');?>'" class="uppercase">View All Logins</a>
							</div>
							<!-- /.box-footer -->
						</div>
						<!-- /.box Latest Logins-->
					</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12">
						<!-- Latest Portfolios -->
						<div class="x_panel ">
							<div class="x_title">
								<h2>Latest Failed Logins</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li class="pull-right">
										<a class="collapse-link">
											<i class="fa fa-chevron-up"></i>
										</a>
									</li>
									
								</ul>
								<div class="clearfix"></div>
							</div>
							
							<div class="x_content">
								
								<table class="table table-striped">
								  <thead>
									<tr>
									  <th>#</th>
									  <th>IP Address</th>
									  <th>Username</th>
									  
									  <th>Date</th>
									</tr>
								  </thead>
								  <tbody>
								 <?php 
								 
								if($failed_logins_array){
									$row = 1;
									foreach($failed_logins_array as $login){
									
								 ?>
									<tr>
									  
									   <th scope="row"><?php echo $row; ?></th>
									  <td><?php echo $login->ip_address; ?></td>
									  
									  <td><?php echo $login->username; ?></td>
									 
									  <td><?php echo date("F j, Y, g:i a", strtotime($login->attempt_time)); ?></td>
									</tr>
								<?php 
									$row++;
									}
								}else{
									?>
									<tr>
										<td colspan="4" align="center">No Failed Logins yet!</td>
									</tr>
									
									<?php 
								}
									?>
									
								  </tbody>
								</table>
							</div>
							<!-- /.box-body -->
							<div class="box-footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin/logins');?>'" class="uppercase">View All Failed Logins</a>
							</div>
							<!-- /.box-footer -->
						</div>
						  <!-- /.Latest Portfolios-->
					</div>


				</div>
				
					
			</div>
        </div>
        <!-- /page content -->

		
		

		
	<!-- View User -->
	<div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
	




