<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php echo $pageTitle; ?>">
    <meta name="author" content="">
	<link href="<?php echo base_url();?>assets/images/icons/favicon.ico?<?php echo time();?>" rel="shortcut icon" type="image/ico" />
	
	<title><?php echo $pageTitle; ?></title>
 
	<!-- Custom Materialize style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin-materialize.css?<?php echo time(); ?>">

	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<!-- JQuery UI CSS -->
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	<?php echo link_tag('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	
	<!-- Font Awesome -->
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	
    <!-- Datatables -->
	<link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet">	
	<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">
	
	<!-- Jasny-Bootstrap -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
	
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">
	
	<!-- Tagsinput -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.3/jquery.tagsinput.css">
	
	<!-- starrr -->
	<link href="<?php echo base_url(); ?>assets/css/starrr.css?<?php echo time(); ?>" rel="stylesheet">
		
	<!-- daterange picker -->
    <!-- <link href="<?php base_url(); ?>assets/css/daterangepicker.css" rel="stylesheet">
	 -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	
  	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap3-wysihtml5.min.css">
	
	<!-- Animate.css style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
  
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.css">
  
    <!-- Custom Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.min.css?<?php echo time(); ?>" media="all"/>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/admin.css?<?php echo time(); ?>" media="all"/>
	
	<!-- Fancybox -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
    
  </head>
  
  <body id="<?php echo $pageID;?>" class="nav-md">
  <div id="load"></div>
  
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('home/');?>" class="site_title"><img alt="Brand" src="<?php echo base_url('assets/images/logo/logo2.png');?>" width="" height=""></a>
            </div>

            <div class="clearfix"></div>


<?php   
	if(!empty($user_array))
	{
		foreach($user_array as $user) // user is a class, because we decided in the model to send the results as a class.
		{	
			$profile_pic = '';
			$thumbnail = '';
			$user_avatar = $user->avatar;
			$user_id = $user->id;
			$filename = FCPATH.'uploads/users/'.$user_id.'/'.$user_avatar;
			
			if($user_avatar == '' || $user_avatar == null || !file_exists($filename)){
				$profile_pic = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="img-circle profile_img" alt="Profile Image" />';
				
				$thumbnail = '<img src="'.base_url().'assets/images/icons/avatar.jpg" alt="Profile Image" />';
										
			}else{
				$profile_pic = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'?'.time().'" class="img-circle profile_img" alt="Profile Image" />';
				
				$thumbnail = '<img src="'.base_url().'uploads/users/'.$user_id.'/'.$user_avatar.'?'.time().'" alt="Profile Image" />';
										
			}
			
?>			
			
            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
               <?php echo $profile_pic;?>
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $user->first_name .' '.$user->last_name;?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
				<div class="menu_section">
					<h3>General</h3>
					<ul class="nav side-menu">
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/dashboard/'" title="Dashboard">
								<i class="fa fa-home"></i> Dashboard 
							</a>
						</li>
						<li>
							<a id="private-messages" href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox');?>'" title="Private Messages">
								<i class="fa fa-inbox"></i> Private Messages <span class="badge bg-green pull-right messages-unread"><?php echo $messages_unread; ?></span>
							</a>
							
						</li>
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/sale-enquiries');?>'" title="Sale Enquiries">
								<i class="fa fa-question-circle"></i> Sale Enquiries <span class="badge bg-blue pull-right"><?php echo $enquiries_unread; ?></span>
							</a>
							
						</li>
													
						<li>
							<a href="javascript:void(0)" id="vehicles-link" onclick="location.href='<?php echo base_url();?>account/vehicles/'" title="Vehicles" ><i class="fa fa-car" aria-hidden="true"></i> Vehicles</a>
							
						</li>
						<li>
							<a href="javascript:void(0)" id="orders-link" onclick="location.href='<?php echo base_url();?>account/orders/'" title="Orders" ><i class="fa fa-th-list" aria-hidden="true"></i> Orders</a>
						</li>
						<li>
							<a href="javascript:void(0)" id="transactions-link" onclick="location.href='<?php echo base_url();?>account/transactions/'" title="Transactions" ><i class="fa fa-exchange" aria-hidden="true"></i> Transactions</a>
						</li>
						
						<li>
							<a href="javascript:void(0)" id="shipping-link" onclick="location.href='<?php echo base_url();?>account/shipping/'" title="Track Shipping"><i class="fa fa-truck" aria-hidden="true"></i> Track Shipping</a>
						</li>
						
						<li>
							<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/reviews');?>'" title="Reviews">
								<i class="fa fa-commenting"></i> Reviews 
							</a>
							
						</li>		
					</ul>
				</div>
			

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/settings/'" data-toggle="tooltip" data-placement="top" title="Settings">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
				</a>
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>admin/site_activities/'" data-toggle="tooltip" data-placement="top" title="Alerts">
					<i class="fa fa-bell"></i>
				</a>
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/profile/'" data-toggle="tooltip" data-placement="top" title="Profile">
					<i class="fa fa-fw fa-user"></i>
				</a>
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/logout/'" data-toggle="tooltip" data-placement="top" title="Logout">
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
				</a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $thumbnail;?> <?php echo $user->first_name .' '.$user->last_name;?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
						<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/profile/'" title="Profile">
						<i class="fa fa-fw fa-user"></i> Profile
						</a>
					</li>
                    <li>
                      <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/settings/'" title="Settings">
                        <i class="fa fa-fw fa-gear"></i>
                        <span>Settings</span>
                      </a>
                    </li>
                    
                    <li>
						<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>account/logout/'" title="Log Out">
						<i class="fa fa-fw fa-sign-out "></i> Log Out
						</a>
					</li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green messages-unread"><?php echo $messages_unread;?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                   <?php
						//check messages array for messages to display			
						if(!empty($header_messages_array)){			
							//obtain each row of message
							foreach ($header_messages_array as $message){			
								$sender_image = '';
								$avatar = '';
								$sender_id = '';
								$u_array = $this->Admin->get_user($message->sender_email);
								if($u_array){
									foreach($u_array as $u){
										$avatar = $u->avatar;
										$sender_id = $u->id;
									}
									$filename = FCPATH.'uploads/admins/'.$sender_id.'/'.$avatar;
									if($avatar == '' || $avatar == null || !file_exists($filename)){
										$sender_image = '<img src="'.base_url().'assets/images/icons/avatar.jpg" class="" alt="Profile Image" />';
										
									}else{
										$sender_image = '<img src="'.base_url().'uploads/admins/'.$sender_id.'/'.$avatar.'" class="" alt="Profile Image" />';
										
									}
								}
								
				
								$url = 'message/detail';
								//base_url('assets/images/img/img.jpg')
								//class="detail-message"
								//substr($message->message_details, 0, 35).'...'
								$elip = strlen($message->message_details) > 35 ? '...' : '';
					?>					 
					
					<li>
                      <a data-toggle="modal" data-target="#previewModal" onclick="previewMessage(<?php echo $message->id;?>, '<?php echo $url;?>');" id="<?php echo $message->id;?>">
                        <span class="image"><?php echo $sender_image;?></span>
                        <span>
                          <span><?php echo $message->sender_name;?></span>
                          <span class="time"><?php echo $this->misc_lib->time_elapsed_string(strtotime($message->date_sent));?></span>
                        </span>
                        <span class="message">
                          <?php echo substr($message->message_details, 0, 35).''.$elip ;?>
                        </span>
                      </a>
                    </li>
     <?php
							}		
						}
						//	close the message form
		?>                
                   
                    <li>
                      <div class="text-center">
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url('message/inbox');?>'" title="See All Alerts" >
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

 <?php
		}		
	}
						
?>  

			<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 id="header_subject">Message Detail</h3>
				  </div>
				  <div class="modal-body message-preview">

						<div class="table-responsive">
							<table class="table table-striped" >
								<thead>
									<tr>
										<th width="25%" align="left">From</th>
										<th width="50%" align="center">Subject</th>
										<th width="25%" align="left">Date</th>
									</tr>
								</thead>					
								<tbody>
									<tr>
										<td align="left"><span id="show_name"></span></td>
										<td align="left">
											<u><span id="show_subject"></span> <span id="show_attachment"></span></u><br/><br/>
											<span id="show_message"></span>
											<br/>
											<span id="show_files"></span>
											<br/>
										</td>
										<td align="left"><span id="show_date"></span></td>
									</tr>
								</tbody>
							</table>
						</div>	
				  </div>

				</div>
			  </div>
			</div>	
			
	              		