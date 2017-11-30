<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link href="<?php echo base_url();?>assets/images/icons/favicon.ico?<?php echo time();?>" rel="shortcut icon" type="image/ico" />
	
	<title><?php echo $pageTitle; ?></title>
	<meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="author" content="<?php echo $meta_author; ?>">
	<meta name="keywords" content="<?php echo $meta_keywords; ?>">
	<link rel="canonical" href="<?php echo base_url(); ?>" />
	<link rel="publisher" href="https://plus.google.com/+DejorAutos/"/>
	<meta property="og:locale" content="en_GB" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo $pageTitle; ?>" />
	<meta property="og:description" content="<?php echo $meta_description; ?>" />
	<meta property="og:url" content="<?php echo base_url(); ?>" />
	<meta property="og:site_name" content="Dejor Autos" />
	<meta property="fb:app_id" content="361099337567592" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="<?php echo $meta_description; ?>" />
	<meta name="twitter:title" content="<?php echo $pageTitle; ?>" />
	<meta name="twitter:site" content="@dejor" />
	
	<!-- Materialize.css style -->
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css"  media="screen,projection"/>
	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
	
	<!-- JQuery UI CSS -->
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	
	<!-- Font Awesome -->
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	
    <!-- Datatables -->
	<link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet">	
	<link href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css" rel="stylesheet">
	
	<!-- Jasny-Bootstrap -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
	
    
	<!-- Select2 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">
	
	<!-- starrr -->
	<link href="<?php echo base_url(); ?>assets/css/starrr.css?<?php echo time(); ?>" rel="stylesheet">
	
	<!-- Animate.css style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
   
	<!-- Fancybox -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.20/jquery.fancybox.min.css" />
	
	<!-- Custom Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css?<?php echo time();?>" media="all"/>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
	
   
	
</head>
<body class="main-body" id="<?php echo $pageID; ?>">

<div id="load"></div>
  
<!-- First Nav #navbar-wrapper-->	
<div id="navbar-wrapper">
	<div class="navbar navbar-success">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo base_url();?>">
					<img alt="Brand" src="<?php echo base_url('assets/images/logo/logo2.png');?>" width="" height="">
				</a>
			</div>
			
			<ul class="nav navbar-nav navbar-right">
				<li>
					
					<a href="mailto:info@dejor.com" >
						<i class="fa fa-envelope" aria-hidden="true"></i> info@dejor.com
					</a>
				</li>
				<li>
					<a>
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						Mon-Sat: 7:00-19:00
					</a>
				</li>
				<li>
					
					<a href="callto:1-800-676-4422" >
						<i class="fa fa-phone" aria-hidden="true"></i>1-800-676-4422
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /First Nav #navbar-wrapper-->



<!-- Second Nav #nav-->
<div id="nav">	
	<div class="navbar navbar-inverse navbar-static navbar-menu">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="main-navbar" class="navbar-collapse collapse">
			
				<ul class="nav navbar-nav">
				
					<li><a href="<?php echo base_url();?>">Home</a></li>
					
					<li><a href="<?php echo base_url('about');?>">About Us</a></li>
					
					<li><a href="<?php echo base_url('vehicle-finder');?>">Find Vehicles</a></li>
					
					
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Services <span class="caret"></span></a>
						<ul class="dropdown-menu fa-ul">
							<li><a href="<?php echo base_url('services');?>#history-check"><i class="fa-li fa fa-angle-right fa-fw"></i> History Check</a></li>
							<li><a href="<?php echo base_url('services');?>#buyers-guide"><i class="fa-li fa fa-angle-right fa-fw"></i> Buyers Guide</a></li>
							<li><a href="<?php echo base_url('services');?>#car-check"><i class="fa-li fa fa-angle-right fa-fw"></i> Car Check</a></li>		  
							<li><a href="<?php echo base_url('services');?>#car-insurance"><i class="fa-li fa fa-angle-right fa-fw"></i> Car Insurance</a></li>
							<li><a href="<?php echo base_url('services');?>#customer-support"><i class="fa-li fa fa-angle-right fa-fw"></i> Customer Support</a></li>
							<li><a href="<?php echo base_url('services');?>#warranty-programs"><i class="fa-li fa fa-angle-right fa-fw"></i> Warranty Programs</a></li>
						</ul>
					</li>
					
					<li><a href="<?php echo base_url('contact-us');?>">Contact Us</a></li>
					
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown search-dropdown"><a class="dropdown-toggle search-icon" data-toggle="dropdown" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
						<ul class="dropdown-menu">
							<div class="search-container">
								<form action="<?php echo base_url('main/search'); ?>" id="search-form" name="search-form" class="search-form" method="get" enctype="multipart/form-data">
								
								<div class="input-group input-field search-box">
									<input type="search" name="keywords" id="keywords" value="<?php echo set_value('keywords'); ?>" class="validate search-input">
									<label for="search">Search here</label>
									<div class="input-group-addon">
										<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
									</div>
								</div>
								</form>
								
							</div>
							<div class="search-results">
							</div>
						</ul>
					</li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> My Account <span class="caret"></span></a>
						<ul class="dropdown-menu fa-ul">
						<?php
							if(!$this->session->userdata('logged_in')){
						?>
							<li><a href="<?php echo base_url('signup');?>"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</a></li>
							
							<li><a href="<?php echo base_url('login');?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
						<?php
							}else{
						?>	
							<li><a href="<?php echo base_url('account');?>"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
							
							<li><a href="<?php echo base_url('account/logout/');?>"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
						<?php
							}
						?>	
						</ul>
					</li>
					
					
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- /Second Nav #nav-->


<?php
	if($pageID == 'login' || $pageID == 'signup' || $pageID == 'forgot_password'){
?>

	<div class="section grey darken-3 fade" align="center">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			<h4 class="white-text"><?php echo html_escape(strtoupper($pageTitle)); ?></h4>
			<div class="custom-breadcrumb">
				<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
				<span class="">
					<i class="fa fa-minus fa-lg" aria-hidden="true"></i> 
				</span>
				<?php echo html_escape($pageTitle);?>
			</div>
		</div>
	</div>
		

 
 
<?php
	}else if($pageID == 'view-vehicle'){
?>


	<div class="section grey darken-3 fade" align="center">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			<h4 class="white-text"><?php echo html_escape(strtoupper($pageTitle)); ?></h4>
			<div class="custom-breadcrumb">
				<a href="<?php echo base_url();?>" title="Home" class="">Home</a> 
				<span class="">
					<i class="fa fa-minus fa-lg" aria-hidden="true"></i> 
				</span>
				<a href="<?php echo base_url('vehicles');?>" title="Vehicles" class="">Vehicles</a> 
				<span class="">
					<i class="fa fa-minus fa-lg" aria-hidden="true"></i> 
				</span>
				<?php echo html_escape($pageTitle);?>
			</div>
			
		</div>
	</div>
		

 
<?php
	}
	
?>

  