
		
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
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'" title="Dashboard">
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
										
									</ul>
									<!-- /Nav tabs -->
									
									
									<!-- Tab panes -->
									<div class="tab-content">
									
									
										<!-- Tab1 TRANSACTIONS -->
										<div role="tabpanel" class="tab-pane active" id="tab1">
										
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
																<th>Reference</th>
																<th>Amount</th>
																<th>Shipping & Handling</th>
																<th>Total</th>
																
																<th>Payment Status</th>
																<th>Date</th>	
																<th>#View</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														 
													</table>
													<!-- /transactions table -->
													

												</div>
												<!-- /table-responsive -->
											</div>
											<!-- /container -->
																	
											
										</div>
										<!-- /Tab1 TRANSACTIONS -->
										
										<!-- Tab2 PAYMENTS -->
										<div role="tabpanel" class="tab-pane" id="tab2">
										
											
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
												<div class="table-responsive" >
													<!-- payments-table -->
													<table id="payments-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Reference</th>
																<th>Total Amount</th>
																<th>Payment Method</th>
																<th>Date</th>	
															</tr>
														</thead>
														<tbody>
														</tbody>
														 
													</table>
													<!-- /payments table -->
															

												</div>
												<!-- /table-responsive -->
											</div>
											<!-- /container -->
											
										
										</div>
										<!-- /Tab2 PAYMENTS -->
										
										
										
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
	

