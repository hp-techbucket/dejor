
		
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
							
							<li class="active">
								<i class="fa fa-paint-brush"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="#addColourModal" title="Add Colour" ><i class="fa fa-plus"></i> Add Colour</a>
							</li>		
						</ol>
					</div>
				</div>
				<!-- /breadcrumb -->
				
				
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
							
					<div class="notif"></div>
					
					<br/>
												
				<?php
					//start multi delete form
					$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
					echo form_open('admin/multi_delete',$delete_form_attributes);
					//hidden item - model name
					$hidden = array('model' => 'colours',);	
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
											
							</div>
						</div>
					</div>
					<!-- /delete button container -->
															
					<!-- table container -->
					<div class="container">
						<!-- table-responsive -->
						<div class="table-responsive list-tables" >
							<!-- colours-table -->
							<table id="colours-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>
											<div class="mailbox-controls">
												<?php echo img('assets/images/icons/crookedArrow.png');?>
												<!-- Check all button -->
												<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" ><i class="fa fa-square-o"></i> Select All</button>
												<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
											</div>
										</th>		
										
										<th>#Edit</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
								 
							</table>
							<!-- /Colours-table -->
						</div>
						<!-- /table-responsive -->
					</div>
					<!-- /table container -->
									
				</div>
				<!-- /x_content -->
				
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
	



	<!-- ADD Colour Form-->
	<form action="<?php echo base_url('admin/add_colour');?>" id="addColourForm" class="form-horizontal form-label-left input_mask" name="addColourForm" method="post" enctype="multipart/form-data">
	
	<!-- .modal -->
	<div class="modal fade" id="addColourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	
		<!-- .modal-dialog -->
		<div class="modal-dialog modal-sm" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
				
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Colour</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
				
					<div class="form_errors"></div>
					<div id="alert-msg"></div>
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="colour_name">Colour Name</label>
							<input type="text" name="colour_name" class="form-control" id="cName" placeholder="Colour Name">
								
						</div>	
					</div>
					
				</div>
				<!-- /.modal-body --> 

				<!-- .modal-footer -->	
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addColour();" value="Add Colour">
					
				</div>
				<!-- /.modal-footer -->
				
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
		
	</div>
	<!-- /.modal -->	
	
	</form>		
	<!-- Add Colour Form-->
					

	<!-- Edit Colour Form-->
	<form action="<?php echo base_url('admin/update_colour');?>" id="updateColourForm" name="updateColourForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	
	<!-- .modal -->		
	<div class="modal fade" id="editColourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	
		<!-- .modal-dialog -->	
		<div class="modal-dialog modal-sm" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="colour"></h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form-errors"></div>
				  
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="colour_name">Colour Name</label>
							<input type="text" name="colour_name" class="form-control" id="colour_name">	
						</div>	
					</div>	
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="colourID" id="colourID">
								
					<input type="button" class="btn btn-primary" onclick="javascript:updateColour();" value="Update Colour">
					
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->	
	</div>
	<!-- /.modal -->		
	</form>		
	<!-- /Edit Colour Form-->
		

																				