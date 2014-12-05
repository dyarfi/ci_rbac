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
					<li class="btn-group">
						<button data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" class="btn blue dropdown-toggle" type="button">
						<span>
							Modules
						</span>
						<i class="fa fa-angle-down"></i>
						</button>
						<ul role="menu" class="dropdown-menu pull-right">
							<li>
								<a href="<?=base_url(ADMIN.'modulelist/index');?>">
									User Group Modules
								</a>
							</li>
						</ul>
					</li>
					<li>
						<i class="fa fa-home"></i>
						<a href="<?=base_url(ADMIN.'dashboard/index')?>">
							Dashboard
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
						<a href="<?=base_url(ADMIN.'usergroup/index');?>">
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
								<a class="btn green" id="sample_editable_1_new" href="<?=base_url(ADMIN.'usergroup/add');?>">
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
						<!--div class="table-scrollable"-->
							<div class="table">					
								<table id="sample_2" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample_1_info">
									<thead>
									<tr role="row"><th class="table-checkbox sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 24px;" aria-label=" ">
									<input type="checkbox" data-set="#sample_2 .checkboxes" class="group-checkable">
									</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" style="width: 161px;" aria-label="Name : activate to sort column ascending">
											 Name
										</th>							
										<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 149px;" aria-label="Admin Access">Admin Access
										</th>
																	
										<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 149px;" aria-label="Admin Access">Manage
										</th>
									</tr>
									</thead>							
									<tbody role="alert" aria-live="polite" aria-relevant="all">								
									<?php 
									$i = 1;
									foreach ($rows as $row) { ?>
									<tr class="odd gradeX <?php echo ($i % 2) ? 'even' : 'odd'; ?>">
										<td class=" sorting_1">
											<input type="checkbox" value="1" class="checkboxes">
										</td>
										<td class="col-md-4"><?php echo $row->name;?></td>
										<td class="col-md-4">
											<span class="label label-sm label-<?php if($row->backend_access) { echo 'success'; } else { echo 'warning'; } ?>">											
												<?php if($row->backend_access) { echo 'Yes'; } else { echo 'No'; } ?>
											</span>
										</td>
										<td class="col-md-4">
											<ul class="list-inline">
												<li>
													<a title="View" href="<?=base_url(ADMIN.'usergroup/view/'.$row->id);?>" class="btn default btn-xs blue"><i class="fa fa-check"></i>View
													</a>
												</li>
												<li>
													<a title="Edit" href="<?=base_url(ADMIN.'usergroup/edit/'.$row->id);?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i>Edit
													</a>
												</li>
												<li>
													<a title="Delete" href="<?=base_url(ADMIN.'usergroup/delete/'.$row->id);?>" class="btn default btn-xs red"><i class="fa fa-trash-o"></i>Delete
													</a>
												</li>
											</ul>
										</td>
									</tr>
									<?php 
									$i++;
									} ?>
									</tbody>									
								</table>	
								<!--div class="row">
									<div id="selection">
										<div class="col-lg-12 col-md-12">
											<label>Status : 
												<select name="select_action" id="select_action" class="form-control-inline">
													<option value="">&nbsp;</option>
													<?php foreach ($statuses as $row) : ?>
														<option value="<?php echo $row; ?>"><?php echo ucfirst($row); ?></option>
													<?php endforeach; ?>
												</select>
											</label>	
										</div>
									</div>
								</div-->
							</div>
						</div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
</div>