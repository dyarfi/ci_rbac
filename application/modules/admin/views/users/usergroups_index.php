<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="portlet-config" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
						<h4 class="modal-title">Modal title</h4>
					</div>
					<div class="modal-body">
						 Widget settings form goes here
					</div>
					<div class="modal-footer">
						<button class="btn blue" type="button">Save changes</button>
						<button data-dismiss="modal" class="btn default" type="button">Close</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<!-- BEGIN STYLE CUSTOMIZER -->
		<!--div class="theme-panel hidden-xs hidden-sm">
			<div class="toggler">
			</div>
			<div class="toggler-close">
			</div>
			<div class="theme-options">
				<div class="theme-option theme-colors clearfix">
					<span>
						 THEME COLOR
					</span>
					<ul>
						<li data-style="default" class="color-black current color-default">
						</li>
						<li data-style="blue" class="color-blue">
						</li>
						<li data-style="brown" class="color-brown">
						</li>
						<li data-style="purple" class="color-purple">
						</li>
						<li data-style="grey" class="color-grey">
						</li>
						<li data-style="light" class="color-white color-light">
						</li>
					</ul>
				</div>
				<div class="theme-option">
					<span>
						 Layout
					</span>
					<select class="layout-option form-control input-small">
						<option selected="selected" value="fluid">Fluid</option>
						<option value="boxed">Boxed</option>
					</select>
				</div>
				<div class="theme-option">
					<span>
						 Header
					</span>
					<select class="header-option form-control input-small">
						<option selected="selected" value="fixed">Fixed</option>
						<option value="default">Default</option>
					</select>
				</div>
				<div class="theme-option">
					<span>
						 Sidebar
					</span>
					<select class="sidebar-option form-control input-small">
						<option value="fixed">Fixed</option>
						<option selected="selected" value="default">Default</option>
					</select>
				</div>
				<div class="theme-option">
					<span>
						 Sidebar Position
					</span>
					<select class="sidebar-pos-option form-control input-small">
						<option selected="selected" value="left">Left</option>
						<option value="right">Right</option>
					</select>
				</div>
				<div class="theme-option">
					<span>
						 Footer
					</span>
					<select class="footer-option form-control input-small">
						<option value="fixed">Fixed</option>
						<option selected="selected" value="default">Default</option>
					</select>
				</div>
			</div>
		</div-->
		<!-- END STYLE CUSTOMIZER -->
		<!-- BEGIN PAGE HEADER-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Managed User Groups <!--small>managed data user groups</small-->
				</h3>
				<ul class="page-breadcrumb breadcrumb">
					<!--li class="btn-group">
						<button data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" class="btn blue dropdown-toggle" type="button">
						<span>
							Actions
						</span>
						<i class="fa fa-angle-down"></i>
						</button>
						<ul role="menu" class="dropdown-menu pull-right">
							<li>
								<a href="#">
									Action
								</a>
							</li>
							<li>
								<a href="#">
									User Control 
								</a>
							</li>
							<li>
								<a href="#">
									List Users
								</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="#">
									Separated link
								</a>
							</li>
						</ul>
					</li-->
					<li>
						<i class="fa fa-home"></i>
						<a href="<?=base_url()?>admin/dashboard">
							Home
						</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">
							User Control
						</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="<?=base_url();?>admin/users">
							User Groups
						</a>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet box light-grey">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i>Managed User Groups
						</div>
						<div class="tools">
							<a class="collapse" href="javascript:;">
							</a>
							<a class="config" data-toggle="modal" href="#portlet-config">
							</a>
							<a class="reload" href="javascript:;">
							</a>
							<a class="remove" href="javascript:;">
							</a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="btn-group">
								<!--button class="btn green" id="sample_editable_1_new">
								Add New <i class="fa fa-plus"></i>
								</button-->
								<a class="btn green" id="sample_editable_1_new" href="<?=base_url();?>admin/users/add">
								Add New <i class="fa fa-plus"></i>
								</a>
							</div>
							<!--div class="btn-group pull-right">
								<button data-toggle="dropdown" class="btn dropdown-toggle">Tools <i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="#">
											 Print
										</a>
									</li>
									<li>
										<a href="#">
											 Save as PDF
										</a>
									</li>
									<li>
										<a href="#">
											 Export to Excel
										</a>
									</li>
								</ul>
							</div-->
						</div>
						<div role="grid" class="dataTables_wrapper" id="sample_1_wrapper">
							<!--div class="row">
								<div class="col-md-6 col-sm-12">
									<div id="sample_1_length" class="dataTables_length">
										<label>
											<select name="sample_1_length" size="1" aria-controls="sample_1" class="form-control input-xsmall">
												<option value="5" selected="selected">5</option>
												<option value="15">15</option>
												<option value="20">20</option>
												<option value="-1">All</option>
											</select> records</label>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="dataTables_filter" id="sample_1_filter">
										<label>Search: 
											<input type="text" aria-controls="sample_1" class="form-control input-medium input-inline">
										</label>
									</div>
								</div>
							</div-->
				<!--div class="table-scrollable"-->
				<div class="table">					
					<table id="sample_2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample_1_info">
						<thead>
						<tr role="row"><th class="table-checkbox sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 24px;" aria-label=" ">
						<div class="checker"><span><input type="checkbox" data-set="#sample_2 .checkboxes" class="group-checkable"></span></div>
						</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" style="width: 161px;" aria-label="Name : activate to sort column ascending">
								 Name
							</th>							
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 149px;" aria-label="Admin Access">Admin Access
							</th>
						</tr>
						</thead>							
						<tbody role="alert" aria-live="polite" aria-relevant="all">								
							<?php 
							$i = 1;
							foreach ($rows as $row) { ?>
							<tr class="odd gradeX <?php echo ($i % 2) ? 'even' : 'odd'; ?>">
								<td class=" sorting_1">
									<div class="checker"><span><input type="checkbox" value="1" class="checkboxes"></span></div>
								</td>
								<td class=" "><?php echo $row->name;?></td>
								<td class=" ">
									<span class="label label-sm label-<?php if(!empty($row->admin_access)) { echo 'success'; } else { echo 'warning'; } ?>">											
										<?php if(!empty($row->admin_access)) { echo 'Yes'; } else { echo 'No'; } ?>
									</span>
								</td>
							</tr>
							<?php 
							$i++;
							} ?>
							</tbody></table></div><!--div class="row"><div class="col-md-5 col-sm-12"><div class="dataTables_info" id="sample_1_info">Showing 1 to 5 of 25 entries</div></div><div class="col-md-7 col-sm-12"><div class="dataTables_paginate paging_bootstrap"><ul class="pagination" style="visibility: visible;"><li class="prev disabled"><a title="Prev" href="#"><i class="fa fa-angle-left"></i></a></li><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li><li><a href="#">3</a></li><li><a href="#">4</a></li><li><a href="#">5</a></li><li class="next"><a title="Next" href="#"><i class="fa fa-angle-right"></i></a></li></ul></div></div></div--></div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
</div>