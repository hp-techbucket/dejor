
		
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
										 <?php echo $pageTitle;?>
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
									<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4><i class="fa fa-lock"></i> Password Resets</h4></a>
								</li>
								<li role="presentation">
									<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4><i class="fa fa-exclamation-triangle"></i> Failed Resets</h4></a>
								</li>	
								
							</ul>
							<!-- /Nav tabs -->
							
							<!-- Tab panes -->
							<div class="tab-content">
							
								<!-- Tab1 -->
								<div role="tabpanel" class="tab-pane active" id="tab1">
								<br/>
								
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'password_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'password_resets',);	
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
										<!-- password-resets-table -->
										<table id="password-resets-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#passwordDeleteModal" id="" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th>Username</th>
													<th>Code</th>
													<th>Date</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /password-resets-table -->
									</div>
									<!-- /table-responsive -->
																								
								<!-- Multi Delete Modal -->
								<div class="modal fade" id="passwordDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Delete Records?
									  </div>
									  <div class="modal-body">
										<strong>Are you sure you want to permanently delete the selected records?</strong>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										
										<button type="button" class="btn btn-danger" onclick="multiToggleDelete(this)" >Delete</button>
									  </div>
									</div>
								  </div>
								</div>		
					<?php 	
								
						//	close the form
						echo form_close();	
					?>	

									
								</div>
								<!-- /container -->
									
								</div>
								<!-- Tab1 -->
								
								<!-- Tab2 -->
								<div role="tabpanel" class="tab-pane" id="tab2">
								<br/>
									<?php
								//start multi delete form
								$delete_form = array('class' => 'delete_form','id' => 'delete_form', 'role' => 'form');
				
								echo form_open('admin/multi_delete',$delete_form);
								//hidden item - model name
								$hidden = array('model' => 'failed_resets',);	
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
								
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- failed-resets-table -->
										<table id="failed-resets-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm deleteButton" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th>Username</th>
													<th>Answer</th>
													<th>Date</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /failed-resets-table -->
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
																							
								<!-- Multi Delete Modal -->
								<div class="modal fade" id="multiDeleteModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Delete Failed resets?
									  </div>
									  <div class="modal-body">
										<strong>Are you sure you want to permanently delete the selected failed resets?</strong>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										
										<button type="button" class="btn btn-danger" onclick="multiToggleDelete(this)" >Delete</button>
									  </div>
									</div>
								  </div>
								</div>		
					<?php 	
								
						//	close the form
						echo form_close();	
					?>	

								
								</div>
								<!-- /Tab2 -->
							
							</div>
							<!-- /Tab panes -->
						
						</div>
						<!-- /nav-tabs-custom -->
						
					</div>
					<!-- .x_content -->
				</div>
			</div>
		</div>
	</div>
</div>
 <!-- /page content -->
		