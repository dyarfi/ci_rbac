<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Add User Group<!--small>managed data users</small-->
				</h3>
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="<?=base_url(ADMIN.'dashboard/index');?>">
							Dashboard
						</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">User Group Control</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="<?=base_url();?>admin/user/add">
							User Group Add
						</a>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>	
		<!-- BEGIN FORM-->
		<form class="form-horizontal usergroup-form-add" action="<?=base_url();?>admin/usergroup/<?=($action) ? $action .'/'. $param :'';?>" method="POST" id="usergroup-form-add">
			<div class="form-body">
				<h3 class="form-section">Group Info</h3>
				<!--/row-->
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">Group Name</label>
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" class="form-control" name="name" placeholder="Group Name" value="<?=$fields->name;?>" id="name">
								</div>
								<span class="help-block"><?php echo $errors['name'];?></span>
							</div>
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">Backend Access</label>
							<div class="col-md-6">								
								<div class="checkbox-list">
									<label><input value="1" <?php echo ($fields->backend_access == 1 ? 'checked' :'');?> class="form-control" name="backend_access" type="checkbox">&nbsp;</label>
								</div>								
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Full Backend Access</label>
							<div class="col-md-6">								
								<div class="checkbox-list">
									<label><input value="1" <?php echo ($fields->full_backend_access == 1 ? 'checked' :'');?> class="form-control" name="full_backend_access" type="checkbox">&nbsp;</label>
								</div>								
							</div>
						</div>
					</div>
				</div>				
				<!--/row-->
				<div class="row">
					<!--/span-->
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">Status</label>
							<div class="col-md-6">
								<select class="form-control" name="status">
									<?php foreach ($statuses as $status => $val) {?>
										<option value="<?php echo $val;?>" <?php echo ($val == $fields->status) ? 'selected' : '';?>><?php echo $status;?></option>
									<?php } ?>
								</select>								
								<span class="help-block"><?php echo $errors['status'];?></span>
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-8">
						<div class="col-md-offset-3 col-md-8">
							<button class="btn green" type="submit">Submit</button>
							<button class="btn default" type="button">Cancel</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="msg"></div>
					</div>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>	