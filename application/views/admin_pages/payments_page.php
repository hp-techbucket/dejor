
		
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
						<!-- .x_panel -->
						<div class="x_panel">
							<div class="x_title">
								<h2><?php echo $pageTitle;?></h2>
							   
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
												<i class="fa fa-money"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												
												<a href="#" data-toggle="modal" data-target="#addPaymentModal" title="Add Transaction"><i class="fa fa-plus"></i> Add Payment</a>
											</li>
																							
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
				
							</div>
							
							<!-- .x_content -->
							<div class="x_content">
								
								<!-- .nav-tabs-custom -->
								<div class="nav-tabs-custom">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="active">
											<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4><i class="fa fa-money"></i> Payments</h4></a>
										</li>
										<li role="presentation">
											<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4><i class="fa fa-th-list"></i> Payment Methods</h4></a>
										</li>	
										
									</ul>
									<!-- /Nav tabs -->
								
									<!-- Tab panes -->
									<div class="tab-content">
									
										<!-- Tab1 PAYMENTS -->
										<div role="tabpanel" class="tab-pane active" id="tab1">
															
											<?php
												//start multi delete form
												$delete_form_attributes2 = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
												echo form_open('admin/multi_delete',$delete_form_attributes2);
												//hidden item - model name
												$hidden2 = array('model' => 'payments',);	
												echo form_hidden($hidden2);	
											?>
													
											<!-- delete button container -->
											<div class="container">
												<div class="row">
													
													<div class="col-xs-12">
													
														<div class="notif"></div>
														<div class="errors"></div>
													</div>
												</div>
											</div>
											<!-- /delete button container -->
														
											<!-- container -->
											<div class="container">
												<!-- table-responsive -->
												<div class="table-responsive list-tables" >
													<!-- payments-table -->
													<table id="payments-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																
																<th width="15%">
																	<div class="controls">
																		<?php echo img('assets/images/icons/crookedArrow.png');?>
																		<!-- Check all button -->
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i></button>
																		<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#paymentDeleteModal" id="" ><i class="fa fa-trash-o"></i></button>
																		
																	</div>
																</th>
																
																<th>Total Amount</th>
																<th>Payment Method</th>
																<th>Customer</th>
																<th>Date</th>								
																		
															</tr>
														</thead>
														<tbody>
														</tbody>
														 
													</table>
													<!-- /payments table -->
																				
													<!-- Multi Delete Modal -->
													<div class="modal fade" id="paymentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
															
															<input type="button" onclick="multiToggleDelete(this)" class="btn btn-danger" value="Delete">
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
											<!-- /container -->
											
										</div>
										<!-- /Tab1 PAYMENTS -->
										
										<!-- Tab1 PAYMENT METHODS-->
										<div role="tabpanel" class="tab-pane" id="tab2">
																									
											<?php
												//start multi delete form
												$delete_form_attributes3 = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
												echo form_open('admin/multi_delete',$delete_form_attributes3);
												//hidden item - model name
												$hidden3 = array('model' => 'payment_methods',);	
												echo form_hidden($hidden3);	
											?>
													
											<!-- delete button container -->
											<div class="container">
												<div class="row">
													
													<div class="col-xs-12">
													
														<div class="notif"></div>
														<div class="errors"></div>
													</div>
												</div>
											</div>
											<!-- /delete button container -->
														
											<!-- container -->
											<div class="container">
												<!-- table-responsive -->
												<div class="table-responsive list-tables" >
													<!-- payment-methods-table -->
													<table id="payment-methods-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																
																<th width="2%">
																	<div class="controls">
																		<?php echo img('assets/images/icons/crookedArrow.png');?>
																		<!-- Check all button -->
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i></button>
																		<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#methodDeleteModal" id="" ><i class="fa fa-trash-o"></i></button>
																		
																	</div>
																</th>
																
																<th width="" align="left">Method</th>
																
																		
															</tr>
														</thead>
														<tbody>
														</tbody>
														 
													</table>
													<!-- /payments methods table -->
																				
													<!-- Multi Delete Modal -->
													<div class="modal fade" id="methodDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
															
															<input type="button" onclick="multiToggleDelete(this)" class="btn btn-danger" value="Delete">
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
											<!-- /container -->

										</div>
										<!-- /Tab2 PAYMENT METHODS-->
									
									</div>
									<!-- /Tab panes -->
						
								</div>
								<!-- /nav-tabs-custom -->
									
								
							</div>
							<!-- /x_content -->
							
						</div>
						<!-- /x_panel -->
						
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->


		


	<!-- ADD PAYMENT -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/add_payment'); ?>" id="addPaymentForm" name="addPaymentForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Add New Payment</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="modal-section">
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="existing_orders">Existing Order</label>
									<select name="existing_orders" id="existing_orders" class="form-control">
										<option value="" >Select Existing Order</option>
										<?php
											$this->db->from('orders');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
														
													$users_array = $this->Users->get_user($row['customer_email']);
													$fullname = '';
													if($users_array){
														foreach($users_array as $user){
															$fullname = $user->first_name.' '.$user->last_name;
														}
													}
													echo '<option value="'.$row['reference'].'-'.$row['customer_email'].'" >'.$row['reference'].' - '.$fullname.' ('.$row['customer_email'].')</option>';
												}
											}
										?>
									
									</select>
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="reference">Reference</label>
									<input type="text" name="reference" class="form-control" id="reference" readonly>
								</div>
							</div>
							
							<!-- .form group -->
							<div class="form-group">
							
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="total_price">Total Amount</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" step="0.01" name="total_amount" class="form-control" id="total_amount" readonly>
											
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="payment_method">Payment Method</label>
									<select name="payment_method" id="payment_method" class="form-control">
										<option value="" >Select Payment Method</option>
										<?php
											$this->db->from('payment_methods');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													
													echo '<option value="'.$row['method_name'].'" >'.$row['method_name'].'</option>';
												}
											}
										?>
									
									</select>
											
								</div>
									
							</div>
							<!-- /.form group -->
								
							<!-- .form group -->
							<div class="form-group">
							
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="customer_email">Customer Email</label>
									<select name="customer_email" class="form-control customer_email" id="customer_email" required>
										<option value="" >Select User</option>
										<?php
											$this->db->from('users');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													echo '<option value="'.$row['email_address'].'">'.ucwords($row['first_name'].' '.$row['last_name']).' ('.$row['email_address'].')</option>';			
												}
											}
										?>
									
									</select>
								</div>
								
							</div>
							<!-- /.form group -->
							
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					
					<input type="button" class="btn btn-success" onclick="javascript:addPayment();" value="Add Payment">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Add Payment -->
		


	<!-- UPDATE PAYMENT -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/update_payment'); ?>" id="updatePaymentForm" name="updatePaymentForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Update Payment</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="modal-section">
							
							<!-- .form group -->
							<div class="form-group">
							
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="total_price">Total Amount</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" step="0.01" name="total_amount" class="form-control" id="totalAmount" readonly>
											
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="payment_method">Payment Method</label>
									<select name="payment_method" id="paymentMethod" class="form-control">
										
									</select>
											
								</div>
									
							</div>
							<!-- /.form group -->
								
							<!-- .form group -->
							<div class="form-group">
							
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="customer_email">Customer Email</label>
									<select name="customer_email" class="form-control customer_email" id="customerEmail" required>
										
									</select>
								</div>
								
							</div>
							<!-- /.form group -->
							
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					<input type="hidden" name="payment_id" id="payment_id">
					<input type="button" class="btn btn-primary" onclick="javascript:updatePayment();" value="Update Payment">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Update Payment -->
		



	<!-- ADD PAYMENT METHOD -->
	<form action="<?php echo base_url('admin/add_payment_method');?>" id="addPaymentMethodForm" class="form-horizontal form-label-left input_mask" name="addPaymentMethodForm" method="post" enctype="multipart/form-data">
		<div class="modal fade" id="addPaymentMethodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 align="center">Add New Payment Method</h3>
					</div>
				
					<div class="modal-body">
						<div class="form_errors"></div>
						<div class="">

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Payment Method Name</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									
									<input type="text" name="method_name" class="form-control" id="method_name" placeholder="Payment Method Name">
									
								</div>	
							</div>
									
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="button" class="btn btn-primary" onclick="javascript:addPaymentMethod();" value="Add Payment Method">
					
					</div>
				</div>
			</div>
		</div>	
	</form>		
	<!-- Add PAYMENT_METHOD -->
					

	<!-- Edit PAYMENT_METHOD -->
	<form action="<?php echo base_url('admin/update_payment_method');?>" id="updatePaymentMethodForm" name="updatePaymentMethodForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
		<div class="modal fade" id="editPaymentMethodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 align="center" id="method"></h3>
					</div>
					<div class="modal-body">
						
						<div class="form-errors"></div>
						
						<div class="">

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Payment Method Name</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									
									<input type="text" name="method_name" class="form-control" id="methodName" placeholder="Payment Method Name">
									
								</div>	
							</div>
									
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="hidden" name="methodID" id="methodID">
									
						<input type="button" class="btn btn-primary" onclick="javascript:updatePaymentMethod();" value="Update Payment Method">
					
					</div>
				</div>
			</div>
		</div>	
	</form>		
	<!-- /Edit PAYMENT METHOD -->
		
