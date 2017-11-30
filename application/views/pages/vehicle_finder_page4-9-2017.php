
	
	<!-- .section .white -->
	<div class="section white fade">
		
		<!-- .container-fluid -->
		<div class="container-fluid">
		
			<!-- .row #row-main-->
			<div class="row" id="row-main">
				
				<!-- .col-md-2 #sidebar-->
				<div id="sidebar" class="col-md-2">
				
					<!-- .card.filter-container -->
					<div class="card filter-container blue-grey lighten-5">
						
						<h6>Filter Options</h6>
						
						<div class="filter-header">
							<span class="minimize-all"><i class="fa fa-plus-square" aria-hidden="true"></i> </span>
						
							<span class="pull-right"><a href="#" class="clear-all">Clear All</a></span>
						</div>
						
						<!-- .filter-box -->
						<div class="filter-box">
							
							<p>
								<span class="minimize-box" href="#filter_featured" ><i class="fa fa-plus-square" aria-hidden="true"></i> Featured items</span>
								
								<span class="pull-right"><a href="#" class="clear-box">Clear</a></span>
							</p>
							
							<div id="filter_featured" class="filter-section" data-column="0">
								Featured
							</div>
						</div>
						<!-- /.filter-box -->
						
						
						<!-- /.filter-box -->
						<div class="filter-box">
							
							<p>
								<span href="#filter_type" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Type</span>
								
								<span class="pull-right"><a href="!#" class="clear-box">Clear</a></span>
							</p>
							
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
							
							<p>
								<span href="#filter_make" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Make</span>
								
								<span class="pull-right"><a href="#" class="clear-box">Clear</a></span>
							</p>
							
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
							
							<p>
								<span href="#filter_model" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Model</span>
							
								<span class="pull-right"><a href="#" class="clear-box">Clear</a></span>
							</p>
							
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
							
							<p>
								<span href="#filter_year" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Year</span>
								
								<span class="pull-right"><a href="#" class="clear-box">Clear</a></span>
							</p>
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
					<!-- /.card.filter-container -->
					
				</div>
				<!-- /.col-md-2 #sidebar-->

				<!-- .col-md-10 #content-->
				<div id="content" class="col-md-10">
				
					<a href="!#" class="waves-effect waves-light btn white-text toggle-sidebar">Filter <i class="fa fa-times"></i></a>
					
					<div class="notif"></div>
						
					<!-- table-responsive -->
					<div class="table-responsive">
							
						<!-- vehicles-table -->
						<table id="vehicles-listings-table" class="table table-striped table-hover" cellspacing="0" width="100%">
							<thead class="blue-grey lighten-2 white-text">
								<tr>
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
											<a href="#!img" data-toggle="modal" data-target="#viewModal" id="<?php echo $vehicle->id ; ?>" title="View <?php echo $vehicle->vehicle_make .' '.$vehicle->vehicle_model ; ?>" onclick="viewImages(<?php echo $vehicle->id ; ?>,'<?php echo $url ; ?>');">
											 
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
												<a title="Send Enquiry" href="#enquireModal" class="btn blue-grey lighten-2 modal-trigger"><i class="fa fa-envelope" aria-hidden="true"></i></a> 
												
												<a class="btn btn-primary" href="#!" onclick="location.href='<?php echo base_url();?>vehicles/<?php echo url_title(strtolower($vehicle->vehicle_make .' '.$vehicle->vehicle_model));?>/<?php echo $vehicle->id;?>/<?php echo $thisRandNum; ?>'" title="View <?php echo $vehicle->vehicle_make .' '.$vehicle->vehicle_model;?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
											
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
				<!-- /.col-md-10 #content-->
				
			</div>
			<!-- /.row #row-main-->
				
		</div>
		<!-- /.container-fluid -->
			
	</div>
	<!-- /.section .white -->


	
	
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="text-center" id="title"></h3>
			</div>
			<div class="modal-body">
				<div id="image-gallery"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>	
<!-- View Modal -->
	
	
	<!-- imagesModal -->
	<!-- The Modal -->
	<div id="imagesModal" class="custom-modal">
		
		<!-- Modal content -->
		<div class="custom-modal-content modal-md">
		
			<!-- .modal-header -->
			<div class="custom-modal-header">
				<span class="close-icon close-modal">&times;</span>
			</div>
			<!-- /.modal-header -->
			
			<!-- .modal-body -->
			<div class="custom-modal-body">
				
			</div>
			<!-- /.modal-body -->
			
		</div>
		<!-- /Modal content -->
	</div>	
	<!-- imagesModal -->	


	
	<!-- enquireModal -->
	<!-- The Modal -->
	<div id="enquireModal" class="modal">
	<?php
		$attrs = array('class' => 'enquiry_form form_horizontal', 'id' => 'review_form', 'name' => 'enquiry_form', 'role' => 'form');
		echo form_open('main/submit_enquiry', $attrs);
	?>
		<!-- Modal content -->
		<div class="modal-content">
		
			<!-- .modal-header -->
			<div class="modal-header">
				<span class="close-icon close-modal">&times;</span>
				<h4 align="center">Contact Seller</h4>
			</div>
			<!-- /.modal-header -->
			
			<!-- .modal-body -->
			<div class="modal-body">
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">account_circle</i>
						<input type="text" id="customer_name" name="customer_name" value="<?php echo set_value('customer_name'); ?>" title="Please enter your name" class="validate">
						<label for="customer_name">Enter your name</label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix">account_circle</i>
						<input type="email" name="customer_email" id="customer_email" value="<?php echo set_value('customer_email');?>" title="Please enter your email address" class="validate">
						<label for="customer_email">Enter your email address</label>
					</div>
				</div>
				
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">phone</i>
						<input type="tel" name="customer_telephone" id="customer_telephone" value="<?php echo set_value('customer_telephone');?>" title="Enter your telephone" class="validate">
						<label for="customer_telephone">Enter your telephone</label>
					</div>
					<div class="input-field col s6">
						<label for="contact_method">Preferred method of communication?</label>
						<div class="checkbox">
							<input type="checkbox" name="contact_method[]" value="Phone" id="phone-method">
							<label class="checkbox_label" for="phone-method">Phone</label>
							
							<?php echo nbs(5); ?>
							
							<input type="checkbox" name="contact_method[]" value="Email" id="email-method">
							<label class="checkbox_label" for="email-method">Email</label>
						</div>
					</div>
				</div>						
									
				<div class="row">
					<div class="input-field col s12">
						<textarea id="comment" name="comment" class="textarea-control" data-length="500" style="height:100%;" rows="5" placeholder="Write your comments here" required></textarea>
					</div>
				</div>	
				
				<input type="hidden" name="vehicle_id" id="vehicle_id">
				<button type="button" onclick="submitEnquiry();" class="btn waves-effect waves-light">SEND ENQUIRY <i class="material-icons right">send</i></button>
				
				<?php
					echo form_close();
				?>
				
			</div>
			<!-- /.modal-body -->
			
			<!-- .modal-footer -->
			<div class="modal-footer">
				<button type="button" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</button>
				
			</div>
			<!-- /.modal-footer -->
			
		</div>
		<!-- /Modal content -->
	</div>	
	<!-- enquireModal -->			
	
	
	
		
		
		
		
		
		