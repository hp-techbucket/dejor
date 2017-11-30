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

	
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
	 <!-- Jquery UI CSS -->
	<?php echo link_tag('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'); ?> 
	
	<!-- Font Awesome style -->
	<?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
	
	<!-- Animate.css style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
   
	<!-- Jasny-Bootstrap -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
	
	 <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css"  media="screen,projection"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<!-- Custom Theme Style -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css?<?php echo time();?>" media="all"/>
	
	<script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
	<script type="text/javascript">var baseurl = "<?php echo base_url(); ?>";</script>
	
</head>
<body id="<?php echo $pageID; ?>">

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


	
	<!-- .section .fade .section-background -->
	<div class="section fade section-background">
	
		<!-- .row .container-medium -->
		<div class="row container-medium">
			
			<div class="col-md-6 col-md-offset-3">
			
				<div class="card">
				
					<div class="card-content form-content">
						
						<div class="" align="center">
							<img src="<?php echo base_url('assets/images/icons/login-avatar.png');?>" class="img-responsive img-circle" alt="">
						</div>
						
						<h5 class="teal-text text-lighten-2 text-center">
							<i class="fa fa-lock"></i> Admin Login
						</h5>
								<br/>
								
						
	
						<?php
							
							echo form_open('admin/login_validation');
							
							//echo md5('admin').'<br/>';
							
							//echo password_hash('admin', PASSWORD_DEFAULT);
							
						?>
						<p><?php echo form_error('username');?></p>
						
						<div class="row">
							<div class="form-group input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input type="text" name="username" id="username" value="<?php echo set_value('username');?>" title="Please enter your username" class="validate">
								<label for="username">Enter your Username</label>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group input-field col s12">
								<i class="material-icons prefix">lock</i>
								<input type="password" name="password" id="upass" value="<?php echo set_value('password');?>" class="validate">
								<label for="password">Enter your password</label>
								<span class="show-password-wrap">
									<a  class="teal-text text-lighten-2 show-password" href="#">Show</a>
								</span>
							</div>
						</div>
								
						<div class="row">
							<div class="input-field col s12">
								<button type="submit" class="btn btn-primary btn-block" >Log in</button>
							</div>
						</div>
						<?php	
							echo form_close();
						?>		
					</div>
				</div>
			</div>
		</div>
		<!-- /.row /.container-medium -->

				
	</div>
	<!-- /.section /.fade /.section-background -->
	
		
		
	
<!-- .section .grey darken-3 -->
<div class="section footer-section grey darken-3 fade" align="center">
		<!-- .row .container -->
		<div class="row container-medium">
			<div class="brand-footer">
				<img class="img-responsive" src="<?php echo base_url();?>assets/images/logo/oie_X3nMBDPW8aco.png" alt="DEJOR">
			</div>
		</div>
		<!-- /.row /.container -->
		
		<div class="social-icons">
			<a target="_blank" href="https://www.facebook.com/Dejor"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a>
			<a target="_blank" href="https://www.twitter.com/Dejor"><i class="fa fa-twitter fa-lg" aria-hidden="true"></i></a>
			<a target="_blank" href="https://www.pinterest.com/Dejor"><i class="fa fa-pinterest-p fa-lg" aria-hidden="true"></i></a>
			<a target="_blank" href="https://www.vimeo.com/Dejor"><i class="fa fa-vimeo fa-lg" aria-hidden="true"></i></a>
			<a target="_blank" href="https://plus.google.com/b/12121/+Dejor"><i class="fa fa-google fa-lg" aria-hidden="true"></i></a>
			<a target="_blank" href="https://www.twitter.com/Dejor"><i class="fa fa-rss fa-lg" aria-hidden="true"></i></a>
		</div>
		<p><i class="fa fa-copyright" aria-hidden="true"></i> 2017 Dejorautos.com. All Rights Reserved <a href="<?php echo base_url('terms-of-use');?>" title="Terms of Use">Terms of Use</a> and <a href="<?php echo base_url('privacy');?>" title="Privacy Policy">Privacy Policy</a></p>
				
</div>
<!-- /.section /.grey darken-3 -->
	
	
	
		 			
			
		<a title="Go to top" href="#" class="btn-floating btn-large waves-effect waves-light back-to-top"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
	
    <!-- JQuery scripts
    ================================================== -->
     <!-- Placed at the end of the document so the pages load faster -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<!--Materialize Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>

	<script src="<?php echo base_url('assets/js/jquery.easing.min.js'); ?>" type="text/javascript"></script>
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- Jasny-Bootstrap -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
		
	<!-- Bootstrap Validator -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
	
	<!-- Select2 -->
	<script src="<?php echo base_url('assets/js/select2.full.min.js'); ?>"></script>
	
	
		
	<!-- starrr -->
	<script src="<?php echo base_url(); ?>assets/js/starrr.js?<?php echo time(); ?>"></script>
	
	<!-- Facebox -->
    <script src="<?php echo base_url(); ?>assets/js/facebox.js?<?php echo time(); ?>"></script>
	
	<!-- Fancybox -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
	
	
	<!-- bootstrap-wysiwyg -->
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-wysiwyg.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-wysiwyg.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.hotkeys.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/prettify.js"></script>
	
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?php echo base_url('assets/js/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
	
	<!-- Datatables -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/buttons.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/responsive.bootstrap.js"></script>

	
	<!-- My custom scripts
    ================================================== -->

	<!-- Custom Theme Scripts -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.min.js?<?php echo time();?>"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js?<?php echo time();?>"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrapFormValidator.js?<?php echo time();?>"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/functions.js?<?php echo time();?>"></script>
	
	
</body>
</html>