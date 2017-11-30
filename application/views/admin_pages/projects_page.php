
		
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
								<i class="fa fa-table"></i> <?php echo $pageTitle;?>
							</li>
							<li>
								<a href="#" data-toggle="modal" data-target="#addProjectModal" title="Add Project"><i class="fa fa-plus"></i> Add Project</a>
							</li>														
						</ol>
					</div>
				</div>
				<!-- /breadcrumb -->
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
								<h2><?php echo $pageTitle;?> (<span id="record-count"><?php echo $project_count;?></span>)</h2>
							   
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							
							<?php
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('admin/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'projects',);	
								echo form_hidden($hidden);	
							?>
							
								<!-- delete button container -->
								<div class="container">
									<div class="row">
										<div class="col-xs-4">
											<?php echo nbs(2);?> 
											<?php echo img('assets/images/icons/crookedArrow.png');?> 
											<a class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" >
											<i class="fa fa-trash-o"></i> Delete
											</a>
										</div>
										
										<div class="col-xs-4">
										<?php 
											$message = '';
											if($this->session->flashdata('project_added') != ''){
												$message = $this->session->flashdata('project_added');
											}	
											if($this->session->flashdata('deleted') != ''){
												$message = $this->session->flashdata('deleted');
											}
											if($this->session->flashdata('project_updated') != ''){
												$message = $this->session->flashdata('project_updated');
											}	
											if($this->session->flashdata('image_added') != ''){
												$message = $this->session->flashdata('image_added');
											}	
						
						
											echo $message;
											
										?>
											<div id="notif"></div>
											<div id="errors"></div>
										</div>
									</div>
								</div>
								<!-- /delete button container -->
							
								<!-- container -->
								<div class="container">
									<!-- table-responsive -->
									<div class="table-responsive" >
										<!-- projects-table -->
										<table id="projects-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>
													<input type="checkbox" name="checkBox" id="checkBox">
													</th>
													
													<th>Image</th>
													<th>Title</th>
													
													<th>Type</th>
													<th>Completion</th>
													
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /projects-table -->
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
			

		<!-- ADD Project -->
		<form action="<?php echo base_url('admin/add_project'); ?>" id="addProjectForm" name="addProjectForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add Project</h3>
				  </div>
				  <div class="modal-body">
					<div id="form_errors"></div>
					
						<div class="scrollable">
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Image</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
										</div>
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="project_image" id="projectImage" >
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Title</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<input type="text" name="project_title" id="projectTitle" class="form-control">
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Details</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<textarea name="project_description" id="projectDescription" class="form-control"rows="7" ></textarea>	
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Features</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<textarea name="project_features" id="projectFeatures" class="form-control"rows="7"></textarea> 
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Type</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<?php echo $project_type; ?>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Clients</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<?php echo $select_clients; ?>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Completion</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									
									<div class="form-group">
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input type="text" name="projected_completion_date" id="" class="form-control datepicker">
										</div>
										<!-- /.input group -->
									</div>
									<!-- /.form group -->
								</div>
								
							</div>
							
							
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:addProject();" value="Add">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add project -->

		<!-- ADD project images -->
		<form action="<?php echo base_url('admin/upload_project_images');?>" id="upload_project_images" name="upload_project_images" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addImagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 align="center">
								Images For <span id="header"></span>
							</h3>
						</div>
						<div class="modal-body">
							<div class="form_errors"></div>
							<div id="img-alert"></div>
							
							<legend>Project Images (<span id="images_count"></span>)</legend>
							
							<div class="edit_gallery">
								<span id="gallery-edit"></span>
							</div>
							
							
							<legend>Select Files to Upload:</legend>
							
							<div class="upload-gallery"></div>
							
							<div class="input_file_wrap">
								
								<div class="form-group">
									
									<span class="btn btn-default btn-file">
										Choose Image <input type="file" name="project_images[]" id="project_images" class="proj_images" onchange="getFilename(this);imagesPreview(this, 'div.upload-gallery')" multiple/>
									</span>
									
									<a href="#" class="remove_input"><span aria-hidden="true"><i class="fa fa-trash-o"></i> Remove</span></a>
									<?php echo nbs(2); ?>
									<span class="image_name" for="project_images"></span>
									
								</div>
							</div>
							
							<p><a href="#" id="upload_more_button"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
							
							<div class="form-group">
								
								<input type="hidden" name="project_id" id="project_id">
								<input type="button" class="btn btn-primary  form-control" onclick="javascript:uploadProjectImages();" value="UPLOAD">
							</div>
				  
					
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							
						</div>
					</div>
				</div>
			</div>	
		</form>		
		<!-- Add project images -->	
	
	
	
		<!-- View Modal -->
		<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="headerTitle"></h3>
					</div>
					<div class="modal-body">
						<div class="container col-md-12">
							<div class="row">
							
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="product-image">
										<span id="image"></span>
									</div>
									<div class="product_gallery">
										<span id="gallery"></span>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">

									<h3 class="prod_title" id="title"></h3>

									<p><span id="desc"></span></p>
									<br />

									
									<div class="row">
										<div class="col-md-12">

											<div class="" role="tabpanel" data-example-id="togglable-tabs">
												<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
													<li role="presentation" class="active">
														<a href="#tab_content1" id="description-tab" role="tab" data-toggle="tab" aria-expanded="true">Description</a>
													</li>
													
													<li role="presentation" class="">
														<a href="#tab_content2" role="tab" id="features-tab" data-toggle="tab" aria-expanded="false">Features</a>
													</li>
													<li role="presentation" class="">
														<a href="#tab_content3" role="tab" id="progress-tab" data-toggle="tab" aria-expanded="false">Progress</a>
													</li>
													<li role="presentation" class="">
														<a href="#tab_content4" role="tab" id="notes-tab" data-toggle="tab" aria-expanded="false">Notes</a>
													</li>
												</ul>
												<div id="myTabContent" class="tab-content">
													<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="description-tab">
													
														<p>
														<span id="description"></span></p>
														
													</div>
													
													<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="features-tab">
														<p><span id="features"></span></p>
													</div>
													<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="progress-tab">
														<div class="project-completion">
															<div id="idpc"></div>
															<div id="dpc"></div>
															<div id="fpc"></div>
															<div id="bec"></div>
															<div id="uxc"></div>
															<div id="apc"></div>
														</div>					
													</div>
													<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="notes-tab">
														<p><strong>Project Type: </strong><span id="type">
														</span></p>
														<p><strong>Date Added: </strong><span id="date-added">
														</span></p>
														
														
														
														
														<div id="percentage_completed"></div>
														
														<p><strong>Time Remaining: </strong><span id="time-remaining">
														</span></p>
														<p><strong>Projected Completion Date: </strong><span id="completion-date">
														</span></p>
														<p><strong>Team: </strong><span id="team_members">
														</span></p>
														<p><strong>Client: </strong><span id="client_name">
														</span></p>
													</div>
												</div>
											</div>

										</div>
									</div>
									
								</div>
							</div>
							
							
						</div>	
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

					</div>
				</div>
			  </div>
			</div>	
		<!-- View Modal -->

		
		
		<!-- Edit Modal -->
		<!-- Form Name -->
		<form action="<?php echo base_url('admin/update_project') ;?>" id="updateProjectForm" name="updateProjectForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
				
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="header-title" align="center"></h3>
					</div>
					<div class="modal-body">
						
						<div class="scrollable">
						
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Update Image</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail u-thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px;">
										</div>
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="new_project_image" id="new_project_image" >
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" name="project_title" id="project_title" class="form-control">
									<input type="hidden" name="projectID" id="projectID">	
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<textarea name="project_description" id="project-description" class="form-control" rows="7"></textarea>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Features</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<textarea name="project_features" id="project_features" class="form-control"rows="7"></textarea>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span id="project-type"></span>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Client</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<span id="client-id"></span>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Idea &amp; Design Completion</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">
										<input type="text" name="idea_and_design" id="idea_and_design" class="form-control">
										<div class="input-group-addon">%</div>
									</div>
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Database Completion</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">
										<input type="text" name="database_completion" id="database_completion" class="form-control">
										<div class="input-group-addon">%</div>
									</div>	
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Front pages completion</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">
										<input type="text" name="front_pages_completion" id="front_pages_completion" class="form-control">
										<div class="input-group-addon">%</div>
									</div>	
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Back-End Completion</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">
										<input type="text" name="back_end_completion" id="back_end_completion" class="form-control">
										<div class="input-group-addon">%</div>
									</div>	
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">UX Completion</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">
										<input type="text" name="ux_completion" id="ux_completion" class="form-control">
										<div class="input-group-addon">%</div>
									</div>	
								</div>
								
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">App Testing</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">
										<input type="text" name="app_testing" id="app_testing" class="form-control">
										<div class="input-group-addon">%</div>
									</div>	
								</div>
								
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Completion Date</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group date">
										<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="projected_completion_date" id="projected_completion_date" class="form-control datepicker">
									</div>
									<!-- /.input group -->
								</div>
								
							</div>
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
						<input type="button" class="btn btn-primary" onclick="javascript:updateProject();" value="Update">
					</div>
					
						
				</div>
			  </div>
			</div>	
			</form>
		<!-- /Edit Modal -->
			
		
		
		<!-- Add To Portfolio Modal -->
		
			<div class="modal fade" id="addToPortfolioModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="title" align="center"></h3>
					</div>
					<div class="modal-body">
					<!-- Form Name -->
					<form action="<?php echo base_url('admin/move_project_to_portfolio') ;?>" id="moveProjectForm" name="moveProjectForm" method="post" enctype="multipart/form-data">
				
						<legend align="center">Move Project</legend>
						<div class="form_errors"></div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Website</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="website" id="website" class="form-control" placeholder="Enter Website">
								<input type="hidden" name="project_id" id="p-ID">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
						<input type="button" class="btn btn-success" onclick="javascript:moveProject();" value="Move">
					</div>
					
					</form>	
				</div>
			  </div>
			</div>	
			
		<!-- /Add To Portfolio Modal -->
			
		
		
		