
	
	<!-- .section .white -->
	<div class="section white fade">
		
		<!-- .container-fluid -->
		<div class="container-fluid">
		
			<!-- .row -->
			<div class="row" id="row-main">
				
				<!-- .col-md-2 -->
				<div id="sidebar" class="col-md-2">
				
					<!-- .filter-container -->
					<div class="card filter-container blue-grey lighten-5">
						
						<h6>Filter Options</h6>
						
						<div class="filter-header"><span class="minimize-all"><i class="fa fa-plus-square" aria-hidden="true"></i> </span>
						
						<span class="pull-right"><a href="#" class="clear-all">Clear All</a></span></div>
						
						<!-- .filter-box -->
						<div class="filter-box">
							
							<p><span class="minimize-box" href="#filter_featured" ><i class="fa fa-plus-square" aria-hidden="true"></i> Featured items</span><span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
							
							<div id="filter_featured" class="filter-section" data-column="0">
								Featured
							</div>
						</div>
						<!-- /.filter-box -->
						
						
						<!-- /.filter-box -->
						<div class="filter-box">
							
							<p><span href="#filter_type" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Type</span>
							<span class="pull-right"><a href="!#" class="clear-box">Clear</a></span></p>
							
							<div id="filter_type" class="filter-section">
							
								<input type="text" id="searchTypes" class="searchInput" onkeyup="searchList(this)" placeholder="Search">
								
								<ul id="type-options" class="list-unstyled list-styled types" data-column="1">
									
										<?php 
										$this->db->from('vehicle_types');
										$this->db->order_by('id');
										$result = $this->db->get();
										if($result->num_rows() > 0) {
											
											$no = 1;
											
											foreach($result->result_array() as $row){
											
										?>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="vehicle_type[]" class="vehicle_type column_filter" value="<?php echo ucwords($row['name']);?>" id="col_1_filter_<?php echo $no;?>" data-column="<?php echo $no;?>">
												
												<label class="checkbox_label" for="col_1_filter_<?php echo $no;?>"><?php echo ucwords($row['name']);?></label>
											</div>
										</li>
										<?php 
												$no++;
												
											}
										}
											
										?>
									
								</ul>
							</div>
						</div>
						<!-- /.filter-box -->
						
						
						<!-- /.filter-box -->
						<div class="filter-box">
							
							<p><span href="#filter_make" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Make</span>
							<span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
							<div id="filter_make" class="filter-section">
							
								<input type="text" id="searchMakes" class="searchInput" onkeyup="searchList(this)" placeholder="Search">
								
								<ul id="make-options" class="list-unstyled list-styled makes" data-column="3">
									
										<?php 
										$this->db->from('vehicle_makes');
										$this->db->order_by('id');
										$result = $this->db->get();
										if($result->num_rows() > 0) {
											
											$no = 1;
											
											foreach($result->result_array() as $row){
											
										?>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="vehicle_make[]" class="vehicle_make column_filter" value="<?php echo ucwords($row['title']);?>" id="col_3_filter_<?php echo $no;?>" data-column="<?php echo $no;?>">
										
												<label class="checkbox_label" for="col_3_filter_<?php echo $no;?>"><?php echo ucwords($row['title']);?></label>
											</div>
										</li>
										<?php 
												$no++;
											}
										}
											
										?>
									
								</ul>
							</div>
						</div>
						<!-- /.filter-box -->
						
						<!-- .filter-box -->
						<div class="filter-box">
							
							<p><span href="#filter_model" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Model</span>
							<span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
							<div id="filter_model" class="filter-section">
								<input type="text" id="searchModels" class="searchInput" onkeyup="searchList(this)" placeholder="Search">
								<ul id="model-options" class="list-unstyled list-styled models" data-column="4">
									
										<?php 
										$this->db->from('vehicle_models');
										$this->db->order_by('id');
										$result = $this->db->get();
										if($result->num_rows() > 0) {
											
											$no = 1;
											
											foreach($result->result_array() as $row){
												
										?>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="vehicle_model[]" class="vehicle_model column_filter" value="<?php echo ucwords($row['title']);?>" id="col_4_filter_<?php echo $no;?>" data-column="<?php echo $no;?>">
										
												<label class="checkbox_label" for="col_4_filter_<?php echo $no;?>"><?php echo ucwords($row['title']);?></label>
											</div>
										</li>
										<?php 
												$no++;
											}
										}
											
										?>
										
									
								</ul>
							</div>
						</div>
						<!-- /.filter-box -->
						
						
						<!-- .filter-box -->
						<div class="filter-box">
							
							<p><span href="#filter_year" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Year</span>
							<span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
							<div id="filter_year" class="filter-section">
								<input type="text" id="searchYears" class="searchInput" onkeyup="searchList(this)" placeholder="Search">
								<ul id="year-options" class="list-unstyled list-styled years" data-column="2">
									
										<?php 
										
										$no = 1;
											
										for($i=date("Y")-50; $i<=date("Y"); $i++) {
										?>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="year_of_manufacture[]" class="year_of_manufacture column_filter" value="<?php echo $i;?>" id="col_2_filter_<?php echo $no;?>" data-column="<?php echo $no;?>">
												
												<label class="checkbox_label" for="col_2_filter_<?php echo $no;?>"><?php echo $i;?></label>
											</div>
										</li>
										<?php 
											
											$no++;	
										}
											
										?>
										
									
								</ul>
							</div>
						</div>
						<!-- /.filter-box -->
						
						
					</div>
					<!-- /.filter-container -->
					
				</div>
				<!-- /.col-md-2 -->

				<!-- .col-md-10 -->
				<div id="content" class="col-md-10">
				
					<div class="listing-container">
						
						
						<a href="!#" class="waves-effect waves-light btn white-text toggle-sidebar">Filter <i class="fa fa-times"></i></a>
						
						<!-- table-responsive -->
						<div class="table-responsive" >
							
								<!-- vehicles-table -->
								<table id="vehicles-listings-table" class="display table table-striped table-hover" cellspacing="0" width="100%">
									<thead>
										<tr class="blue-grey lighten-2 white-text">
											<th>Images</th>
											<th>Type</th>
											<th>Year</th>
											<th>Make</th>
											<th>Model</th>
											<th>Item #</th>
											<th>Location</th>
											<th>Odometer</th>	
											<th>Retail</th>
											<th>Enquire</th>
										</tr>
										
									</thead>
									<tbody>
									<?php
									if($vehicles_array){
										foreach($vehicles_array as $vehicle){
											$thumbnail = '';
											$filename = FCPATH.'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image;
											
											if($vehicle->vehicle_image == '' || $vehicle->vehicle_image == null || !file_exists($filename)){
						
												$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $vehicle->id)->get()->row();
											
												if(!empty($result)){
													
													$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$result->vehicle_id.'/'.$result->image_name.'" class="img-responsive"/>';
													
												}else{
													$thumbnail = '<img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive"/>';
												}
												
											}
											else{
												$thumbnail = '<img src="'.base_url().'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image.'" class="img-responsive "/>';
											}	
											//onclick="viewVehicle(<?php echo $vehicle->id ; /);" 
											$thisRandNum = md5(uniqid());
											$url = 'vehiclefinder/image_details';
									?>
										<tr>
											<td width="13%">
											<a href="#!" data-target="#imagesModal" class="open-modal" id="<?php echo $vehicle->id ; ?>" title="View <?php echo $vehicle->vehicle_make .' '.$vehicle->vehicle_model ; ?>" onclick="viewImages(<?php echo $vehicle->id ; ?>,'<?php echo $url ; ?>');">
												<div class="wrapper">
													<div class="img">
														<?php echo $thumbnail ; ?> 
													</div>
													<div class="img-icon"><i class="fa fa-search-plus" aria-hidden="true"></i></div>
													<div class="img-caption">View all photos</div>
												</div>
											</a>
											</td>
											<td><?php echo $vehicle->vehicle_type ; ?></td>
											<td><?php echo $vehicle->year_of_manufacture ; ?></td>
											<td><?php echo $vehicle->vehicle_make ; ?> </td>
											<td><?php echo $vehicle->vehicle_model ; ?></td>
											<td><?php echo $vehicle->id ; ?></td>
											<td><?php echo $vehicle->vehicle_location_city.', '.$vehicle->vehicle_location_country ; ?></td>
											<td><?php echo $vehicle->vehicle_odometer ; ?></td>	
											<td><?php echo '$'.number_format($vehicle->vehicle_price, 0) ; ?></td>
											<td>
												<a title="Send Enquiry" data-target="#enquireModal" class="btn blue-grey lighten-2 open-modal"><i class="fa fa-envelope" aria-hidden="true"></i></a> 
												
												<a class="btn btn-primary" href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>vehicles/<?php echo $vehicle->id;?>/<?php echo url_title(strtolower($vehicle->vehicle_make .' '.$vehicle->vehicle_model));?>/<?php echo $thisRandNum; ?>'" title="View <?php echo $vehicle->vehicle_make .' '.$vehicle->vehicle_model;?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
											
											</td>
										</tr>
									<?php
										}
									}
									?>
									
									</tbody>
									 
								</table>
								<!-- /vehicles-table -->
							</div>
							<!-- /table-responsive -->
						
					</div>	
				</div>
				<!-- /.col-md-10 -->
				
			</div>
			<!-- /.row -->
			
		</div>
		<!-- .container-fluid -->

				
	</div>
	<!-- /.section /.white -->


	
	<!-- imagesModal -->
	<!-- The Modal -->
	<div id="imagesModal" class="custom-modal">
		
		<!-- Modal content -->
		<div class="modal-content modal-md">
		
			<!-- .modal-header -->
			<div class="modal-header">
				<span class="close-icon close-modal">&times;</span>
			</div>
			<!-- /.modal-header -->
			
			<!-- .modal-body -->
			<div class="modal-body">
				<div id="image-gallery"></div>
			</div>
			<!-- /.modal-body -->
			
			<!-- .modal-footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default close-modal">Close</button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /Modal content -->
	</div>	
	<!-- imagesModal -->	


	
	<!-- enquireModal -->
	<!-- The Modal -->
	<div id="enquireModal" class="custom-modal">

		<!-- Modal content -->
		<div class="modal-content modal-md">
		
			<!-- .modal-header -->
			<div class="modal-header">
				<span class="close-icon close-modal">&times;</span>
				<h3 align="center">Modal Header</h3>
			</div>
			<!-- /.modal-header -->
			
			<!-- .modal-body -->
			<div class="modal-body">
				<p>Some text in the Modal Body</p>
				<p>Some other text...</p>
			</div>
			<!-- /.modal-body -->
			
			<!-- .modal-footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default close-modal">Cancel</button>
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /Modal content -->
	</div>	
	<!-- enquireModal -->			
	
	
	
		
		
		
		
		
		