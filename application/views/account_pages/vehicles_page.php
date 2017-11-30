<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{
			$city = $user->city;
			$country = $user->country;
?>

		
        <!-- page content -->
        <div class="right_col" role="main">
			<div class="">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $pageTitle;?> (<span id="record-count"><?php echo $vehicle_count;?></span>)</h3>
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
												<i class="fa fa-car"></i> <?php echo $pageTitle;?>
											</li>
											<li>
												<a href="!#" class="add_vehicle" data-toggle="modal" data-target="#addVehicleModal" title="Add Vehicle"><i class="fa fa-plus"></i> Add Vehicle</a>
											</li>														
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
								<div class="clearfix"></div>
								
								
							</div>
							<div class="x_content">
							
							<?php echo $country ; ?>
							<?php
							
								//start multi delete form
								$delete_form_attributes = array('class' => 'multi_delete_form','id' => 'multi_delete_form', 'role' => 'form');
								echo form_open('account/multi_delete',$delete_form_attributes);
								//hidden item - model name
								$hidden = array('model' => 'vehicles',);	
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
										<!-- vehicles-table -->
										<table id="vehicles-table" frame="box" class="display table-hover table-striped bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th width="15%">
													<div class="controls">
														<?php echo img('assets/images/icons/crookedArrow.png');?>
														<!-- Check all button -->
														<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All"><i class="fa fa-square-o"></i> Select All</button>
														<button type="button" class="btn btn-danger btn-sm " title="Delete" data-toggle="modal" data-target="#multiDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i> Delete</button>
														
													</div>
													</th>
													
													<th>Vehicle</th>
													<th>Type</th>
													<th>Make</th>
													<th>Model</th>
													<th>Year</th>
													<th>Last Updated</th>
													<th>#Edit</th>
													
												</tr>
											</thead>
											<tbody>
											</tbody>
								 
										</table>
										<!-- /vehicles-table -->
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
			

		<!-- ADD Vehicle -->
		<form action="<?php echo base_url('account/add_vehicle'); ?>" id="addVehicleForm" name="addVehicleForm" class="form-horizontal form-label-left input_mask" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" class="headerTitle">Add Vehicle</h3>
				  </div>
				  <div class="modal-body">
					<div class="form_errors"></div>
					
						<div class="scrollable">
							<div class="form-group">
								<label class="control-label col-md-1 col-sm-1 col-xs-12">Image</label>
								<div class="col-md-11 col-sm-11 col-xs-12">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail u-thumbnail" data-trigger="fileinput" style="width: 165px; height: 150px; display:none;">
										</div>
										<div>
											<span class="btn btn-primary btn-file">
												<span class="fileinput-new">Select image</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="vehicle_image" id="vehicleImage" >
											</span>
											<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								
								</div>
							</div>
							<div class="form-group">
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_type">Type</label>
									<select name="vehicle_type" class="form-control " id="vehicle_type">
										<option value="" selected="selected">Select Type</option>
										<?php 
											$this->db->from('vehicle_types');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													
													echo '<option value="'.$row['name'].'" >'.$row['name'].'</option>';
												}
											}
										
										?>
									</select>
									
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_make">Make</label>
									<select name="vehicle_make" class="form-control" id="vehicle_make" onchange="getVehicleModels(this, '<?php echo base_url('vehicle/get_models');?>')">
										<option value="" selected="selected">Select Make</option>
										<?php 
											$this->db->from('vehicle_makes');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													echo '<option value="'.$row['id'].'">'.ucwords($row['title']).'</option>';			
												}
											}
										
										?>
									</select>
									
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_model">Model</label>
									
									<select name="vehicle_model" class="form-control" id="vehicle_model">
										<option value="" selected="selected">Select Model</option>
										
									</select>
									
								</div>
							</div>
							<div class="form-group">
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="year_of_manufacture">Year of Manufacture</label>
									<select name="year_of_manufacture" class="form-control " id="year_of_manufacture">
										<option value="" selected="selected">Select Year</option>
									<?php
										for($i=date("Y")-50; $i<=date("Y"); $i++) {
											$sel = ($i == date('Y') - 5) ? 'selected' : '';
											echo "<option value=".$i." ".$sel.">".$i."</option>";  // here I have changed      
										}
									?>
									</select>
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_odometer">Odometer</label>
									<input type="text" name="vehicle_odometer" id="vehicle_odometer" class="form-control">
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_lot_number">Lot Number</label>
									<input type="text" name="vehicle_lot_number" id="vehicle_lot_number" class="form-control">
								</div>
								
							</div>
							
							<div class="form-group">
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_vin">Vin</label>
									<input type="text" name="vehicle_vin" id="vehicle_vin" class="form-control">
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_colour">Colour</label>
									<select name="vehicle_colour" class="form-control " id="vehicle_colour">
										<option value=""selected="selected">Select Colour</option>
										<?php 
											$this->db->from('colours');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													echo '<option value="'.$row['colour_name'].'">'.ucwords($row['colour_name']).'</option>';			
												}
											}
										
										?>
									</select>
									
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="sale_status">Sale Status</label>
									<select name="sale_status" class="form-control" id="sale_status">
										<option value="0">Available</option>
										<option value="1">Sold</option>
										
									</select>
								</div>
							</div>
							
							<div class="form-group">
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="vehicle_description">Description</label>
									<textarea name="vehicle_description" id="vehicle_description" class="form-control"></textarea>
									
								</div>
							</div>
							
							<div class="form-group">
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_price">Price</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
											<input type="number" step="0.01" name="vehicle_price" class="form-control" id="vehicle_price" placeholder="10" required>
										
									</div>
									
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="discount">Discount</label>
									<input type="number" name="discount" id="discount" class="form-control">
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="price_after_discount">Discount Price <span id="percentage-off"></span></label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
											<input type="number" name="price_after_discount" id="price_after_discount" class="form-control" readonly>
										
									</div>
								</div>
								
								
							</div>
							<div class="form-group">
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_location_city">Location City</label>
									<input type="text" name="vehicle_location_city" id="vehicle_location_city" class="form-control" value="<?php echo $city ; ?>">
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<label for="vehicle_location_country">Location Country</label>
									<select name="vehicle_location_country" class="form-control" id="vehicle_location_country">
										<option value="" selected="selected">Select Country</option>
										<?php 
											$this->db->from('countries');
											$this->db->order_by('id');
											$result = $this->db->get();
											if($result->num_rows() > 0) {
												foreach($result->result_array() as $row){
													
													$default = (strtolower($row['name']) == strtolower($country))?'selected':''; 
													
													echo '<option value="'.$row['name'].'" '.$default.'>'.ucwords($row['name']).'</option>';			
												}
											}
										//echo $country_options; 
										
										?>
									</select>
									
								</div>
								
								
							</div>
							
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="hidden" name="vehicleID" id="vehicleID">
					<input type="button" class="btn btn-primary btn-update hidden" onclick="javascript:updateVehicle('account/update_vehicle');" value="Update">
							
					<input type="button" class="btn btn-success btn-add" onclick="javascript:addVehicle();" value="Add">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Vehicle -->
		
		

		<!-- ADD Vehicle images -->
		<form action="<?php echo base_url('account/upload_vehicle_images');?>" id="upload_vehicle_images" name="upload_vehicle_images" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addImagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h3 align="center">
								Images For <span id="header"></span>
							</h3>
						</div>
						<div class="modal-body">
							<div class="form_errors"></div>
							<div class="img-alert"></div>
							
							
						<div class="scrollable">
							
							<legend>Select Files to Upload:</legend>
							
							<!-- The global progress bar -->
							<div id="progress-wrap"></div>
								  
							
							
							<p class="small">Attach files below (allowed types: gif, jpg, jpeg and png)</p>
							
							<div class="input_file_wrap">
								<div class="form-group">
									<img class="img-preview" src="#" alt="" />
									<div class="fileinput fileinput-new" data-provides="fileinput">
									  <span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Select image file <i class="fa fa-file-image-o" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="vehicle_images[]" onchange="readURL(this);"></span>
									  <span class="fileinput-filename"></span>
									  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
									</div>
								</div>
								
							</div>
							
							<p><a href="!#" class="upload_more_btn"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
							
							
							<div class="form-group">
								
								<input type="hidden" name="vehicle_id" id="vehicle_id">
								<input type="hidden" name="existing_count" id="existing_count" >
								
								<button type="button" class="btn btn-primary form-control" onclick="javascript:uploadVehicleImages();"><i class="fa fa-cloud-upload" aria-hidden="true"></i> UPLOAD</button>
							</div>
				  
					
							
							<legend>Vehicle Images (<span id="images_count"></span> <span class="small" id="allowed_count"></span>)</legend>
							
							<div class="edit_gallery">
								<span id="gallery-edit"></span>
							</div>
						</div>	
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							
						</div>
					</div>
				</div>
			</div>	
		</form>		
		<!-- Add Vehicle images -->	
	

	
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="text-center" id="title"></h3>
			</div>
			<div class="modal-body">
				<div class="scrollable">
					<div class="container col-md-12">
						<div class="row">
							<div class="col-md-7 col-sm-12 col-xs-12">
								<div class="product-image">
									<span id="image"></span>
								</div>
								
							</div>
							
							<div class="col-md-2 col-xs-5 gallery-container nopadding">
								<div class="">
									<span id="gallery"></span>	
								</div>
							</div>
				
							<div class="col-md-3 col-xs-7">

								<h3 class="product-title"><span id="title" ></span></h3>
								
								<div class="product-price">
									<span id="view-price" ></span>
									<span class="small" id="view-old-price" ></span>
								</div>
										  
								<h4><strong><i class="fa fa-calendar" aria-hidden="true"></i></strong> <span id="view-year" ></span></h4>
														  
								<span id="view-colour" ></span>
								
								<?php echo br(2); ?>

							</div>
						</div>	
						
						<hr/>
						
						<!-- .row -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 desc-container">
							
								<!-- .nav nav-pills -->
								<ul class="nav nav-pills">
									<li class="active"><a data-toggle="pill" href="#tab1">DETAILS</a></li>
									<li><a data-toggle="pill" href="#tab2">DESCRIPTION </a></li>
									
								</ul>
								<!-- /.nav nav-pills -->
								
								<!-- .tab-content -->	  
								<div class="tab-content">
								
									<!-- #tab1 -->
									<div id="tab1" class="tab-pane fade in active">
										
										<h5><strong>Type <i class="fa fa-taxi" aria-hidden="true"></i></strong> <span id="view-vehicle-type" ></span></h5>
										
										<h5><strong>Make <i class="fa fa-bus" aria-hidden="true"></i></strong> <span id="view-vehicle-make" ></span></h5>
															  
										<h5><strong>Model <i class="fa fa-code-fork" aria-hidden="true"></i></strong> <span id="view-vehicle-model" ></span></h5>
															  
										<h5><strong>Odometer <i class="fa fa-tachometer" aria-hidden="true"></i></strong> <span id="view-odometer" ></span></h5>
															  
										<h5><strong>VIN <i class="fa fa-id-badge" aria-hidden="true"></i></strong> <span id="view-vin" ></span></h5>
																		  
										<h5><strong>Lot number<i class="fa fa-truck" aria-hidden="true"></i></strong> <span id="view-lot-number" ></span></h5>
										
										<h5><strong>Location <i class="fa fa-thumb-tack" aria-hidden="true"></i></strong> <span id="view-city" ></span> <span id="view-country" ></span></h5>
																  
										<h5><strong>Status <i class="fa fa-sellsy" aria-hidden="true"></i></strong> <span id="view-sale-status" ></span></h5>
																  
										<h5><strong>Discount %<i class="fa fa-percent" aria-hidden="true"></i></strong> <span id="view-discount" ></span></h5>
																  
										<h5><strong>Discount Price <span class="glyphicon glyphicon-usd"></span></strong> <span id="view-discount-price" ></span></h5>
																					  
										<h5><strong>Added <i class="fa fa-calendar" aria-hidden="true"></i></strong> <span id="date-added" ></span></h5>
											
														 
									</div>
									<!-- /#tab1 -->
									
									<!-- #tab2 -->
									<div id="tab2" class="tab-pane fade">
										<p><span class="glyphicon glyphicon-comment"></span> <span id="view-description" ></span></p>
									</div>
									<!-- /#tab2 -->
									
								</div>
								<!-- /.tab-content -->
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


<?php   
		}
	}								
?>

		