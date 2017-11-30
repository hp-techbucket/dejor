
		
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
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/dashboard/'" title="Admin Dashboard">
													<i class="fa fa-home"></i> Dashboard
												</a>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/vehicles/'" title="Vehicles">
													<i class="fa fa-car"></i> Vehicles
												</a>
											</li>												
											<li class="active">
												<i class="fa fa-code-fork" aria-hidden="true"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="!#" class="add_vehicle" data-toggle="modal" data-target="#addModal" title="Add New Vehicle Model"><i class="fa fa-plus"></i> Add New Vehicle Model</a>
											</li>																
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'vehicle_models',);	
								echo form_hidden($hidden);	
								
								$disabled = 'disabled';		
								if($count_vehicle_models > 0){
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
							
								<!-- table container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive list-tables" >
										<!-- vehicle-models-table -->
										<table id="vehicle-models-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="5%">
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm delButton" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th width="">Code</th>
													<th width="">Title</th>
													<th width="">#Edit</th>
													
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

	
	
	
		

		<!-- ADD Modal -->
		<form action="<?php echo base_url('admin/add_vehicle_model');?>" id="addVehicleModelForm" class="form-horizontal form-label-left input_mask" name="addVehicleModelForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Vehicle Model</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="">

						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name">Make</label>
								<select name="make_id" class="form-control" id="make_id">
									<?php
										echo $select_make;
									?>
								</select>
								
							</div>	
						</div>		
						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name">Code</label>
								
								<input type="text" name="code" class="form-control" id="code">	
							</div>	
						</div>	
						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name">Title</label>
								
								<input type="text" name="title" class="form-control" id="title">	
							</div>	
						</div>	
								
					</div>
					
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addVehicleModel();" value="Add">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Modal -->
					

		<!-- Edit Modal-->
		<form action="<?php echo base_url('admin/update_vehicle_model');?>" id="updateVehicleModelForm" name="updateVehicleModelForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="colour"></h3>
				  </div>
				  <div class="modal-body">
					<div class="form-errors"></div>
				  
					<div class="">
						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name">Make</label>
								<select name="make_id" class="form-control" id="makeID">
									
								</select>
								
							</div>	
						</div>		
						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name">Code</label>
								
								<input type="text" name="code" class="form-control" id="model_code" class="uppercase">	
							</div>	
						</div>	
						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name">Title</label>
								<input type="hidden" name="model_id" id="model_id">
								<input type="text" name="title" class="form-control" id="model_title">	
							</div>	
						</div>		
							
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				
					<input type="button" class="btn btn-primary" onclick="javascript:updateVehicleModel();" value="Update">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Modal -->
		
