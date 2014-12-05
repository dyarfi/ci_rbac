<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.1.1
Version: 2.0.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<?php
//print_r(Acl::instance()->user);
?>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?=$this->config->item('developer_name');?> | Admin Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?=admin_theme()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>

<link href="<?=admin_theme()?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<!--<link href="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>-->
<link href="<?=admin_theme()?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>



<!-- END PAGE LEVEL PLUGIN STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?=admin_theme()?>assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" href="<?=admin_theme()?>assets/plugins/data-tables/DT_bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->


<!-- BEGIN THEME STYLES -->
<link href="<?=admin_theme()?>assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/css/pages/tasks.css" rel="stylesheet" type="text/css"/>
<link href="<?=admin_theme()?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=admin_theme()?>assets/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="<?=admin_theme()?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<script>base_URL = '<?=base_url()?>';</script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="<?=base_url();?>" target="_blank">
			<img src="<?=admin_theme()?>assets/img/logo_small.png" alt="logo" class="img-responsive col-md-7 col-lg-7"/>
		</a>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="<?=admin_theme()?>assets/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->		
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">
			<!-- BEGIN NOTIFICATION DROPDOWN -->
		
			<!-- END NOTIFICATION DROPDOWN -->
			
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="<?=base_url();?>admin/user/view/<?=ACL::user()->id;?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="<?=base_url()?>assets/img/avatar1_small.jpg"/>&nbsp;
					<span class="username">
						<?=ACL::user()->name;?>
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">				
					<li>
						<a href="<?=base_url();?>admin/user/view/<?=ACL::user()->id;?>"><i class="fa fa-user"></i> Profile</a>
					</li>
					<li>
						<a href="javascript:;">
							<i class="fa fa-lock"></i> Last Login <?php echo date('Y-m-d, H:i:s',ACL::user()->last_login);?>
						</a>
					</li>
					<li>
						<a href="<?=base_url()?>admin/authenticate/logout">
							<i class="fa fa-key"></i> Log Out
						</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
		
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">

	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<?php /*echo preg_match('/\b'.Request::$current->controller().'\b/i', substr($row_function, 0, strpos($row_function, '/'))) ? 'current' : ''; */ ?>
				
				<!--li class="start <?if(preg_match('/\b'.$this->uri->segment(2).'\b/i', 'dashboard')){?>active<?}?> ">
					<a href="<?=base_url(ADMIN.'dashboard/index')?>">
						<i class="fa fa-home"></i>
						<span class="title">
							Dashboard
						</span>
						<?
                        if($this->uri->segment(1)=='__admin_dashboard')
						{
							?>
							<span class="selected">
						</span>
							<?
						}
						?>
					</a>
				</li>
				
				<li class="<?if(preg_match('/\b'.$this->uri->segment(2).'\b/i', 'user')){ ?>active<?}?>">
					<a href="javascript:;">
						<i class="fa fa-user"></i>
						<span class="title">
							User Control
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li class="<?if(preg_match('/\b'.$this->uri->segment(2).'\b/i', 'user')){?>active<?}?>">
							<a href="<?=base_url(ADMIN.'user/index')?>">
								 List User
							</a>
						</li>
						<li class="<?if(preg_match('/\b'.$this->uri->segment(2).'\b/i', 'usergroup')){?>active<?}?>">
							<a href="<?=base_url(ADMIN.'usergroup/index')?>">
								 List Groups
							</a>
						</li>
					</ul>
				</li-->
						
			<?php				
				$k = 0;
				foreach (Acl::admin_system_modules() as $name => $functions) { 
					if (is_array($functions) && count($functions) != 0) { ?>
					<li class="<?if(preg_match('/\b'.$this->uri->segment(2).'\b/i', strtolower($name))){ ?>active<?}?>">
						<a class="" href="#collapse<?php echo $k;?>">
							<span class="title"><?php echo $name; ?></span><span class="arrow "></span>
						</a>					
						<ul class="sub-menu"> 
							<?php foreach ($functions as $row_function => $row_label) { ?>
								<?php if(Acl::user()->group_id != 1 && $row_label == 'Groups') continue; ?>
								<li class="<?php echo preg_match('/\b'.$this->uri->segment(2).'\b/i', substr($row_function, 0, strpos($row_function, '/'))) ? 'active' : ''; ?>">
									<a href="<?php echo base_url(ADMIN . $row_function); ?>"><?php echo $row_label; ?></a>
								</li>
							<?php } ?>
						</ul>				
					</li>
				<?php } 
				$k++;
				} 
			?>

			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	
	<!-- BEGIN CONTENT -->
		<?=$this->load->view($main);?>
	<!-- END CONTENT -->
	
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
	<?php $this->load->view('template/footer'); ?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?=admin_theme()?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?=admin_theme()?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!--script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script-->
<script src="<?=admin_theme()?>assets/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="<?=admin_theme()?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

<script src="<?=admin_theme()?>assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/data-tables/DT_bootstrap.js"></script>


<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?=admin_theme()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script src="<?=admin_theme()?>assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=admin_theme()?>assets/scripts/core/app.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/scripts/custom/index.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/scripts/custom/tasks.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/scripts/custom/table-managed.js"></script>
<script src="<?=admin_theme()?>assets/scripts/custom/components-pickers.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN USER AJAX JAVASCRIPTS -->
<script src="<?=admin_theme()?>assets/scripts/custom/form-user.js" type="text/javascript"></script>
<script src="<?=admin_theme()?>assets/scripts/custom/form-module.js" type="text/javascript"></script>
<!-- END USER AJAX JAVASCRIPTS -->

<script>
jQuery(document).ready(function() {    
   App.init(); // initlayout and core plugins
   
   TableManaged.init();
   
   ComponentsPickers.init();   
   
   Index.init();
   //Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Index.initDashboardDaterange();
   Index.initIntro();
   Tasks.initDashboardWidget();
   
   
   FormUser.init();
   FormModule.init();
   
<?php if ($this->session->flashdata('message')) { ?>
		bootbox.alert('<h3><?php echo $this->session->flashdata('message');?></h3>');
<?php } ?>
	
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>