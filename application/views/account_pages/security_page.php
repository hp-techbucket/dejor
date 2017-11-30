<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
?>

		
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
								
						<div class="clearfix"></div>
								
						<!-- breadcrumb -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li>
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'" title="Dashboard">
											<i class="fa fa-home"></i> Dashboard
										</a>
									</li>	
									<li>
										<a href="javascript:void(0)" onclick="location.href='<?php echo base_url(); ?>account/profile'" title="Profile"><i class="fa fa-user"></i> Profile</a>
											
									</li>		
									<li class="active">
										<i class="fa fa-lock"></i> <?php echo $pageTitle;?>
									</li>
								</ol>
							</div>
						</div>
						<!-- /breadcrumb -->
					</div>
					<div class="x_content">
						<div class="notif"></div>
						
						
						<div class="row">
							<div class="col-lg-12">
								
								<h3 class="text-primary profile-header">CHANGE SECURITY INFORMATION</h3>
								
								<br/><br/>
								
								
								<!-- #security-check-->
								<div id="security-check">
								
									<?php 
										$form = array(
											'class' => 'form-horizontal',
											'id' => 'security_validate',
										);
										//start message form
										echo form_open('account/security_validate',$form);
									?>	
										<div class="form-group">
											<div class="col-sm-5">
												<label class="">Security Question</label>
												<input type="text" class="form-control" id="security_question" value="<?php echo $security_question; ?>" name="security_question" readonly>
												
											</div>
										</div>
										  
										<div class="form-group">
											<div class="col-sm-5">
												<label for="security_answer">Security Answer</label>

												<input type="text" class="form-control" id="security_answer" value="<?php echo set_value('security_answer'); ?>" name="security_answer">
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-sm-5">
													
												<input type="button" class="btn btn-primary btn-block" onclick="javascript:validateSecurity();" value="Confirm">
											</div>
										</div>
										  
									<?php 
										echo form_close();
									?>	
									
								</div>	
								<!-- /.settings-section /#security-check-->
								
								
								
								<!-- .settings-section #security-change-->
								<div class="settings-section" id="security-change">
								
									<?php 
										$attributes = array(
											'class' => 'form-horizontal',
											'id' => 'security_update',
										);
										//start message form
										echo form_open('account/security_update',$attributes);
									?>	
										<div class="form-group">
											<div class="col-sm-5">
												<label class="">Security Question</label>
												<select name="security_question" class="form-control select2" id="securityQuestion" >
													<option value="" >Please Select a Question</option>
													<?php echo $select_security_questions ; ?>
													
												</select>
											</div>
										</div>
										  
										<div class="form-group">
											<div class="col-sm-5">
												<label for="security_answer">Security Answer</label>

												<input type="text" class="form-control" id="securityAnswer" value="<?php echo set_value('security_answer'); ?>" name="security_answer">
											</div>
										</div>
										 
											
										<div class="form-group">
											<div class="col-sm-5">
													
												<input type="button" class="btn btn-primary btn-block" onclick="javascript:changeSecurity();" value="Update">
											</div>
										</div>
										  
									<?php 
										echo form_close();
									?>	
									
								</div>	
								<!-- /.settings-section /#security-change-->
								
							</div>
						</div>
						<!-- /.row -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<?php   
		}
	}								
?>
