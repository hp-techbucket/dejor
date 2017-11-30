
		
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
												<i class="fa fa-th-list"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="!#" class="add_order" data-toggle="modal" data-target="#addOrderModal" title="Add Order"><i class="fa fa-plus"></i> Add Order</a>
											</li>
																						
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
				
							</div>
							
							<!-- .x_content -->
							<div class="x_content">
								
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'orders',);	
								echo form_hidden($hidden);	
							?>
									
							<!-- delete button container -->
							<div class="container">
								<div class="row">
									
									<div class="col-xs-12">
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
										
							<!-- container -->
							<div class="container">
								<!-- table-responsive -->
								<div class="table-responsive list-tables" >
									<!-- orders-table -->
									<table id="orders-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width="15%">
													<div class="controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm " title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
												</th>
												
												<th>Total Price</th>
												<th>Number of Items</th>
												<th>Customer</th>	
												<th>Payment</th>
												<th>Shipping</th>
												<th>Date</th>
												<th>Updated</th>
												<th>#Edit</th>		
											</tr>
										</thead>
										<tbody>
										</tbody>
										 
									</table>
									<!-- /orders-table -->
									
								</div>
								<!-- /table-responsive -->
							</div>
							<!-- /container -->
													
								
							</div>
							<!-- /x_content -->
							
						</div>
						<!-- /x_panel -->
						
					</div>
				</div>
			</div>
        </div>
        <!-- /page content -->
		
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

		
	<!-- View Order -->
	<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					
					<h1 align="center" id="headerTitle"></h1><br/>
					<h5>
						<strong>Order Date:</strong> <span id="orderDate"></span>
					</h5>
					<h5>
						<strong>Estimated Delivery Date <i class="fa fa-calendar" aria-hidden="true"></i> </strong> <span id="view-delivery-date" ></span>
					</h5>
					<h5 align="center" >
						
						
					</h5>
				</div>
				<div class="modal-body">
					<div class="scrollable">
						<table class="display table-striped table-bordered" width="100%">
							
							<tr>
								
								<th class="text-right" style="padding-right: 2%;">
									<h5>Customer <span class="glyphicon glyphicon-user"></span> </h5>
								</th>
								<td>
									<h5>
										<span id="view-customer" ></span>
									</h5>
								</td>	
							</tr>
							
							<tr>
								<th class="text-right" style="padding-right: 2%;">
									<h5><strong>Description <i class="fa fa-comment" aria-hidden="true"></i></strong></p>
								</th>	
								<td>
									<h5><span id="view-order-description" ></span></h5>
								</td>	
							</tr>
							
							<tr>
								<th class="text-right" style="padding-right: 2%;">
									<h5><strong>Total Price <i class="fa fa-money" aria-hidden="true"></i> </strong></h5>
								</th>
								
								<td>
									<h3>
										<span class="">
											$<span id="view-total-price" ></span>
										</span>
									</h3>
								</td>	
							</tr>
							<tr>
								<th class="text-right" style="padding-right: 2%;">
									<h5><strong>Payment <i class="fa fa-money" aria-hidden="true"></i> </strong></h5>
								</th>
								
								<td>
									<h5>
										<span id="view-payment-status" ></span>
									</h5>
								</td>	
							</tr>
							<tr>
								<th class="text-right" style="padding-right: 2%;">
									<h5><strong>Shipping <i class="fa fa-truck" aria-hidden="true"></i> </strong></h5>
								</th>
								
								<td>
									<h5>
										
										<span id="view-shipping-status" ></span>
									</h5>
								</td>
							</tr>
							
						</table>
					</div>					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Order -->	
	


	<!-- ADD ORDER -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/add_order'); ?>" id="addOrderForm" name="addOrderForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog modal-lg" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Add New Order</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="order-section">
							
							<!-- ORDER DETAILS -->
							<legend><h3 class="">ORDER</h3></legend>
							
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="reference">Reference</label>
									<input type="text" name="reference" class="form-control" id="reference" value="<?php echo $reference ; ?>" readonly>
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="order_description">Order Description</label>
									<textarea name="order_description" id="order_description" class="form-control" placeholder="eg. One red Toyota Yaris, One black BMW 3 series"></textarea>
								</div>
							</div>
								
							<!-- .form group -->
							<div class="form-group">
							
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="total_price">Price</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" step="0.01" name="total_price" class="form-control" id="total_price" required>
											
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="num_of_items">Number of items</label>
									<input type="number" name="num_of_items" class="form-control" id="num_of_items" required>
											
								</div>
									
							</div>
							<!-- /.form group -->
								
							<!-- .form group -->
							<div class="form-group">
							
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="customer_email">Customer Email</label>
									<select name="customer_email" class="form-control customer_email" id="customer_email" onchange="getCustomerDetails(this, '<?php echo base_url('admin/get_customer_details');?>')" required>
										<option value="" selected="selected">Select User</option>
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
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="customer_contact_phone">Customer Tel</label>
									<input type="text" name="customer_contact_phone" class="form-control" id="customer_contact_phone"  readonly>
									
								</div>	
							</div>
							<!-- /.form group -->
							<!-- /ORDER DETAILS -->
						</div>
						
						<div class="order-section">
							
							<!-- SHIPPING DETAILS -->
							<legend><h3 class="">SHIPPING</h3></legend>
							
							<!-- .form group -->
							<div class="form-group">
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="shipping_method">Shipping Method</label>
									<select name="shipping_method" class="form-control shipping_method" id="shipping_method" onchange="getShippingCost(this, '<?php echo base_url('admin/shipping_method_details');?>')">
										<option value="" selected="selected">Select Shipping Method</option>
										<?php
										$this->db->from('shipping_methods');
										$this->db->order_by('id');
										$result = $this->db->get();
										if($result->num_rows() > 0) {
											foreach($result->result_array() as $row){
												echo '<option value="'.ucwords($row['id']).'" '.$d.'>'.ucwords($row['shipping_company']).'</option>';
											}
										}
										?>
									</select>	
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="shipping_fee">Shipping Fee</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" name="shipping_fee" class="form-control" id="shipping_fee" readonly>
											
									</div>
									
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="tax">Tax</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" name="tax" class="form-control" id="tax" >
											
									</div>
									
											
								</div>
							</div>
							<!-- /.form group -->
							
							<!-- .form group -->
							<div class="form-group">
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="origin_city">Sender City</label>
									<input type="text" name="origin_city" class="form-control" id="origin_city" placeholder="New Jersey">
									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="origin_country">Sender Country</label>
									<select name="origin_country" class="form-control" id="origin_country">
										<option value="" selected="selected">Select Sender Country</option>
											<?php 
												$this->db->from('countries');
												$this->db->order_by('id');
												$result = $this->db->get();
												if($result->num_rows() > 0) {
													foreach($result->result_array() as $row){
														//AUTO SELECT DEFAULT
														$default = (strtolower($row['name']) =='united states')?'selected':'';
														echo '<option value="'.$row['name'].'" '.$default.'>'.ucwords($row['name']).'</option>';			
													}
												}
											//echo $country_options; 
											
											?>
									</select>
								</div>
							</div>
							<!-- /.form group -->
							
							
							<!-- .form group -->
							<div class="form-group">
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="destination_city">Destination City</label>
									<input type="text" name="destination_city" class="form-control" id="destination_city" placeholder="Lagos">
									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="destination_country">Destination Country</label>
									 
									<select name="destination_country" class="form-control" id="destination_country">
										<option value="" selected="selected">Select Destination Country</option>
											<?php 
												$this->db->from('countries');
												$this->db->order_by('id');
												$result = $this->db->get();
												if($result->num_rows() > 0) {
													foreach($result->result_array() as $row){
														echo '<option value="'.$row['name'].'">'.ucwords($row['name']).'</option>';			
													}
												}
											//echo $country_options; 
											
											?>
									</select>
									
								</div>
							</div>
							<!-- /.form group -->
							
							
							<!-- .form group -->
							<div class="form-group">
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="shipping_status">Shipping Status</label>
									<select name="shipping_status" class="form-control" id="shipping_status">
										<option value="">Select Shipping Status</option>
										<option value="0">Pending</option>
										<option value="1">Shipped</option>
									</select>	
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="estimated_delivery_date" class="hidden">Estimated Delivery Date</label>
									<div class="control-group">
										<div class="controls">
											<div class="input-prepend input-group delivery_date hidden">
											  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
											  <input type="text" name="estimated_delivery_date" id="estimated_delivery_date" class="date-picker  form-control" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /.form group -->
							
							<!-- /SHIPPING DETAILS -->
						</div>
						
						<div class="order-section">
							<!-- TRANSACTION DETAILS -->
							<legend><h3 class="">TRANSACTION</h3></legend>
							
							<!-- .form group -->
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="payment_status">Payment Status</label>
									<select name="payment_status" class="form-control" id="payment_status">
										<option value="">Select Payment Status</option>
										<option value="0">Pending</option>
										<option value="1">Paid</option>
									</select>	
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="payment_method" class="hidden">Payment Method</label>
									<select name="payment_method" id="payment_method" class="form-control hidden payment_method">
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

							<!-- /TRANSACTION DETAILS -->
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					
					<input type="button" class="btn btn-success" onclick="javascript:addOrder();" value="Add Order">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Add Order -->
		

	<!-- Edit Modal -->
	
	<form action="<?php echo base_url('admin/update_order'); ?>" id="updateOrderForm" name="updateOrderForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="edit-header" align="center"></h3>
				</div>
				<div class="modal-body">
				
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="order-section">
							
							<!-- ORDER DETAILS -->
							<legend><h3 class="">ORDER</h3></legend>
							
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="reference">Reference</label>
									<input type="text" name="reference" class="form-control" id="ref"  readonly>
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="order_description">Order Description</label>
									<textarea name="order_description" id="orderDescription" class="form-control" ></textarea>
								</div>
							</div>
								
							<!-- .form group -->
							<div class="form-group">
							
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="total_price">Price</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" step="0.01" name="total_price" class="form-control" id="totalPrice">
											
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="num_of_items">Number of items</label>
									<input type="number" name="num_of_items" class="form-control" id="numOfItems" required>
											
								</div>
									
							</div>
							<!-- /.form group -->
								
							<!-- .form group -->
							<div class="form-group">
							
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="customer_email">Customer Email</label>
									<select name="customer_email" class="form-control customerEmail" id="customerEmail" onchange="getCustomerDetails(this, '<?php echo base_url('admin/get_customer_details');?>')" >
										
									</select>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="customer_contact_phone">Customer Tel</label>
									<input type="text" name="customer_contact_phone" class="form-control" id="customerContactPhone"  readonly>
									
								</div>	
							</div>
							<!-- /.form group -->
							<!-- /ORDER DETAILS -->
						</div>
						
						<div class="order-section">
							
							<!-- SHIPPING DETAILS -->
							<legend><h3 class="">SHIPPING</h3></legend>
							
							<!-- .form group -->
							<div class="form-group">
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="shipping_method">Shipping Method</label>
									<select name="shipping_method" class="form-control shipping_method" id="shippingMethod" data-href="admin/shipping_method_details" onchange="getShippingCost(this, '<?php echo base_url('admin/shipping_method_details');?>')">
										
									</select>	
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="shipping_fee">Shipping Fee</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" name="shipping_fee" class="form-control" id="shippingFee" readonly>
											
									</div>
									
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="tax">Tax</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" name="tax" class="form-control" id="tx" >
											
									</div>
									
											
								</div>
							</div>
							<!-- /.form group -->
							
							<!-- .form group -->
							<div class="form-group">
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="origin_city">Sender City</label>
									<input type="text" name="origin_city" class="form-control" id="originCity" >
									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="origin_country">Sender Country</label>
									<select name="origin_country" class="form-control" id="originCountry">
										
									</select>
								</div>
							</div>
							<!-- /.form group -->
							
							
							<!-- .form group -->
							<div class="form-group">
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="shipping_fee">Destination City</label>
									<input type="text" name="destination_city" class="form-control" id="destinationCity">
									
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="destination_country">Destination Country</label>
									<select name="destination_country" class="form-control" id="destinationCountry">
										
									</select>
								</div>
							</div>
							<!-- /.form group -->
							
							
							<!-- .form group -->
							<div class="form-group">
								
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="shipping_status">Shipping Status</label>
									<select name="shipping_status" class="form-control" id="shippingStatus">
										
									</select>	
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="estimated_delivery_date" class="hidden">Estimated Delivery Date</label>
									<div class="control-group">
										<div class="controls">
											<div class="input-prepend input-group delivery_date hidden">
											  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
											  <input type="text" name="estimated_delivery_date" id="estimatedDeliveryDate" class="date-picker  form-control" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /.form group -->
							<!-- /SHIPPING DETAILS -->
						</div>
						
						<div class="order-section">
							<!-- TRANSACTION DETAILS -->
							<legend><h3 class="">TRANSACTION</h3></legend>
							
							<!-- .form group -->
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="payment_status">Payment Status</label>
									<select name="payment_status" class="form-control" id="paymentStatus">
										
									</select>	
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="payment_method" class="hidden">Payment Method</label>
									<select name="payment_method" id="paymentMethod" class="form-control hidden payment_method">
										
									</select>	
								</div>
								
							</div>
							<!-- /.form group -->

							<!-- /TRANSACTION DETAILS -->
						</div>
						
						
					</div>
					  
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="order_id" id="order_id">
					<input type="hidden" name="shipping_id" id="shipping_id">
					<input type="hidden" name="transaction_id" id="transaction_id">
					<input type="hidden" name="payment_id" id="payment_id">
					<input type="button" class="btn btn-primary" onclick="javascript:updateOrder();" value="Update">
					
				</div>
			</div>
		</div>
	</div>	
	</form>		
	<!-- /Edit Modal -->
			



		
		