
		
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
												<i class="fa fa-exchange" aria-hidden="true"></i> <?php echo $pageTitle;?>
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
											<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4><i class="fa fa-exchange" aria-hidden="true"></i> Transactions</h4></a>
										</li>
										<li role="presentation">
											<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4><i class="fa fa-money"></i> Payments</h4></a>
										</li>
										<li role="presentation">
											<a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"><h4><i class="fa fa-th-list"></i> Payment Methods</h4></a>
										</li>	
										
									</ul>
									<!-- /Nav tabs -->
									
									
									<!-- Tab panes -->
									<div class="tab-content">
									
									
										<!-- Tab1 TRANSACTIONS -->
										<div role="tabpanel" class="tab-pane active" id="tab1">
										
																	
											<?php
												//start multi delete form
												$delete_form_attributes = array('class' => 'transaction_delete_form','id' => 'transaction_delete_form', 'role' => 'form');
												echo form_open('admin/multi_delete',$delete_form_attributes);
												//hidden item - model name
												$hidden = array('model' => 'transactions',);	
												echo form_hidden($hidden);	
											?>
													
											<!-- container -->
											<div class="container">
												<div class="row">
													
													<div class="col-xs-12">
													
														<div class="notif"></div>
														<div class="errors"></div>
													</div>
												</div>
											</div>
											<!-- /container -->
														
											<!-- container -->
											<div class="container">
												<!-- table-responsive -->
												<div class="table-responsive list-tables" >
													<!-- transactions-table -->
													<table id="transactions-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																
																<th width="15%">
																	<div class="controls">
																		<?php echo img('assets/images/icons/crookedArrow.png');?>
																		<!-- Check all button -->
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
																		<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#transactionDeleteModal" id="" ><i class="fa fa-trash-o"></i> Delete</button>
																		
																	</div>
																</th>
																
																<th>Amount</th>
																<th>Shipping & Handling</th>
																<th>Total</th>
																<th>Customer</th>
																<th>Payment Status</th>
																<th>Date</th>								
																		
															</tr>
														</thead>
														<tbody>
														</tbody>
														 
													</table>
													<!-- /transactions table -->
																				
													<!-- Multi Delete Modal -->
													<div class="modal fade" id="transactionDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
										<!-- /Tab1 TRANSACTIONS -->
										
										<!-- Tab2 PAYMENTS -->
										<div role="tabpanel" class="tab-pane" id="tab2">
										
														
											<?php
												//start multi delete form
												$delete_form_attributes2 = array('class' => 'payment_delete_form','id' => 'payment_delete_form', 'role' => 'form');
												echo form_open('admin/multi_delete',$delete_form_attributes2);
												//hidden item - model name
												$hidden2 = array('model' => 'payments',);	
												echo form_hidden($hidden2);	
											?>
													
											<!-- container -->
											<div class="container">
												<div class="row">
													
													<div class="col-xs-12">
													
														<div class="notif"></div>
														<div class="errors"></div>
													</div>
												</div>
											</div>
											<!-- /container -->
														
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
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
																		<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#paymentDeleteModal" id="" ><i class="fa fa-trash-o"></i> Delete</button>
																		
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
										<!-- /Tab2 PAYMENTS -->
										
										
										
										
										<!-- Tab3 PAYMENT METHODS-->
										<div role="tabpanel" class="tab-pane" id="tab3">
											
											<?php
												//start multi delete form
												$delete_form_attributes3 = array('class' => 'method_delete_form','id' => 'method_delete_form', 'role' => 'form');
												echo form_open('admin/multi_delete',$delete_form_attributes3);
												//hidden item - model name
												$hidden3 = array('model' => 'payment_methods',);	
												echo form_hidden($hidden3);	
											?>
												
											<!-- container -->
											<div class="container">
												<div class="row">
													<div class="col-xs-12">
													
														<a class="btn btn-default btn-xs pull-right" href="#" data-toggle="modal" data-target="#addPaymentMethodModal" title="Add Payment Method"><i class="fa fa-plus"></i> Add Payment Method</a>
													</div>
												</div>
												
												<div class="row">
													
													<div class="col-xs-12">
													
														<div class="notif"></div>
														<div class="errors"></div>
													</div>
												</div>
											</div>
											<!-- /container -->
														
											<!-- container -->
											<div class="container">
												<!-- table-responsive -->
												<div class="table-responsive list-tables" >
													<!-- payment-methods-table -->
													<table id="payment-methods-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																
																<th width="10%">
																	<div class="controls">
																		<?php echo img('assets/images/icons/crookedArrow.png');?>
																		<!-- Check all button -->
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
																		<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#methodDeleteModal" id="" ><i class="fa fa-trash-o"></i> Delete</button>
																		
																	</div>
																</th>
																
																
																		
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
										<!-- /Tab3 PAYMENT METHODS-->	
										
										
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


		
	<!-- View Transaction -->
	<div class="modal fade" id="viewTransactionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="headerTitle"></h3>
				</div>
				<div class="modal-body">
					<div class="">
						<div id="view-details"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>
			</div>
		</div>
	</div>	
	<!-- View Transaction -->	
	




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
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="method_name">Payment Method Name</label>
									<input type="text" name="method_name" class="form-control" id="method_name" placeholder="Enter a name (e.g Credit Card, Western Union, PayPal, etc)">
									
								</div>	
							</div>
									
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="button" class="btn btn-success" onclick="javascript:addPaymentMethod();" value="Add">
					
					</div>
				</div>
			</div>
		</div>	
	</form>		
	<!-- Add PAYMENT METHOD -->
					

	<!-- Edit PAYMENT METHOD -->
	<form action="<?php echo base_url('admin/update_payment_method');?>" id="updatePaymentMethodForm" name="updatePaymentMethodForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
		<div class="modal fade" id="editPaymentMethodModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 align="center" id="method"></h3>
					</div>
					<div class="modal-body">
						
						<div class="form-errors"></div>
						
						<div class="">

							<div class="form-group">
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="method_name">Name</label>
									<input type="text" name="method_name" class="form-control" id="methodName" >
									
									
								</div>	
							</div>
									
						</div>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<input type="hidden" name="methodID" id="methodID">
									
						<input type="button" class="btn btn-primary" onclick="javascript:updatePaymentMethod();" value="Update">
					
					</div>
				</div>
			</div>
		</div>	
	</form>		
	<!-- /Edit PAYMENT METHOD -->
		
