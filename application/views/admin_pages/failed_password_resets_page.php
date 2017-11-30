
		
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
												<i class="fa fa-list"></i> <?php echo $pageTitle;?>
											</li>
																									
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
								
							</div>
							<div class="x_content">
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'site_activities',);	
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
											<div id="notif"></div>
											<div id="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
								
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- site-activities-table -->
										<table id="site-activities-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
														<div class="mailbox-controls">
															<?php echo img('assets/images/icons/crookedArrow.png');?>
															<!-- Check all button -->
															<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i></button>
															<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i></button>
																	
														</div>
													</th>
													
													<th>Description</th>
													<th>Keyword</th>
													<th>Date</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /site-activities-table -->
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