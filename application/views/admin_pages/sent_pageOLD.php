
		
		
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
				
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="x_title">
			
								<div class="row">
									<div class="col-lg-3 col-sm-12 col-xs-12">	
										<h2><?php echo $pageTitle;?></h2>
									</div>
									<div class="col-lg-3 col-lg-offset-3 col-sm-12 col-xs-12 form-group pull-right">
									<?php
										//define form attributes
										$atts = array('name' => 'sent_search_form','id' => 'sent_search_form');
															
										echo form_open('message/sent_search',$atts);
									?>
										<div class="inner-addon right-addon">
											<input type="text" class="form-control" name="search" id="search" placeholder="Search mail">
											<i class="fa fa-search" aria-hidden="true"></i>
											<input type="hidden" value="sent" id="hidden">
											
										</div>
									<?php
										echo form_close();
									?>
									</div>
								</div>
								
								
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
							<div class="container">
								<!-- Content Header (Page header) -->
								<div class="row">
									<div class="col-xs-12">
										<!-- Main content -->
										<div class="container">
										  <div class="row">
											<div class="col-md-3 col-sm-12 col-xs-12">
											 
											  <div class="box box-success">
												<div class="box-header with-border">
												  <h3 class="box-title">Folders</h3>

												  <div class="box-tools">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
													</button>
												  </div>
												</div>
												<div class="box-body no-padding">
												  <ul class="nav nav-pills nav-stacked">
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
											<div class="col-md-9 col-sm-12 col-xs-12">
											  <div class="box box-success">
												<div class="box-header with-border">
													<span id="display_option">
														<?php echo $display_option; ?>
													</span>
													<div>
													<?php
														//handles deleted message display
															$deleted = '';
															if($this->session->flashdata('message_deleted') != ''){
																$deleted = $this->session->flashdata('message_deleted');
															}
															echo $deleted;
													?>
													</div>	
												  
												  
												</div>
												<!-- /.box-header -->
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
												  <div class="mailbox-controls">
													<!-- Check all button -->
													<button type="button" class="btn btn-default btn-sm checkbox-toggle"<?php echo $disabled; ?>><i class="fa fa-square-o"></i>
													</button>
													<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#messageDeleteModal" id="delButton" ><i class="fa fa-trash-o"></i></button>
												   
													
												  </div>
											
												  
											 <div class="table-responsive mailbox-messages">
													<table class="table table-hover table-striped">
														<tbody class="message-tbody">
													<?php
													
														//check messages array for messages to display			
														if(!empty($messages_array)){
												
															//obtain each row of message
															foreach ($messages_array as $message){	
															
																$textWeight = 'msgRead';
																$icon = '<i class="fa fa-circle-o"></i>';
																$replied = '<i class="fa fa-reply" aria-hidden="true"></i>';
																
													?>
															<tr>
																<td><input type="checkbox"name="cb[]" id="cb" value="<?php echo $message->id; ?>"></td>
																<td><i class="fa fa-reply" aria-hidden="true"></i></td>
																<td><?php echo $message->receiver_name; ?></td>
																
																<td class="mailbox-subject">
																
																<span class="messageToggle" style="padding:3px;">
																<a href="javascript:void(0)" class="<?php echo $textWeight; ?>" id="subj_line_<?php echo $message->id; ?>"><?php echo stripslashes($message->message_subject); ?></a>
																</span>
																
																<div class="messageDiv"><br/><?php echo 
																	stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)); ?>
																	
																</div>
																
																</td>
																
														<td class="mailbox-date"><small><?php echo date("F j, Y", strtotime($message->date_sent)); ?></small></td>
													  </tr>
												<?php 
															}
														}else {
												?>
											<tr>
												<td colspan="5"><div class="alert alert-default text-center notif" role="alert"><i class="fa fa-ban"></i> No messages!</div></td>
											</tr>
										
										<?php
										}
										?>	
													  </tbody>
													</table>
													<!-- /.table -->
												  </div>
												  <!-- /.mail-box-messages -->
												</div>
												<!-- /.box-body -->
												
											  </div>
											  <!-- /. box -->
											  
												<div class="row">
													<div class="col-md-6 pull-left">
														<span class="current"><?php echo $current; ?></span>
													</div>
													<div class="col-md-6 pull-right">
														<span class="pagnums"><?php echo $pagination; ?></span>
													</div>
												</div>
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