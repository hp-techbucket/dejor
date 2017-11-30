
	
	<!-- .section .white -->
	<div class="section white fade">
	
		<!-- .row .container-fluid -->
		<div class="row container-fluid">
		
			<!-- .col-md-2 -->
			<div class="col-md-2">
			
				<!-- .filter-container -->
				<div class="filter-container">
					
					<div class="filter-header"><span class="minimize-all"><i class="fa fa-plus-square" aria-hidden="true"></i> Filter Options</span>
					<span class="pull-right"><a href="#" class="clear-all">Clear All</a></span></div>
					
					<!-- .filter-box -->
					<div class="filter-box">
						
						<p><span class="minimize-box" href="#filter_featured" data-toggle="collapse"><i class="fa fa-plus-square" aria-hidden="true"></i> Featured items</span><span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
						
						<div id="filter_featured" class="filter-section collapse" data-column="0">
							Featured
						</div>
					</div>
					<!-- /.filter-box -->
					
					
					<!-- /.filter-box -->
					<div class="filter-box">
						
						<p><span href="#filter_type" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Type</span>
						<span class="pull-right"><a href="!#" class="clear-box">Clear</a></span></p>
						<div id="filter_type" class="filter-section">
							<ul id="type-options" class="list-unstyled list-styled types" data-column="1">
								<li>
									<?php 
									$this->db->from('vehicle_types');
									$this->db->order_by('id');
									$result = $this->db->get();
									if($result->num_rows() > 0) {
										
										$no = 1;
										
										foreach($result->result_array() as $row){
										
									?>
										<div class="checkbox">
											<input type="checkbox" name="vehicle_type[]" class="col_1_filter column_filter" value="<?php echo ucwords($row['name']);?>" id="vehicle_type_<?php echo $no;?>">
									
											<label for="vehicle_type_<?php echo $no;?>"><?php echo ucwords($row['name']);?></label>
										</div>
									<?php 
											$no++;
											
										}
									}
										
									?>
								</li>
							</ul>
						</div>
					</div>
					<!-- /.filter-box -->
					
					
					<!-- /.filter-box -->
					<div class="filter-box">
						
						<p><span href="#filter_make" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Make</span>
						<span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
						<div id="filter_make" class="filter-section">
							<ul id="make-options" class="list-unstyled list-styled makes" data-column="3">
								<li>
									<?php 
									$this->db->from('vehicle_makes');
									$this->db->order_by('id');
									$result = $this->db->get();
									if($result->num_rows() > 0) {
										
										$no = 1;
										
										foreach($result->result_array() as $row){
										
									?>
										<div class="checkbox">
											<input type="checkbox" name="vehicle_make[]" class="col_3_filter column_filter" value="<?php echo ucwords($row['title']);?>" id="vehicle_make_<?php echo $no;?>">
									
											<label for="vehicle_make_<?php echo $no;?>"><?php echo ucwords($row['title']);?></label>
										</div>
									<?php 
											$no++;
										}
									}
										
									?>
								</li>
							</ul>
						</div>
					</div>
					<!-- /.filter-box -->
					
					<!-- .filter-box -->
					<div class="filter-box">
						
						<p><span href="#filter_model" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Model</span>
						<span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
						<div id="filter_model" class="filter-section">
							<ul id="model-options" class="list-unstyled list-styled models" data-column="4">
								<li>
									<?php 
									$this->db->from('vehicle_models');
									$this->db->order_by('id');
									$result = $this->db->get();
									if($result->num_rows() > 0) {
										
										$no = 1;
										
										foreach($result->result_array() as $row){
											
									?>
										<div class="checkbox">
											<input type="checkbox"  name="vehicle_model[]" class="col_4_filter column_filter" value="<?php echo ucwords($row['title']);?>" id="vehicle_model_<?php echo $no;?>">
									
											<label for="vehicle_model_<?php echo $no;?>"><?php echo ucwords($row['title']);?></label>
										</div>
									<?php 
											$no++;
										}
									}
										
									?>
									
								</li>
							</ul>
						</div>
					</div>
					<!-- /.filter-box -->
					
					
					<!-- .filter-box -->
					<div class="filter-box">
						
						<p><span href="#filter_year" class="minimize-box"><i class="fa fa-plus-square" aria-hidden="true"></i> Year</span>
						<span class="pull-right"><a href="#" class="clear-box">Clear</a></span></p>
						<div id="filter_year" class="filter-section">
							<ul id="year-options" class="list-unstyled list-styled years" data-column="2">
								<li>
									<?php 
									
									$no = 1;
										
									for($i=date("Y")-50; $i<=date("Y"); $i++) {
									?>
										<div class="checkbox">
											<input type="checkbox"  name="year_of_manufacture[]" class="col_2_filter column_filter" value="<?php echo $i;?>" id="year_of_manufacture_<?php echo $no;?>">
											
											<label for="year_of_manufacture_<?php echo $no;?>"><?php echo $i;?></label>
										</div>
									<?php 
										
										$no++;	
									}
										
									?>
									
								</li>
							</ul>
						</div>
					</div>
					<!-- /.filter-box -->
					
					
				</div>
				<!-- /.filter-container -->
				
			</div>
			<!-- /.col-md-2 -->
			
			<!-- .col-md-10 -->
			<div class="col-md-10">
				<div class="listing-container">
					
					<!-- table-responsive -->
					<div class="table-responsive" >
						
							<!-- vehicles-table -->
							<table id="vehicles-listings-table" class="table table-hover table-striped" width="100%">
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
										
										if(!file_exists($filename)){
					
											$result = $this->db->select('*, MIN(id) as min_id', false)->from('vehicle_images')->where('vehicle_id', $vehicle->id)->get()->row();
										
											if(!empty($result)){
												
												$thumbnail = '<a href="!#" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewVehicle('.$vehicle->id.');" id="'.$vehicle->id.'" title="View '.$vehicle->vehicle_make .' '.$vehicle->vehicle_model.'"><img src="'.base_url().'uploads/vehicles/'.$result->vehicle_id.'/'.$result->image_name.'" class="img-responsive img-rounded" width="80" height="80" /></a>';
											}else{
												$thumbnail = '<a href="!#" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewVehicle('.$vehicle->id.');" id="'.$vehicle->id.'" title="View '.$vehicle->vehicle_make .' '.$vehicle->vehicle_model.'"><img src="'.base_url().'assets/images/img/no-default-thumbnail.png" class="img-responsive img-rounded" width="80" height="80" /></a>';
											}
											
										}
										else{
											$thumbnail = '<a href="!#" data-toggle="modal" data-target="#viewModal" class="link" onclick="viewVehicle('.$vehicle->id.');" id="'.$vehicle->id.'" title="View '.$vehicle->vehicle_make .' '.$vehicle->vehicle_model.'"><img src="'.base_url().'uploads/vehicles/'.$vehicle->id.'/'.$vehicle->vehicle_image.'" class="img-responsive img-rounded" width="80" height="80" /></a>';
										}	
				
								?>
									<tr>
										<td><?php echo $thumbnail ; ?></td>
										<td><?php echo $vehicle->vehicle_type ; ?></td>
										<td><?php echo $vehicle->year_of_manufacture ; ?></td>
										<td><?php echo $vehicle->vehicle_make ; ?> </td>
										<td><?php echo $vehicle->vehicle_model ; ?></td>
										<td><?php echo $vehicle->id ; ?></td>
										<td><?php echo $vehicle->vehicle_location_city.', '.$vehicle->vehicle_location_country ; ?></td>
										<td><?php echo $vehicle->vehicle_odometer ; ?></td>	
										<td><?php echo '$'.number_format($vehicle->vehicle_price, 0) ; ?></td>
										<td><a href="!#" class="waves-effect waves-light  btn">Enquire <i class="material-icons right">send</i></a></td>
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
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.white -->

		
		
		
		
		
		
		
		
		