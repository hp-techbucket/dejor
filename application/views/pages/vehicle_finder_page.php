
	
	<!-- .section .white -->
	<div class="section grey lighten-4 fade">
		
		<!-- .container-fluid -->
		<div class="container-fluid">
		
			<!-- .row #row-main-->
			<div class="row" id="row-main">
				
				<!-- .col-md-2 #sidebar-->
				<div id="sidebar" class="col-md-2">
				
					<!-- .card.filter-container -->
					<div class="card filter-container blue-grey lighten-4">
						
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
				
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-2 col-xs-4">
								<a href="!#" class="waves-effect waves-light btn white-text toggle-sidebar">Filter <i class="fa fa-times"></i></a>
							</div>
							<div class="col-md-10 col-xs-8">
								<?php if($pageID == 'vehicle_search'){ ?>
								<h4>Search: 
								<?php echo $search; ?> 
								(<?php echo ($count == 1)?'1 record': $count.' records';?>)
								</h4>
								<?php } ?>
								
							</div>
						</div>
					
					</div>
					
					<div class="notif"></div>
						
					<!-- table-responsive -->
					<div class="table-responsive">
							
						<!-- vehicles-table -->
						<table id="vehicles-listings-table" class="table grey lighten-4 " cellspacing="0" width="100%">
							<thead class="">
								<tr width="15%">
									<th>Listing</th>
									
									<th>Year</th>
									<th>Make</th>
									<th>Model</th>
									
									<th>Location</th>
									<th>Seller Reviews</th>	
									<th>Retail</th>
									<th>Status</th>
									<th>View</th>
								</tr>
							</thead>
							<tbody>
									<?php
									//echo '<pre>'; print_r($vehicles_array);die('</pre>');
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
											$url = 'main/image_details';
											$sale_status = $vehicle->sale_status;
											$title = $vehicle->vehicle_make .' '.$vehicle->vehicle_model;
											if($sale_status == '0'){
												$sale_status = '<span class="badge bg-green white-text teal darken-2"><i class="fa fa-check" aria-hidden="true"></i></span>';
											}else{
												$sale_status = '<span class="badge amber lighten-1"><i class="fa fa-ban" aria-hidden="true"></i></span>';
											}
											
											
											//count seller reviews
											$count_reviews = $this->Reviews->count_user_reviews($vehicle->trader_email);
											if($count_reviews == '' || $count_reviews == null || $count_reviews < 1 ){
												$count_reviews = 0;
											}
											
											//get product ratings
											$rating = $this->db->select_avg('rating')->from('reviews')->where('seller_email', $vehicle->trader_email)->get()->result();
											
											$rating_box = '';
											//GENERATE STAR RATING
											$ratingStar = $this->misc_lib->generateRatingStar($rating[0]->rating);
				
											//$row[] = ' <span class="star-rating">'.$rating.'</span>';
				
											if($rating[0]->rating == '' || $rating[0]->rating == null || $rating[0]->rating < 1){
												$ratings = 0;
												//$rating_box = '<div class="starrr stars-existing"  data-rating="0"></div> <span class="">(0)</span>';
												$rating_box = '<span class="star-rating">'.$ratingStar.'</span> <span class="">(0)</span>';
	//$rating_box = '<div class="starrr stars-existing" data-rating="'.$ratings.'"></div> <span class="stars-count-existing hidden">'.$ratings.'</span> (<span class="review-count">(0)</span>)';
												//$rating_box = 'No reviews yet';
											}else{
												//$rating_box = '<div class="starrr stars-existing" data-rating="'.round($rating[0]->rating).'" ></div> <span class="stars-count-existing hidden">'.round($rating[0]->rating).'</span> (<span class="review-count">'.$count_reviews.'</span>)';
												$rating_box = '<span class="star-rating">'.$ratingStar.'</span> (<span class="review-count">'.$count_reviews.'</span>)';
											}
											
											
									?>
										<tr>
											<td>
											<a href="#!img" data-target="#imagesModal" class="open-modal" id="<?php echo $vehicle->id ; ?>" title="View <?php echo $vehicle->vehicle_make .' '.$vehicle->vehicle_model ; ?>" onclick="viewImages(<?php echo $vehicle->id ; ?>,'<?php echo $url ; ?>');">
											 
												<div class="wrapper">
													<div class="">
														<?php echo $thumbnail ; ?> 
													</div>
													<div class="img-icon"><i class="fa fa-search-plus" aria-hidden="true"></i></div>
													<div class="img-caption">View all photos</div>
												</div>
											</a>
											</td>
											
											<td><h4><?php echo $vehicle->year_of_manufacture ; ?></h4></td>
											<td><h4><?php echo $vehicle->vehicle_make ; ?> </h4></td>
											<td><h4><?php echo $vehicle->vehicle_model ; ?></h4></td>
											
											<td><h5><?php echo $vehicle->vehicle_location_city.', '.$vehicle->vehicle_location_country ; ?></h5></td>
											<td><h6><?php echo $rating_box; ?></h6></td>	
											<td>
												<div class="product-price">
													<?php echo '$'.number_format($vehicle->vehicle_price, 0) ; ?>
												</div>
											</td>
											<td>
												<h5 class="pull-left"><?php echo $sale_status ; ?></h5>
											</td>
											<td>
												
												<a class="btn btn-default btn-responsive" href="#!" onclick="location.href='<?php echo base_url();?>vehicles/<?php echo url_title(strtolower($vehicle->vehicle_make .' '.$vehicle->vehicle_model));?>/<?php echo $vehicle->id;?>/<?php echo $thisRandNum; ?>'" title="View <?php echo $vehicle->vehicle_make .' '.$vehicle->vehicle_model;?>">
													<i class="fa fa-search" aria-hidden="true"></i>
												</a>
											
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


	
	
	<!-- imagesModal -->
	<!-- The Modal -->
	<div id="imagesModal" class="custom-modal">
		
		<!-- Modal content -->
		<div class="custom-modal-content modal-sm">
		
			<!-- .modal-header -->
			<div class="custom-modal-header">
				<span class="close-icon close-modal">&times;</span>
			</div>
			<!-- /.modal-header -->
			
			<!-- .modal-body -->
			<div class="custom-modal-body">
				<div id="image-gallery"></div>
			</div>
			<!-- /.modal-body -->
			
		</div>
		<!-- /Modal content -->
	</div>	
	<!-- imagesModal -->	


		
		
		