<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo link_tag('assets/images/icons/favicon.ico', 'shortcut icon', 'image/ico'); ?>
    <title><?php echo $pageTitle; ?> | 404</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <?php echo link_tag('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'); ?>
    <!-- NProgress -->
    <?php echo link_tag('assets/css/nprogress.css'); ?>

    <!-- Custom Theme Style -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.min.css?<?php echo time(); ?>" media="all"/>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
              <h1 class="error-number"><?php echo $pageTitle; ?> | 404</h1>
              <h2>Sorry but we couldn't find this page</h2>
              <p>The page you are looking for does not exist
              </p>
              <div class="mid_center">
                <h3>Go Back</h3>
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>'" title="Home" class="btn btn-primary" type="button"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
				
               <?php if($this->session->userdata('admin_logged_in')){ ?>
			   
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('admin');?>'" title="Admin Dashboard" class="btn btn-info" type="button"><i class="fa fa-tachometer" aria-hidden="true"></i> Admin Dashboard</a>
			   <?php } ?>
			   
               <?php if($this->session->userdata('logged_in')){ ?>
			   
				<a href="javascript:void(0)" onclick="location.href='<?php echo base_url('account/dashboard');?>'" title="Dashboard" class="btn btn-info" type="button"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
			   <?php } ?>
			   
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
    <!-- NProgress -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>
  </body>
</html>
