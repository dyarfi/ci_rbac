<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title><?php echo $title; ?></title>
<link href="<?php echo base_url();?>css/superfish/superfish.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/colorbox/colorbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/library.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/superfish/superfish.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/superfish/hoverIntent.js"></script>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<?php $this->load->view('header'); ?>
	</div>
	<div id="navigation">
		<?php $this->load->view('navigation'); ?>
	</div>
	<div id="main">
		<div class="messageFlash">
			<?php $this->load->view('flashdata'); ?>
		</div>
		<div class="content">
			<?php $this->load->view($main); ?>
		</div>
	</div>
	<div id="footer">
		<?php $this->load->view('footer'); ?>
	</div>
</div>
</body>
</html>


