
		
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
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'" title="Dashboard">
													<i class="fa fa-home"></i> Dashboard
												</a>
											</li>						
											<li class="active">
												<i class="fa fa-commenting"></i> <?php echo $pageTitle;?>
											</li>
																									
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- reviews-table -->
										<table id="reviews-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>Reviewer</th>
													<th>Rating</th>
													
													<th>Location</th>
													<th>Date</th>
													<th>View</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /reviews-table -->
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
							</div>
						</div>
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
	
		<!-- View Modal -->
			<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="headerTitle" align="center"></h3>
					</div>
					<div class="modal-body">
						<table class="table" style="width: 100%">
							
							<tr>
								<td>
									<span><strong>Date</strong></span>
								</td>
								<td>
									<span id="review_date"></span>
								</td>
							</tr>
							<tr>
								<td width="20%">
									<span><strong>Name</strong></span>
								</td>
								<td width="80%">
									<span id="reviewer_name"></span>	
								</td>
							</tr>
							<tr>
								<td width="20%">
									<span><strong>Email</strong></span>
								</td>
								<td width="80%">
									<span id="reviewer_email"></span>	
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>Location</strong></span>
								</td>
								<td>
									<span id="reviewer_location"></span>
								</td>
							</tr>
							
							<tr>
								<td>
									<span><strong>Comment</strong></span>
								</td>
								<td>
									<span id="reviewer_comment"></span>
								</td>
							</tr>
							<tr>
								<td>
									<span><strong>Rating</strong></span>
								</td>
								<td>
									<span id="reviewer_rating"></span>
								</td>
							</tr>
							
						</table>
						
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				  </div>
				</div>
			  </div>
			</div>	
		<!-- View Modal -->

			
	