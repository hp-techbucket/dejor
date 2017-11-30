
		
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
												<i class="fa fa-question-circle"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="!#" data-toggle="modal" data-target="#addQuestionModal" title="Add Question"><i class="fa fa-plus"></i> Add Question</a>
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
								$hidden = array('model' => 'security_questions',);	
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
										<!-- security-questions-table -->
										<table id="security-questions-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
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
													
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /security-questions-table -->
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






		<!-- ADD Question -->
		<form action="<?php echo base_url('admin/add_security_question');?>" id="addQuestionForm" class="form-horizontal form-label-left input_mask" name="addQuestionForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Security Question</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="">

						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="">New Security Question</label>
								<input type="text" name="question" class="form-control" id="question" placeholder="Enter New Security Question">
								
							</div>	
						</div>
								
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="button" class="btn btn-primary" onclick="javascript:addSecurityQuestion();" value="Add Question">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Question -->
					


		<!-- Edit Question -->
		<form action="<?php echo base_url('admin/update_security_question');?>" id="updateSecurityQuestionForm" class="form-horizontal form-label-left input_mask" name="updateSecurityQuestionForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="editSecurityQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Update Security Question</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					<div class="">

						<div class="form-group">
							
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label class="">New Security Question</label>
								<input type="text" name="question" class="form-control" id="questn" >
								<input type="hidden" name="questionID" id="questionID">
							</div>	
						</div>
								
					</div>
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateSecurityQuestion();" value="Update Question">
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Question -->
					



