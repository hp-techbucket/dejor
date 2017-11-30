
		
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
												<i class="fa fa-truck"></i> <?php echo $pageTitle;?>
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
											<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4> Shipping</h4></a>
										</li>
										<li role="presentation">
											<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4> Shipping Status</h4></a>
										</li>		
										<li role="presentation">
											<a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"><h4> Shipping Methods</h4></a>
										</li>		
										
									</ul>
									<!-- /Nav tabs -->
							
									<!-- Tab panes -->
									<div class="tab-content">
									
										<!-- Tab1 SHIPPING -->
										<div role="tabpanel" class="tab-pane active" id="tab1">
											
											<?php
											//start multi delete form
											$form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
											echo form_open('admin/multi_delete',$form_attributes);
											//hidden item - model name
											$hidden = array('model' => 'shipping',);	
											echo form_hidden($hidden);	
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
												<!-- shipping-table -->
												<table id="shipping-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
													<thead>
														<tr>
															
															<th width="15%">
																<div class="controls">
																	<?php echo img('assets/images/icons/crookedArrow.png');?>
																	<!-- Check all button -->
																	<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
																	<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#shippingDeleteModal"><i class="fa fa-trash-o"></i> Delete</button>
																	
																</div>
															</th>
															
															<th>Method</th>
															<th>Fee</th>
															<th>Tax</th>
															<th>Status</th>
															<th>Customer</th>
															<th>Date</th>								
															<th>#Edit</th>
																		
														</tr>
													</thead>
													<tbody>
													</tbody>
													 
												</table>
												<!-- /shipping-table -->
																			
												<!-- Multi Delete Modal -->
												<div class="modal fade" id="shippingDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
										<!-- Tab1 SHIPPING -->
										
										
										<!-- Tab2 SHIPPING STATUS -->
										<div role="tabpanel" class="tab-pane" id="tab2">
												<?php
											//start multi delete form
											$form_attributes2 = array('class' => 'multi_delete_form','id' => 'status_delete_form', 'role' => 'form');
											echo form_open('admin/multi_delete',$form_attributes2);
											//hidden item - model name
											$hidden2 = array('model' => 'shipping_status',);	
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
												<!-- shipping-status-table -->
												<table id="shipping-status-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
													<thead>
														<tr>
															
															<th width="15%">
																<div class="controls">
																	<?php echo img('assets/images/icons/crookedArrow.png');?>
																	<!-- Check all button -->
																	<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
																	<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#statusDeleteModal"><i class="fa fa-trash-o"></i> Delete</button>
																	
																</div>
															</th>
															
															<th>Description</th>
															<th>Location</th>
															<th>Customer</th>
															<th>Date</th>								
															<th>#Edit</th>
																		
														</tr>
													</thead>
													<tbody>
													</tbody>
													 
												</table>
												<!-- /shipping-status-table -->
																			
												<!-- Multi Delete Modal -->
												<div class="modal fade" id="statusDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
										<!-- /Tab2 SHIPPING STATUS -->
										
										<!-- Tab3 SHIPPING METHODS -->
										<div role="tabpanel" class="tab-pane" id="tab3">
											
												
											<?php
											//start multi delete form
											$form_attributes3 = array('class' => 'multi_delete_form','id' => 'methods_delete_form', 'role' => 'form');
											echo form_open('admin/multi_delete',$form_attributes3);
											//hidden item - model name
											$hidden3 = array('model' => 'shipping_methods',);	
											echo form_hidden($hidden3);	
										?>
												
										<!-- delete button container -->
										<div class="container">
											<div class="row">
												
												<div class="col-xs-12">
													<a class="btn btn-default btn-xs pull-right" href="#" data-toggle="modal" data-target="#addShippingMethodModal" title="Add Shipping Method"><i class="fa fa-plus"></i> Add Shipping Method</a>
												</div>
											</div>
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
												<!-- shipping-methods-table -->
												<table id="shipping-methods-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
													<thead>
														<tr>
															
															<th width="15%">
																<div class="controls">
																	<?php echo img('assets/images/icons/crookedArrow.png');?>
																	<!-- Check all button -->
																	<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
																	<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#methodsDeleteModal"><i class="fa fa-trash-o"></i> Delete</button>
																	
																</div>
															</th>
															
															<th>Costs</th>
															<th>Duration</th>
																			
															<th>#Edit</th>
																		
														</tr>
													</thead>
													<tbody>
													</tbody>
													 
												</table>
												<!-- /shipping-methods-table -->
																			
												<!-- Multi Delete Modal -->
												<div class="modal fade" id="methodsDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
										<!-- /Tab3 SHIPPING STATUS -->
										
										
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


		
	<!-- View Shipping -->
	<div class="modal fade" id="viewShippingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
					<div id="view-details"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Shipping -->	
	


		
	<!-- View Shipping Details By Reference -->
	<div class="modal fade" id="viewShippingDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="statusTitle"></h3>
				</div>
				<div class="modal-body">
					<div id="view-details-by-reference"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Shipping Details By Reference-->	
	

	<!-- ADD SHIPPING METHOD -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/add_shipping_method'); ?>" id="addShippingMethodForm" name="addShippingMethodForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="addShippingMethodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Add New Shipping Method</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="order-section">
							
							<legend><h3 class="">SHIPPING METHOD</h3></legend>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="shipping_company">Shipping Company</label>
									<input type="text" name="shipping_company" class="form-control" id="shipping_company" >
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="shipping_costs">Shipping Costs</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" step="0.01" name="shipping_costs" class="form-control" id="shipping_costs">
											
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="shipping_duration">Shipping Duration</label>
									<input type="text" name="shipping_duration" class="form-control" id="shipping_duration" >
								</div>
							</div>
							
							
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					
					<input type="button" class="btn btn-success" onclick="javascript:addShippingMethod();" value="Add Shipping Method">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Add SHIPPING METHOD -->
		


	<!-- UPDATE SHIPPING METHOD -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/update_shipping_method'); ?>" id="updateShippingMethodForm" name="updateShippingMethodForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="editShippingMethodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >UPDATE SHIPPING METHOD</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="order-section">
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="shipping_company">Shipping Company</label>
									<input type="text" name="shipping_company" class="form-control" id="shippingCompany" >
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="shipping_costs">Shipping Costs</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="number" step="0.01" name="shipping_costs" class="form-control" id="shippingCosts">
											
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="shipping_duration">Shipping Duration</label>
									<input type="text" name="shipping_duration" class="form-control" id="shippingDuration" >
								</div>
							</div>
							
							
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					
					<input type="hidden" name="shipping_method_id" id="shipping_method_id">
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateShippingMethod();" value="Update Method">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- EDIT SHIPPING METHOD -->
		


	<!-- ADD SHIPPING_STATUS -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/add_shipping_status'); ?>" id="addShippingStatusForm" name="addShippingStatusForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="addShippingStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >Add New Shipping Status</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="order-section">
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="reference">Reference</label>
									<input type="text" name="reference" class="form-control" id="reference" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="status_description">Status Description</label>
									<textarea name="status_description" class="form-control" id="status_description"></textarea>
									
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="location">Location</label>
									<input type="text" name="location" class="form-control" id="location">
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="customer_email">Customer Email</label>
									<input type="text" name="customer_email" class="form-control" id="customer_email" readonly>
								</div>
							</div>
							
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					
					<input type="button" class="btn btn-success" onclick="javascript:addShippingStatus();" value="Add Shipping Status">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Add SHIPPING STATUS -->
		


	<!-- UPDATE SHIPPING_STATUS -->
	<!-- .modal -->
	<form action="<?php echo base_url('admin/update_shipping_status'); ?>" id="updateShippingStatusForm" name="updateShippingStatusForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="editShippingStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" >UPDATE SHIPPING STATUS</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="scrollable">
						
						<div class="order-section">
							
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="reference">Reference</label>
									<input type="text" name="reference" class="form-control" id="ref" readonly>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="status_description">Status Description</label>
									<textarea name="status_description" class="form-control" id="statusDescription"></textarea>
									
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="location">Location</label>
									<input type="text" name="location" class="form-control" id="locatn">
								</div>
							</div>
								
							<div class="form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="customer_email">Customer Email</label>
									<input type="text" name="customer_email" class="form-control" id="customerEmail" readonly>
								</div>
							</div>
							
							
						</div>
						
						
					</div>
					
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>	
					<input type="hidden" name="shipping_status_id" id="shipping_status_id">
					<input type="button" class="btn btn-primary" onclick="javascript:updateShippingStatus();" value="Update Status">	
				</div>
				<!-- /.modal-footer -->
				
				</form>
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- Edit SHIPPING STATUS -->
		

		
	<!-- View SHIPPING STATUS -->
	<div class="modal fade" id="viewShippingStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="viewShippingStatusTitle"></h3>
				</div>
				<div class="modal-body">
					
					<div id="view-shipping-status-details"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View SHIPPING STATUS -->	
	




