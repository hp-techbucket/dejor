
		
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
												<i class="fa fa-key"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="!#" data-toggle="modal" data-target="#addKeywordModal" title="Add Keyword"><i class="fa fa-plus"></i> Add Keyword</a>
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
								$hidden = array('model' => 'keywords',);	
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
										<!-- keywords-table -->
										<table id="keywords-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<div class="mailbox-controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th>Icon</th>
													<th>Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /keywords-table -->
									</div>
									<!-- /table-responsive -->
								</div>
								<!-- /container -->
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



	<!-- ADD Keyword Form-->
	<form action="<?php echo base_url('admin/add_keyword'); ?>" id="addKeywordForm" name="addKeywordForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">	
	<!-- .modal-->
	<div class="modal fade" id="addKeywordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
			
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Keyword</h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					<div class="form_errors"></div>
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-4 col-xs-12">Keyword</label>
						<div class="col-md-9 col-sm-8 col-xs-12">
							<input type="text" class="form-control" name="keyword" id="keywd" placeholder="Keyword">
						</div>
					</div>
							
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-4 col-xs-12">Icon</label>
						<div class="col-md-9 col-sm-8 col-xs-12">
							<input type="text" class="form-control" name="icon" id="icon" placeholder="Icon">
						</div>
					</div>
						  
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						
					<input type="button" class="btn btn-success" onclick="javascript:addKeyword();" value="Add New Keyword">
							
				</div>
				<!-- /.modal-footer -->
				
			</div>
			<!-- /.modal-content -->
			
		</div>
		<!-- /.modal-dialog -->
		
	</div>	
	<!-- /.modal-->
	
	</form>			
	<!-- Add Keyword Form-->
		


	<!-- Edit Modal Form-->
	<form action="<?php echo base_url('admin/update_keyword'); ?>" id="updateKeywordForm" name="updateKeywordForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
	<!-- .modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<!-- .modal-dialog -->
		<div class="modal-dialog" role="document">
		
			<!-- .modal-content -->
			<div class="modal-content">
				<!-- .modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="header" align="center"></h3>
				</div>
				<!-- /.modal-header -->
				
				<!-- .modal-body -->
				<div class="modal-body">
					
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-4 col-xs-12">Keyword</label>
						<div class="col-md-9 col-sm-8 col-xs-12">
							<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword">
								
						</div>
					</div>
					  
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-4 col-xs-12">Icon</label>
						<div class="col-md-9 col-sm-8 col-xs-12">
							<input type="text" class="form-control" name="icon" id="keyword_icon" placeholder="Icon">
						</div>
					</div>
					  
				</div>
				<!-- /.modal-body -->
				
				<!-- .modal-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="hidden" name="keyword_id" id="keyword_id">
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateKeyword();" value="Update">
				</div>
				<!-- /.modal-footer -->
				
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	</form>		
	<!-- /Edit Modal Form-->
			
	
		
				
		