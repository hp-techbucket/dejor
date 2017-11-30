
		
		
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
												<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>message/inbox/'" title="Inbox">
													<i class="fa fa-inbox"></i> Inbox
												</a>
											</li>		
											<li class="active">
												<i class="fa fa-paper-plane"></i> <?php echo $pageTitle;?>
											</li>
																									
										</ol>
									</div>
								</div>
								<!-- /breadcrumb -->
								
								<div class="clearfix"></div>
								<div>
								<?php
								//handles deleted message display
								$deleted = '';
								if($this->session->flashdata('message_deleted') != ''){
									$deleted = $this->session->flashdata('message_deleted');
								}
								echo $deleted;
								?>
									<div class="notif" role="alert"></div>
								</div>	
							</div>
							<div class="x_content">
							<div class="container">
								<!-- Content Header (Page header) -->
								<div class="row">
									<div class="col-xs-12">
										<!-- Main content -->
										<div class="container">
										  <div class="row">
											<div class="col-md-2 col-sm-12 col-xs-12">
											 
											  <div class="box box-success">
												<div class="box-header with-border">
												  <h3 class="box-title">Folders</h3>

												  <div class="box-tools">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
													</button>
												  </div>
												</div>
												<div class="box-body no-padding">
												  <ul class="nav nav-stacked">
													<li><a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox');?>'" title="Private Inbox"><i class="fa fa-inbox"></i> Inbox
													  <span class="label label-primary pull-right"><?php echo $messages_unread ;?></span></a></li>
													<li class="active"><a href="javascript:void(0)"><i class="fa fa-paper-plane"></i> Sent <span class="label label-success pull-right"><?php echo $count_sent_messages;?></span></a></li>
													
													</li>
													
												  </ul>
												</div>
												<!-- /.box-body -->
											  </div>
											  <!-- /. box -->
											  
											</div>
											<!-- /.col -->
											<div class="col-md-10 col-sm-12 col-xs-12">
											  <div class="box box-success">
												
								<?php 

									//define form attributes
									$attributes = array('name' => 'message_delete_form','id' => 'message_delete_form');
														
									//start message form
									echo form_open('message/multi_delete', $attributes);
													
									$hidden = array('table' => 'sent_messages',);	
									echo form_hidden($hidden);	
									$disabled = 'disabled';
									if($count_sent_messages > 0){
										$disabled = '';
									}
												
																
								?>					
												
												
												<div class="box-body no-padding">
																				  
													<!-- table-responsive -->
													<div class="table-responsive mailbox-messages"  >
														<!-- sent-table -->
														<table id="sent-messages-table" class="table table-hover table-striped text-muted mailbox-messages " cellspacing="0" width="100%">
															<thead>
																<tr>
																	<th width="25%">
																		<div class="mailbox-controls">
																			<!-- Check all button -->
																			<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i>
																			</button>
																			<button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#deleteModal" id="delButton" ><i class="fa fa-trash-o"></i></button>
																		</div>
																	</th>
																	
																	<th width="25%">Sender</th>
																	<th width="30%">Subject</th>
																	
																	<th width="20%">Date</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
														<!-- /sent-table -->
													</div>
													<!-- /table-responsive -->
																	
								<!-- Delete Modal -->
								<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h3 align="center">Delete Messages?</h3>
										
									  </div>
									  <div class="modal-body" align="center">
										<strong>Are you sure you want to delete the selected messages?</strong>
									  </div>
									  <div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										
										<input type="button" onclick="multiMessageArchive()" class="btn btn-danger" value="Delete">
									  </div>
									</div>
								  </div>
								</div>		
					<?php 	
								
						//	close the form
						echo form_close();	
					?>	 
												  
												  
											
												</div>
												<!-- /.box-body -->
												
											  </div>
											  <!-- /. box -->
											  
											</div>
											<!-- /.col -->
										  </div>
										  <!-- /.row -->
										</div>
										<!-- /.content -->
									</div>
								</div>			
							</div>
								
							</div>
							<!-- /CONTENT MAIL -->
						</div>
					</div>
				</div>
				
				
			</div>
        </div>
        <!-- /page content -->
	
		
		
			<!-- Multi Delete Modal -->
			<div class="modal fade" id="messageDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Delete Messages?
					<div id="delete-errors"></div>
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected messages?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" onclick="multiMessageDelete()" class="btn btn-danger" name="deleteSent" value="Delete">
				  </div>
				</div>
			  </div>
			</div>		
<?php 	
			
	//	close the form
	echo form_close();	
?>			