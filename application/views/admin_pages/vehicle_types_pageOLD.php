
		
<!-- page content -->
    <div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $pageTitle;?></h3>
				</div>
			</div>
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
				
				
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?php echo $pageTitle;?></h2>
						<div class="clearfix"></div>
					
					</div>
					<!-- .x_content -->
					<div class="x_content">
						
						<!-- .nav-tabs-custom -->
						<div class="nav-tabs-custom">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active">
									<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4><i class="fa fa-code-fork" aria-hidden="true"></i> Vehicle Types</h4></a>
								</li>
								<li role="presentation">
									<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4><i class="fa fa-car" aria-hidden="true"></i> Vehicle Makes</h4></a>
								</li>	
								<li role="presentation">
									<a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"><h4><i class="fa fa-motorcycle" aria-hidden="true"></i> Vehicle Models</h4></a>
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
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'vehicle_types',);	
								echo form_hidden($hidden);	
								$disabled = 'disabled';		
								if($count_vehicle_types > 0){
									$disabled = '';
								}		
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
										<!-- vehicle-types-table -->
										<table id="vehicle-types-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i></button>
														<button type="button" class="btn btn-danger btn-sm delButton" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="" ><i class="fa fa-trash-o"></i></button>
														
													</div>
													</th>
													
													<th>Name</th>
													
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /vehicle-types-table -->
									</div>
									<!-- /table-responsive -->
																								
								<!-- Multi Delete Modal -->
								<div class="modal fade" id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
										
										<button type="button" class="btn btn-danger" onclick="multiDelete()" >Delete</button>
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
								$delete_form_attributes2 = array('class' => 'multi_delete_form','role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes2);
								//hidden item - model name
								$hidden = array('model' => 'vehicle_makes',);	
								echo form_hidden($hidden);	
								
								$disabled2 = 'disabled';		
								if($count_vehicle_makes > 0){
									$disabled2 = '';
								}		
								
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
								
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- vehicle-makes-table -->
										<table id="vehicle-makes-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled2; ?>><i class="fa fa-square-o"></i></button>
														<button type="button" class="btn btn-danger btn-sm delButton" title="Delete" data-toggle="modal" data-target="#multiDeleteModal2" id="" ><i class="fa fa-trash-o"></i></button>
														
													</div>
													</th>
													
													<th>Code</th>
													<th>Title</th>
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /vehicle-makes-table -->
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
										Delete Records?
									  </div>
									  <div class="modal-body">
										<strong>Are you sure you want to permanently delete the selected records?</strong>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										
										<button type="button" class="btn btn-danger" onclick="multiDelete()" >Delete</button>
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
								
									
								<!-- Tab3 -->
								<div role="tabpanel" class="tab-pane" id="tab3">
								<br/>
									<?php
								//start multi delete form
								$delete_form_attributes3 = array('class' => 'multi_delete_form','role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes3);
								//hidden item - model name
								$hidden = array('model' => 'vehicle_models',);	
								echo form_hidden($hidden);	
								
								$disabled3 = 'disabled';		
								if($count_vehicle_models > 0){
									$disabled3 = '';
								}		
								
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
								
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- vehicle-models-table -->
										<table id="vehicle-models-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled3; ?>><i class="fa fa-square-o"></i></button>
														<button type="button" class="btn btn-danger btn-sm delButton" title="Delete" data-toggle="modal" data-target="#multiDeleteModal3" id="" ><i class="fa fa-trash-o"></i></button>
														
													</div>
													</th>
													
													<th>Name</th>
													<th>Code</th>
													<th>Title</th>
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /vehicle-models-table -->
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /table container -->
																							
								<!-- Multi Delete Modal -->
								<div class="modal fade" id="multiDeleteModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
										
										<button type="button" class="btn btn-danger" onclick="multiDelete()" >Delete</button>
									  </div>
									</div>
								  </div>
								</div>		
					<?php 	
								
						//	close the form
						echo form_close();	
					?>	

								
								</div>
								<!-- /Tab3 -->
								
								
							
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
		