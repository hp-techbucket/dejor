
		
		
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
									<li class="active">
										<i class="fa fa-inbox"></i> <?php echo $pageTitle;?>
									</li>
									<li>
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>message/sent/'" title="Sent">
											<i class="fa fa-paper-plane"></i> Sent
										</a>
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
									
									
									<!-- .nav-tabs-custom -->
									<div class="nav-tabs-custom">
										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active">
												<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><h4><i class="fa fa-inbox"></i> Inbox (<span class="inbox-count"><?php echo $messages_unread; ?></span>)</h4></a>
											</li>
											<li role="presentation">
												<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><h4><i class="fa fa-archive"></i> Archive (<span class="archive-count"><?php echo $count_archive_messages; ?></span>)</h4></a>
											</li>	
												
										</ul>
										<!-- /Nav tabs -->
									
										<!-- Tab panes -->
										<div class="tab-content">
											
											<div role="tabpanel" class="tab-pane active" id="tab1">
											<br/>
										<?php
											if($messages_unread > 0){
										?>
											<h3>You have (<span class="inbox-count"><?php echo $messages_unread; ?></span>) unread message(s) and notification(s).</h3>
												
										<?php
											}
										?>
												
										<!-- Main content -->
										<div class="">
										  <div class="row">
											<div class="col-md-2 col-sm-12 col-xs-12">
											  
												<button data-toggle="modal" data-target="#mailerModal" class="btn btn-sm btn-success btn-block" type="button"><i class="fa fa-comment"></i> COMPOSE</button>
												<div class="box box-solid">
													<div class="box-header with-border">
														<h3 class="box-title">Folders</h3>

														<div class="box-tools">
															<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
															</button>
														</div>
													</div>
													<div class="box-body no-padding">
														<ul class="nav nav-stacked">
															<li class="active">
																<a href="javascript:void(0)">
																	<i class="fa fa-inbox"></i> Inbox
																	  <span id="inbox-count" class="label label-primary pull-right">
																		<?php echo $messages_unread ;?>
																	  </span>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/sent');?>'" title="Sent">
																	<i class="fa fa-paper-plane"></i> Sent
																	 <span class="label label-success pull-right">
																		<?php echo $count_sent_messages;?>
																	 </span>
																</a>
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
												$attributes = array('name' => 'message_archive_form','id' => 'message_archive_form');
																			
												//start message form
												echo form_open('message/multi_archive', $attributes);
																		
												$hidden = array('table' => 'inbox',);	
												echo form_hidden($hidden);	
												$disabled = 'disabled';		
												if($count_inbox_messages > 0){
													$disabled = '';
												}							
											?>	
				
												
												
												<div class="box-body no-padding">
												 
													<!-- table-responsive -->
													<div class="table-responsive mailbox-messages" >
														
														<!-- inbox-table -->
														<table id="inbox-messages-table" class="table table-hover table-striped text-muted mailbox-messages " cellspacing="0" width="100%">
															<thead>
																<tr>
																	<th width="28%">
																	<div class="mailbox-controls">
																		<!-- Check all button -->
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Select All" <?php echo $disabled; ?>><i class="fa fa-square-o"></i>
																		 Select All</button>
																		<button type="button" class="btn btn-warning btn-sm" title="Archive" data-toggle="modal" data-target="#archiveModal" id="archiveButton" ><i class="fa fa-archive"> Archive</i></button>
																		
																	</div>
																	</th>
																	
																	<th width="25%">Sender</th>
																	<th width="27%">Subject</th>
																	<th width="20%">Date</th>
																			
																</tr>
															</thead>
															<tbody>
															</tbody>
														 
														</table>
														<!-- /inbox-table -->
													</div>
													<!-- /table-responsive -->
													
												<!-- Archive Modal -->
												<div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
													<div class="modal-content">
													  <div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h3 align="center">Archive Message(s)?</h3>
														
													  </div>
													  <div class="modal-body" align="center">
														<strong>Are you sure you want to archive the selected message(s)?</strong>
													  </div>
													  <div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
														
														<input type="button" name="inboxArchive" onclick="multiMessageArchive()" class="btn btn-info" value="Archive">
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
												<div role="tabpanel" class="tab-pane" id="tab2">
												<br/>
												<div class="">
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
														
														<div id="response-message"></div>
												
													<?php 

														//define form attributes
														$attributes = array('name' => 'move_to_inbox_form','id' => 'move_to_inbox_form');
																					
														//start message form
														echo form_open('message/move_to_inbox', $attributes);
														$hidden = array('table' => 'archives',);	
														echo form_hidden($hidden);		
														$disabled = 'disabled';		
														if($count_archive_messages > 0){
															$disabled = '';
														}							
													?>	

												<!-- table-responsive -->
													<div class="table-responsive" >
														<!-- archive-table -->
														<table id="archive-messages-table" class="table table-hover table-striped text-muted mailbox-messages" cellspacing="0" width="100%">
															<thead>
																<tr>
																	<th>
																	<div class="mailbox-controls">
																		<!-- Check all button -->
																		<button type="button" class="btn btn-default btn-sm checkbox-toggle" <?php echo $disabled; ?>><i class="fa fa-square-o"> Select all</i>
																		</button>
																		<button type="button" class="btn btn-success btn-sm" title="Archive" data-toggle="modal" data-target="#movetoInboxModal" id="undoButton" ><i class="fa fa-undo"></i></button>
																	</div>
																	</th>
																	
																	<th>Sender</th>
																	<th>Subject</th>
																	<th>Date</th>
																			
																</tr>
															</thead>
															<tbody>
															</tbody>
														 
														</table>
														<!-- /archive-table -->
													</div>
													<!-- /table-responsive -->
															
													<!-- Move to Inbox Modal -->
													<div class="modal fade" id="movetoInboxModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
													  <div class="modal-dialog" role="document">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h3 align="center">Move Message(s) to Inbox?</h3>
															
														  </div>
														  <div class="modal-body" align="center">
															<strong>Are you sure you want to move the selected message(s) back to your inbox?</strong>
														  </div>
														  <div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
															
															<input type="button" onclick="moveMessages()" class="btn btn-primary" value="Move">
														  </div>
														</div>
													  </div>
													</div>		
										<?php 	
													
											//	close the form
											echo form_close();	
										?>	
													
														
														</div>
													</div>
												</div>
												
							
												
												
												</div>
											</div>
										</div>
										<!-- /.nav-tabs-custom -->
										
										
									</div>
								</div>			
							</div>	
							</div>
						</div>
					</div>
				</div>
			
			</div>
        </div>
        <!-- /page content -->

		

	<!-- reply message modal-->
		<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="headerTitle"></h3>
					<div id="alert-message"></div>
					
				  </div>
				  <div class="modal-body">
						<?php	
							$attrs = array(
								'id' => 'reply_form',
								'name' => 'replyForm',
							);
							echo form_open('message/reply_message',$attrs);
										
						?>	
						
						<div class="form-group">
							<span id="replying_to"></span>
						</div>
						<div class="form-group">
							<input class="form-control" name="message_subject" id="messageSubject" placeholder="Subject:">
							
						</div>
						<div class="form-group">
						
							<div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
								<div class="btn-group">
								  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
								  <ul class="dropdown-menu">
								  </ul>
								</div>

								<div class="btn-group">
								  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
								  <ul class="dropdown-menu">
									<li>
									  <a data-edit="fontSize 5">
										<p style="font-size:17px">Huge</p>
									  </a>
									</li>
									<li>
									  <a data-edit="fontSize 3">
										<p style="font-size:14px">Normal</p>
									  </a>
									</li>
									<li>
									  <a data-edit="fontSize 1">
										<p style="font-size:11px">Small</p>
									  </a>
									</li>
								  </ul>
								</div>

								<div class="btn-group">
								  <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
								  <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
								  <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
								  <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
								</div>

								<div class="btn-group">
								  <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
								  <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
								  <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
								  <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
								</div>

								<div class="btn-group">
								  <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
								  <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
								  <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
								  <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
								</div>

								<div class="btn-group">
								  <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
								  <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
								</div>
							  </div>

							  <div id="message_editor" class="editor-wrapper" ></div>

							<textarea name="message_details" id="messageDetails" class="form-control" style="display:none;height: 100px">
							</textarea>
							
							<p class="small">Attach files below (allowed types:pdf, doc, docx, jpg, jpeg and png)</p>
							
							<div class="input_file_wrap">
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Attach file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="documents[]" multiple></span>
										<span class="fileinput-filename"></span>
										<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
									</div>
								</div>
							</div>
							<p><a href="!#" class="upload_more_button"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
						
							<input type="hidden" name="message_id" id="messageID" >
							<input type="hidden" name="sender_name" id="senderName" >
							<input type="hidden" name="sender_email" id="senderEmail" >
							<input type="hidden" name="receiver_name" id="receiverName" >
							<input type="hidden" name="receiver_email" id="receiverEmail" >
						</div>
						
						
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" name="reply" onclick="javascript:submitReply();" id="replyBtn" value="Send Reply">
					<?php
						echo form_close();
					?>
				  </div>
				</div>
			  </div>
		</div>	
		
		<!-- /reply message modal-->		
		
		
	

	<!-- SEND MESSAGE / BULK MAIL -->
	
		<div class="modal fade" id="mailerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="messageTitle"></h3>
						
					</div>
					<div class="modal-body">
						<span class="error-message"></span>
					<!-- form -->
					<form action="<?php echo base_url('message/new_message_validation'); ?>" id="message_form" name="message_form" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
						
						<div class="form-group">
							
							<select name="address_book" class="select2_single form-control" tabindex="-1" id="address_book">
								<option value="0">Select Recipient</option>
									<optgroup label="Customer Support">
										<option value="Customer Support - support">Customer Support</option>
									</optgroup>
									<optgroup label="Address Book">
									<?php
										if($address_book_array) {
											foreach($address_book_array as $address){
												echo '<option value="'.$address->receiver_name.' - '.$address->receiver_username.'" >'.$address->receiver_name.'</option>';		
											}
										}else{
											echo '<option value="0" >No addresses</option>';
										}
									?>
												
									</optgroup>
								
							</select>
							<input type="hidden" name="receiver_name" id="receiver_name">
							<input type="hidden" name="receiver_email" id="receiver_email">
							<input type="hidden" name="sender_name" id="name" value="<?php echo $fullname; ?>">
							<input type="hidden" name="sender_email" id="username" value="<?php echo $email; ?>">
							<input type="hidden" name="model" id="model" >
						</div>
						<div class="form-group">
							<input class="form-control" name="message_subject" id="message_subject" placeholder="Subject:">
						</div>
						<div class="form-group">
							<textarea name="message_details" id="message_details" class="form-control" style="width: 100%; height: 85px;" placeholder="Message"></textarea>
						</div>
						<p class="small">Attach files below (allowed types:pdf, doc, docx, jpg, jpeg and png)</p>
						<div class="input_file_wrap">
							<div class="form-group">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn btn-default btn-file btn-xs"><span class="fileinput-new">Attach file <i class="fa fa-paperclip" aria-hidden="true"></i></span><span class="fileinput-exists">Change</span><input type="file" name="documents[]" multiple></span>
									<span class="fileinput-filename"></span>
									<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
								</div>
							</div>
						</div>
						<p><a href="!#" class="upload_more_button"><span aria-hidden="true"><i class="fa fa-plus-circle"></i> Upload More</span></a> </p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							<i class="fa fa-times"></i> Discard
						</button>
						
						<button type="button" class="btn btn-primary" onclick="javascript:newMessage();" id="messageBtn">
						Send
							<i class="fa fa-arrow-circle-right"></i>
						</button>
					</form> 
					<!-- ./form -->
					</div>
				</div>
			</div>
		</div>	
	
	<!-- ./SEND MESSAGE / BULK MAIL -->
					
