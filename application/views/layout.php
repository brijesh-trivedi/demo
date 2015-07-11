<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>WhatsApp</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.4 -->
		<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />	

		<!-- Ionicons -->
		<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />

		<!-- DATA TABLES -->
		<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
		<link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap-Select Plugin -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
        <!-- elFInder plugin -->
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/plugins/elFinder/css/elfinder.min.css">
        <!-- Mac OS X Finder style for jQuery UI smoothness theme (OPTIONAL) -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/plugins/elFinder/css/theme.css">
        

		<!-- jQuery 2.1.4 -->
		<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="skin-green sidebar-mini">
		<div class="wrapper">
			<!-- Start header -->
			<?php echo $this->load->view('pages/header', null, true); ?>
			<!-- End header -->

			<!-- Start leftnav -->
			<?php echo $this->load->view('pages/leftnav', null, true); ?>
			<!-- End leftnav -->

			<div class="content-wrapper">
				<?php echo generateBreadcrumb(); ?>
				<!-- Start Main content -->
				<?php echo $content; ?>
				<!-- End Main content -->
			</div>

			<!-- Start footer -->
			<?php echo $this->load->view('pages/footer', null, true); ?>
			<!-- End footer -->
			<div class="settingloder showLoder" style="display: none; opacity: 2;">
				<div>
					<img alt="Search" src="<?php echo base_url(); ?>assets/loader/loading.gif">
				</div>
				<div>
					<span>
						<h3>  Processing . . .Please Wait. </h3>
					</span>
				</div>
			</div>
		</div>

		<script>
			$(function() {
				//Add text editor
				$("#compose-textarea").wysihtml5();
			});
		</script>
		<!-- jQuery UI 1.11.2 -->
		<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
		<!-- Bootstrap 3.3.2 JS -->
		<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.pipeline.js" type="text/javascript"></script>
		
		<!-- Sparkline -->   
		<script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>

		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js" type="text/javascript"></script>
		<!-- elFinder -->
		<script src="<?php echo base_url(); ?>assets/plugins/jquerybrowser/jquery.browser.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/elFinder/js/elfinder.min.js"></script>
		<!-- FastClick -->
		<script src='<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js'></script>
		<!-- AdminLTE App -->
		<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>

		<!-- AdminLTE for demo purposes -->
		<script src="<?php echo base_url(); ?>assets/dist/js/demo.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
	</body>
</html>