
		
		
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
								$atts = array('name' => 'inbox_search_form','id' => 'inbox_search_form');
								echo form_open('message/inbox_search',$atts);
							?>
								<div class="inner-addon right-addon">
									<input type="text" class="form-control" name="search" id="search" placeholder="Search mail">
									<i class="fa fa-search" aria-hidden="true"></i>
									<input type="hidden" value="inbox" id="hidden">
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
														<ul class="nav nav-pills nav-stacked">
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
											<div class="col-md-9 col-sm-12 col-xs-12">
												<div class="box box-success">
													<div class="box-header with-border">
														<span id="display_option"><?php echo $display_option; ?></span>
														<div id="success-message"></div>
													</div>
													<!-- /.box-header -->
										<?php 

											//define form attributes
											$attributes = array('name' => 'message_delete_form','id' => 'message_delete_form');
																
											//start message form
											echo form_open('message/multi_delete', $attributes);
															
											$hidden = array('table' => 'inbox_messages',);	
											echo form_hidden($hidden);	
											$disabled = 'disabled';		
											if($count_inbox_messages > 0){
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
															
																//check if message has been read
																if($message->opened == "0"){		
																	$textWeight = 'msgDefault';	
																	$icon = '<i class="fa fa-circle"></i>';
																}else{	
																	$textWeight = 'msgRead';
																	$icon = '<i class="fa fa-circle-o"></i>';
																}			

																//check if message has been replied
																if($message->replied == "1"){
																	$replied = '<i class="fa fa-reply" aria-hidden="true"></i>';		
																}else{		
																	$replied = '';
																}	
																
													?>
															<tr>
																<td><input type="checkbox"name="cb[]" id="cb" value="<?php echo $message->id; ?>"></td>
																<td><i class="fa fa-reply" aria-hidden="true"></i></td>
																<td><?php echo $message->sender_name; ?></td>
																
																<td class="mailbox-subject">
																
																<span class="messageToggle" style="padding:3px;">
																<a href="javascript:void(0)" class="<?php echo $textWeight; ?>" id="subj_line_<?php echo $message->id; ?>" onclick="markAsRead(<?php echo $message->id; ?>); "><?php echo stripslashes($message->message_subject); ?></a>
																</span>
																
																<div class="messageDiv"><br/><?php echo 
																	stripslashes(wordwrap(nl2br($message->message_details), 54, "\n", true)); ?>
																	<br/><br/>
																	<strong> 
																	<a data-toggle="modal" data-target="#replyModal" class="btn btn-default reply_message" id="<?php echo $message->id;?>"><i class="fa fa-reply"></i> Reply</a></strong>
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
					Delete Messages?
					<div id="delete-errors"></div>
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected messages?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" name="deleteBtn" onclick="multiMessageDelete()" class="btn btn-danger" value="Delete">
				  </div>
				</div>
			  </div>
			</div>		
<?php 	
			
	//	close the form
	echo form_close();	
?>			
		
		

	<!-- reply message modal-->
		<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
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
								  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
								  <div class="dropdown-menu input-append">
									<input class="span2" placeholder="URL" type="text" data-edit="createLink" />
									<button class="btn" type="button">Add</button>
								  </div>
								  <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
								</div>

								<div class="btn-group">
								  <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
								  <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
								</div>

								<div class="btn-group">
								  <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
								  <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
								</div>
							  </div>

							  <div id="message_editor" class="editor-wrapper" ></div>

							<textarea name="message_details" id="messageDetails" class="form-control" style="display:none;height: 100px">
							</textarea>
							
							<input type="hidden" name="message_id" id="messageID" >
							<input type="hidden" name="sender_name" id="senderName" >
							<input type="hidden" name="sender_username" id="senderUsername" >
							<input type="hidden" name="receiver_name" id="receiverName" >
							<input type="hidden" name="receiver_username" id="receiverUsername" >
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
					<form action="<?php echo base_url('message/bulk_message_validation'); ?>" id="mailer_message_form" name="mailer_message_form" data-parsley-validate class="form-horizontal form-label-left input_mask" method="post">
						
						<div class="form-group">
							
							<select name="address_book" class="select2_single form-control" tabindex="-1" id="address_book">
								<option value="0">Select Recipient</option>
								
								
								<optgroup label="Admins">
								<?php
									$this->db->from('admin_users');
									$this->db->order_by('id');
									$result = $this->db->get();
									if($result->num_rows() > 0) {
										foreach($result->result_array() as $row){
											
											if($fullname != $row['admin_name']){
												echo '<option value="'.$row['admin_name'].' - '.$row['admin_username'].'" >'.$row['admin_name'].' - '.$row['admin_username'].'</option>';	
											}		
										}
									}
								?>
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
											
								<optgroup label="Mass Mailing">
									<option value="team_members">Team Members</option>
									<option value="clients">Clients</option>
								</optgroup>
							</select>
					<input type="hidden" name="sender_name" id="name" value="<?php echo $fullname; ?>">
					<input type="hidden" name="sender_username" id="username" value="<?php echo $username; ?>">
						</div>
						<div class="form-group">
							<input class="form-control" name="message_subject" id="message_subject" placeholder="Subject:">
						</div>
						<div class="form-group">
							<textarea name="message_details" id="message_details" class="form-control message_details" style="height: 100px">
							</textarea>
							
						</div>
						
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
					
