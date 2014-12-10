<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>
	
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/public/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="<?php echo base_url();?>assets/public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/public/css/animate.css" rel="stylesheet" />
    <!-- Squad theme CSS -->
    <link href="<?php echo base_url();?>assets/public/css/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/public/color/default.css" rel="stylesheet">
	
	<script type="text/javascript">
	var base_url = '<?php echo base_url();?>';
	</script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
	<div id="wrapper">
		
		<?php $this->load->view('template/public/header'); ?>
	
		<div id="navigation">
			<?php $this->load->view('template/public/navigation'); ?>
		</div>
		
		<div id="main">
			<div class="messageFlash">
				<?php $this->load->view('flashdata'); ?>
			</div>
			<div class="content">
				<?php $this->load->view($main); ?>
			</div>
		</div>
	
	<?php $this->load->view('template/public/footer'); ?>
	<!-- Core JavaScript Files -->
    <script src="<?php echo base_url();?>assets/public/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/public/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/public/js/jquery.easing.min.js"></script>	
	<script src="<?php echo base_url();?>assets/public/js/jquery.scrollTo.js"></script>
	<script src="<?php echo base_url();?>assets/public/js/wow.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/public/js/custom.js"></script>
</body>
</html>


