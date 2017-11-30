<?php
		if($user_array){
			
			foreach($user_array as $user){
?>
		
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
								<div id="trigger_id"><?php echo $message;?></div>
							</div>
							<div class="x_content">
								<div class="row top_tiles">
									<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/transactions/');?>'">
											<div class="tile-stats hoverable">
												<div class="icon"><i class="fa fa-exchange"></i></div>
												<div class="count">
													<?php echo $transactions_count ; ?>
												</div>
												<h3>New Transactions</h3>
												<p align="center">
													<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/transactions/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
												</p>
											</div>
										</a>
									</div>
									
									<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/orders/');?>'">
											<div class="tile-stats hoverable">
												<div class="icon"><i class="fa fa-th-list"></i></div>
												<div class="count"><?php echo $orders_count; ?></div>
												<h3><?php echo ($orders_count == 1)?'Order':'Orders';?></h3>
												<p align="center"><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/orders/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a></p>
											</div>
										</a>
									</div>
									<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox/');?>'">
											<div class="tile-stats hoverable">
												<div class="icon"><i class="fa fa-inbox"></i></div>
												<div class="count"><?php echo $messages_unread; ?></div>
												<h3>New Inbox Messages</h3>
												<p align="center"><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a></p>
											</div>
										</a>
									</div>
									<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/sale-enquiries/');?>'">
											<div class="tile-stats hoverable">
												<div class="icon"><i class="fa fa-question-circle"></i></div>
												<div class="count"><?php echo $enquiries_unread; ?></div>
												<h3>New Enquiries</h3>
												<p align="center"><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/enquiries/');?>'" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a></p>
											</div>
										</a>
									</div>
								</div>
								
							</div>
						</div>	
					</div>	
				</div>
				
				
				<div class="row">
					<?php
						$class = 'col-md-12 col-sm-12 col-xs-12';
						if($profile_completion != 100){
							$class = 'col-md-6 col-sm-6 col-xs-12';
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_panel fixed_height_320">
							<div class="x_title">
								<h2>Profile</h2>
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
							
								<?php
									if($profile_completion < 100){
								?>
									<div class="alert alert-warning text-primary">
										You need to complete your account! <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/profile/'" title="Update Profile">Click here</a> to do so.
									</div>
								<?php
									}
								?>
								<h4 align="center">Profile Completion </h4>
								<div class="">
									<div class="progress " style="width: 100%;">
										<div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $profile_completion ; ?>"><?php echo $profile_completion ; ?>% Complete</div>
										
									</div>
									
								</div>
								
								<div class="goal-wrapper">
									<span id="gauge-text" class="gauge-value pull-left">0</span>
									<span class="gauge-value pull-left">%</span>
									<span id="goal-text" class="goal-value pull-right">100%</span>
								</div>	
								
							</div>
							
						</div>
					</div>
					<?php
						}
					?>
					<div class="<?php echo $class ; ?>">
						<div class="x_panel fixed_height_320">
							<div class="x_title">
								<h2>Orders</h2>
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
									  
									  <th>Description</th>
									  <th>Price</th>
									  <th>Quantity</th>
									  <th>Date</th>
									</tr>
								  </thead>
								  <tbody>
								 <?php 
								 
								if($orders_array){
									$row = 1;
									foreach($orders_array as $order){
										
										$currency = '$';
										
								 ?>
									<tr>
									  
									  <td><?php echo $order->reference; ?></td>
									   <td><?php echo substr($order->order_description, 0, 25).'...'; ?></td>
									  <td><?php echo $currency.''.number_format($order->total_price, 0); ?></td>
									  
									  <td><?php echo ($order->num_of_items == 1)? $order->num_of_items.' item': $order->num_of_items.' items'; ?></td>
									  <td><?php echo date("d M y", strtotime($order->order_date)); ?></td>
									</tr>
								<?php 
									$row++;
									}
								}else{
									?>
									<tr>
										<td colspan="5" align="center">No orders yet!</td>
									</tr>
									
									<?php 
								}
									?>
									
								  </tbody>
								</table>
							</div>
							<!-- /.x_body -->
							<div class="x_footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/orders');?>'" class="uppercase">View All Orders</a>
							</div>
							<!-- /.x_footer -->
							
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_panel fixed_height_320">
							<div class="x_title">
								<h2>Latest Listings</h2>
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
									  
									  <th colspan="2">Item</th>
									  
									  <th>Name</th>
									  <th>Listed</th>
									</tr>
								  </thead>
									<tbody>
											  
								<?php
									if($vehicles_array){
											
										foreach($vehicles_array as $vehicle){
											
											$thumbnail =  '';
											
											$filename = FCPATH.'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image;
											if($vehicle->vehicle_image == '' || $vehicle->vehicle_image == null || !file_exists($filename)){
												$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class=" img-circle img-responsive" width="30" height="30" >';
												
											}
											else{
												$thumbnail =  '<img src="'.base_url().'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image.'" class="img-responsive img-rounded" width="80" height="80" />';
											}	
											
											
											$vehicle_name = $vehicle->vehicle_make .' '.$vehicle->vehicle_model;
										?>
										<tr>
											<td width="15%"><?php echo $thumbnail;?></td>
											<td width="25%"><?php echo $vehicle->vehicle_type; ?></td>
											<td width="25%">
												<a href="!#" class="link product-title" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewVehicle(<?php echo$vehicle->id ;?>, 'account/vehicle_details');" title="View <?php echo $vehicle_name ;?>'..'"><?php echo $vehicle_name ;?></a>
											</td>
											<td width="35%">
												<?php echo date("d M y", strtotime($vehicle->date_added)); ?>
											</td>
										</tr>
									<?php 
										
										}
									}else{
										?>
										<tr>
											<td colspan="3" align="center">No listings!</td>
										</tr>
										
										<?php 
									}
										?>
										
									</tbody>
								</table>
							
							</div>
							<!-- /.x_body -->
							<div class="x_footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/vehicles');?>'" class="uppercase">View All Listings</a>
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
									  
									  <th>Amount</th>
									  <th>Status</th>
									   
									  <th>Date</th>
									</tr>
								  </thead>
								  <tbody>
								 <?php 
								 
								if($transactions_array){
									$row = 1;
									foreach($transactions_array as $transaction){
										$fullname = '';
										$currency = '$';
										$user_array = $this->Users->get_user($transaction->email);
										foreach($user_array as $user){
											$fullname = $user->first_name.' '.$user->last_name;
											
										}
								 ?>
									<tr>
									  
									  <td><?php echo $transaction->order_reference; ?></td>
									  
									  <td><?php echo $currency.''.number_format($transaction->total_amount, 0); ?></td>
									  
									  <td><?php echo $transaction->status; ?></td>
									  <td><?php echo date("d M y", strtotime($transaction->created)); ?></td>
									</tr>
								<?php 
									$row++;
									}
								}else{
									?>
									<tr>
										<td colspan="4" align="center">No transactions yet!</td>
									</tr>
									
									<?php 
								}
									?>
									
								  </tbody>
								</table>
							</div>
							<!-- /.x_body -->
							<div class="x_footer text-center">
								<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/transactions');?>'" class="uppercase">View All Transactions</a>
							</div>
							<!-- /.x_footer -->
							
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-md-7 col-sm-7 col-xs-12">
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
												<optgroup label="Customer Support">
													
													<option value="Customer Support - support">Customer Support</option>
												</optgroup>
												<optgroup label="Address Book">
												<?php
													if($address_book_array) {
														foreach($address_book_array as $address){
															echo '<option value="'.$address->receiver_name.' - '.$address->receiver_username.'" >'.$address->receiver_name.'</option>';		
														}
													}else{
														echo '<option value="0" >No addresses</option>';
													}
												?>
												</optgroup>
										</select>
										<input type="hidden" name="receiver_name" id="receiver_name">
										<input type="hidden" name="receiver_email" id="receiver_email">
										<input type="hidden" name="sender_name" id="name" value="<?php echo $fullname; ?>">
										<input type="hidden" name="sender_email" id="username" value="<?php echo $email; ?>">
										<input type="hidden" name="model" id="model" >
									</div>
									<div class="form-group">
										<input class="form-control" name="message_subject" id="message_subject" placeholder="Subject:">
									</div>
									<div class="form-group message-body">
										<textarea name="message_details" id="message_details" class="form-control" style="width: 100%; height: 85px;" placeholder="Message"></textarea>
										
									</div>
									<p class="small">Attach files below (allowed types:pdf, doc, docx, jpg, jpeg and png)</p>
									<div class="input_file_wrap">
										<div class="form-group">
											<div class="fileinput fileinput-new" data-provides="fileinput">
											  <span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Attach file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="documents[]" multiple></span>
											  <span class="fileinput-filename"></span>
											  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
											</div>
										</div>
									</div>
									<p><a href="!#" class="upload_more_button"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
									<div class="form-group">
										<button type="button" class="pull-right btn btn-primary" onclick="javascript:newMessage();" id="sendEmail">
										Send
										<i class="fa fa-arrow-circle-right"></i>
										</button>
									</div>
									
								</form>
							</div>
							
						</div>
					</div>

					<div class="col-md-5 col-sm-5 col-xs-12">
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
				
				<?php echo br(5); ?>
				
					
			</div>
        </div>
        <!-- /page content -->

	
	
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="text-center" id="title"></h3>
			</div>
			<div class="modal-body">
				<div class="scrollable">
					<div class="container col-md-12">
						<div class="row">
							<div class="col-md-7 col-sm-12 col-xs-12">
								<div class="product-image">
									<span id="image"></span>
								</div>
								
							</div>
							
							<div class="col-md-2 col-xs-5 gallery-container nopadding">
								<div class="">
									<span id="gallery"></span>	
								</div>
							</div>
				
							<div class="col-md-3 col-xs-7">

								<h3 class="product-title"><span id="title" ></span></h3>
								
								<div class="product-price">
									<span id="view-price" ></span>
									<span class="small" id="view-old-price" ></span>
								</div>
										  
								<h4><strong><i class="fa fa-calendar" aria-hidden="true"></i></strong> <span id="view-year" ></span></h4>
														  
								<span id="view-colour" ></span>
								
								<?php echo br(2); ?>

							</div>
						</div>	
						
						<hr/>
						
						<!-- .row -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 desc-container">
							
								<!-- .nav nav-pills -->
								<ul class="nav nav-pills">
									<li class="active"><a data-toggle="pill" href="#tab1">DETAILS</a></li>
									<li><a data-toggle="pill" href="#tab2">DESCRIPTION </a></li>
									
								</ul>
								<!-- /.nav nav-pills -->
								
								<!-- .tab-content -->	  
								<div class="tab-content">
								
									<!-- #tab1 -->
									<div id="tab1" class="tab-pane fade in active">
										
										<h5><strong>Type <i class="fa fa-taxi" aria-hidden="true"></i></strong> <span id="view-vehicle-type" ></span></h5>
										
										<h5><strong>Make <i class="fa fa-bus" aria-hidden="true"></i></strong> <span id="view-vehicle-make" ></span></h5>
															  
										<h5><strong>Model <i class="fa fa-code-fork" aria-hidden="true"></i></strong> <span id="view-vehicle-model" ></span></h5>
															  
										<h5><strong>Odometer <i class="fa fa-tachometer" aria-hidden="true"></i></strong> <span id="view-odometer" ></span></h5>
															  
										<h5><strong>VIN <i class="fa fa-id-badge" aria-hidden="true"></i></strong> <span id="view-vin" ></span></h5>
																		  
										<h5><strong>Lot number<i class="fa fa-truck" aria-hidden="true"></i></strong> <span id="view-lot-number" ></span></h5>
										
										<h5><strong>Location <i class="fa fa-thumb-tack" aria-hidden="true"></i></strong> <span id="view-city" ></span> <span id="view-country" ></span></h5>
																  
										<h5><strong>Status <i class="fa fa-sellsy" aria-hidden="true"></i></strong> <span id="view-sale-status" ></span></h5>
																  
										<h5><strong>Discount %<i class="fa fa-percent" aria-hidden="true"></i></strong> <span id="view-discount" ></span></h5>
																  
										<h5><strong>Discount Price <span class="glyphicon glyphicon-usd"></span></strong> <span id="view-discount-price" ></span></h5>
																					  
										<h5><strong>Added <i class="fa fa-calendar" aria-hidden="true"></i></strong> <span id="date-added" ></span></h5>
											
														 
									</div>
									<!-- /#tab1 -->
									
									<!-- #tab2 -->
									<div id="tab2" class="tab-pane fade">
										<p><span class="glyphicon glyphicon-comment"></span> <span id="view-description" ></span></p>
									</div>
									<!-- /#tab2 -->
									
								</div>
								<!-- /.tab-content -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>	
<!-- View Modal -->
	
	
	<!-- View Modal -->
	<div class="modal fade" id="popModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="headerTitle" align="center"></h3>
				</div>
				<div class="modal-body">
					<h4>Welcome to your Account Dashboard</h4>
					<p>You can add, manage and track all your inventory and orders as well as all sale enquiries. Your account is currently <?php echo $percentage_completion ; ?> % complete, so please <a href="<?php echo base_url('account/profile'); ?>"> update your account here.</a></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Modal -->
			
		
	
	<!-- pModal -->
	<!-- The Modal -->
	<div id="pModal" class="custom-modal welcome-modal">
		
		<!-- Modal content -->
		<div class="custom-modal-content modal-sm">
		
			<!-- .modal-header -->
			<div class="custom-modal-header">
				<span class="close-icon close-modal">&times;</span>
			</div>
			<!-- /.modal-header -->
			
			<!-- .modal-body -->
			<div class="custom-modal-body">
				<h3 class="text-center">Welcome to your Account Dashboard</h3>
				<br/>
				<h5>You can add, manage and track all your inventory and orders as well as all your customer enquiries.</h5> 
				<?php
					if($profile_completion < 100){
				?>
				<h5>Your account is currently <?php echo $profile_completion ; ?> % complete, so please <a href="<?php echo base_url('account/profile'); ?>"> update your account here.</a></h5>
				<?php
					}
				?>
				
				<br/>
			</div>
			<!-- /.modal-body -->
			<!-- .modal-footer -->
			<div class="custom-modal-footer">
				<button class="btn btn-default close-modal">Close</button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /Modal content -->
	</div>	
	<!-- imagesModal -->	

<?php
			}
			
		}
?>



