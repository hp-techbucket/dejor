
<?php   
	if(!empty($users))
	{
		foreach($users as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $pageTitle;?> <small>(<?php if($count == ''){ echo '0 questions' ;}else{ echo $count .' questions';} ?>)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>admin/dashboard'" title="Dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>						
                            <li class="active">
                                <i class="fa fa-question-circle"></i> <?php echo $pageTitle;?>
                            </li>
                            <li>
								<a data-toggle="modal" data-target="#addQuestionModal" title="Add Question"><i class="fa fa-plus"></i> Add Question</a>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
	<div>	
	<?php 
	$message = '';
	if($this->session->flashdata('question_added') != ''){
		$message = $this->session->flashdata('question_added');
	}
	if($this->session->flashdata('question_updated') != ''){
		$message = $this->session->flashdata('question_updated');
	}		
	if($this->session->flashdata('question_deleted') != ''){
		$message = $this->session->flashdata('question_deleted');
	}		
	echo $message;						
	?>	
	</div>				
					
<p><?php echo nbs(2);?> <?php echo img('assets/images/icons/crookedArrow.png');?> <button class="btn btn-danger" data-toggle="modal" data-target="#multiDeleteModal" id="deleteButton" ><i class="fa fa-trash-o"></i> Delete</button></p>   								
                          
                <div class="row">
                    <div class="col-lg-12">
						
						<?php 
							//define form attributes
							$attributes = array('name' => 'myform');
												
							//start message form
							echo form_open('admin/multi_delete', $attributes);
							//Title bar checkbox property setting
							$data = array(
								'name' => 'checkBox',
								'id' => 'checkBox',
								'value' => 'accept',
								'checked' => false,
								
							);		
							$hidden = array('table' => 'security_questions',);	
							echo form_hidden($hidden);	
															
						?>	
			
			
					
						<div class="table-responsive" align="center">
							<table frame="box" class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo form_checkbox($data); ?></th>
										<th>ID</th>
										<th>Question</th>
										<th>Edit</th>
										
									</tr>
								</thead>
								<tbody class="question-tbody">
	<?php
							if($questions_array){
								
								foreach($questions_array as $question){	

									$data_checkbox = array(				
										'name' => 'cb[]',
										'id'   => 'cb',
										'value' => $question->id,
										'checked' => false,
									);		
									 											
	?>							
									<tr>
										<td><?php echo form_checkbox($data_checkbox); ?></td>
										
										<td><?php echo $question->id; ?></td>
										<td><?php echo $question->question; ?></td>
										<td><a data-toggle="modal" data-target="#editModal" class="btn btn-warning edit_sq" id="<?php echo html_escape($question->id);?>" title="Click to Edit"><i class="fa fa-pencil"></i></td>
									</tr>										
	<?php					
								}
							}else {
?>
								  <tr>
									<td colspan="3" align="center"><div class="alert alert-danger" role="alert">
									  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									  <span class="sr-only"></span> No questions!</div>
									</td>
								  </tr>

    <?php
       }
    ?>							
								</tbody>
							</table>
						</div>	
                    </div>
                </div>
                <!-- /.row -->
				
			<!-- Modal -->
			<div class="modal fade" id="multiDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Delete Question(s)?
				  </div>
				  <div class="modal-body">
					<strong>Are you sure you want to permanently delete the selected question(s)?</strong>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="submit" class="btn btn-danger" name="questionDelete"  value="OK">
				  </div>
				</div>
			  </div>
			</div>					
				
<?php 	
			
	//	close the form
	echo form_close();	
?>	
    <div class="row">
        <div class="col-md-12 text-center">
            <?php echo $pagination; ?>
        </div>
    </div>

		
<?php echo br(15); ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php   
		}
	}								
?>



		<!-- ADD Question -->
		<form action="admin/add_security_question" id="addSQuestionForm" name="addSQuestionForm" method="post" enctype="multipart/form-data">
			<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center">Add New Security Question</h3>
				  </div>
				  <div class="modal-body">
				  <div class="form_errors"></div>
					
					<div class="row">
						<div class="col-lg-12">

							<div>
								<?php echo form_label('Please enter a new security question below:', 'question'); ?><br/>
								<input type="text" value="<?php echo set_value('question'); ?>" id="squestion" name="security_question" placeholder="Enter a new Security Question">
								<?php echo form_error('question'); ?>
								<?php echo br(2); ?>
								<input type="button" class="btn btn-primary" onclick="javascript:addSQuestion();" value="Add New Security Question">
								
							</div>	
													
						</div>
					</div>
					<!-- /.row -->					
					<div id="alert-msg"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- Add Question -->
		
		
		
		<!-- Edit Question -->
		<form action="javascript:updateSQuestion();" id="updateSQuestionForm" name="updateSQuestionForm" method="post" enctype="multipart/form-data">
			
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 align="center" id="name"></h3>
				  </div>
				  <div class="modal-body">
					<div class="scrollable">
						<table class="table table-striped">
				
							<tr>
								<td align="right"><label>Question:</label>
								<input type="hidden" name="squestionID" id="squestionID">
								</td>
								<td align="left"><input type="text" name="security_question" id="full_squestion"></td>
							</tr>	
							
						</table>						
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					
					<input type="button" class="btn btn-primary" onclick="javascript:updateSQuestion();" value="Update Question">
				  </div>
				</div>
			  </div>
			</div>	
		</form>		
		<!-- /Edit Question -->