
		
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
												<i class="fa fa-th-list"></i> <?php echo $pageTitle;?>
											</li>
																					
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
				
							</div>
							
							<!-- .x_content -->
							<div class="x_content">
							
							<!-- delete button container -->
							
										
							<!-- container -->
							<div class="container">
								<!-- table-responsive -->
								<div class="table-responsive list-tables" >
									<!-- orders-table -->
									<table id="orders-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Reference</th>
												<th>Total Price</th>
												<th>Number of Items</th>
													
												<th>Payment</th>
												<th>Shipping</th>
												<th>Date</th>
												<th>#View</th>		
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
		
	
		
	<!-- View Order -->
	<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					
					<h1 align="center" id="headerTitle"></h1>
					
					<h5 align="center"><strong><i class="fa fa-calendar-o" aria-hidden="true"></i> </strong><span id="orderDate"></span></h5>
					
				</div>
				<div class="modal-body">
					<div class="scrollable-md">
						<table class="display table-striped table-bordered" width="100%">
							
							<tr>
								<th class="text-right" style="padding-right: 2%;">
									<h5><strong>Delivery <i class="fa fa-calendar" aria-hidden="true"></i> </strong></h5>
								</th>	
								<td>
									<h5><span id="view-delivery-date" ></span></h5>
								</td>	
							</tr>
							
							<tr>
								<th class="text-right" style="padding-right: 2%;">
									<h5><strong>Description <i class="fa fa-align-justify" aria-hidden="true"></i></strong></h5>
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
	

		
		