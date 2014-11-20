<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Add User <!--small>managed data users</small-->
				</h3>
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="<?=base_url();?>admin/dashboard">
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
						<a href="<?=base_url();?>admin/user/add">
							User Add
						</a>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>	
		<!-- BEGIN FORM-->
		<form class="form-horizontal" action="#" id="user-form-add" class="user-form-add">
			<div class="form-body">
				<h3 class="form-section">User Info</h3>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Username </label>
							<div class="col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" class="form-control" name="username" placeholder="Username" value="" id="username">
								</div>
								<span class="help-block hidden"></span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Email</label>
							<div class="col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-envelope"></i>
									</span>
									<input type="email" class="form-control" name="email" placeholder="Email" value="" id="email">
								</div>
								<span class="help-block hidden"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password" value="" id="password">
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">							
						<div class="form-group">
							<label class="control-label col-md-3">Group</label>
							<div class="col-md-9">
								<select class="form-control" name="group_id">
									<?php foreach($user_groups as $group) {;?>
										<option value="<?php echo $group->id;?>"><?php echo $group->name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Retype Password</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="password_retype" value="" id="password_retype">
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Status</label>
							<div class="col-md-9">
								<select class="form-control">
									<option>Active</option>
									<option>Inactive</option>
								</select>
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<h3 class="form-section">User Profile</h3>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">First Name</label>
							<div class="col-md-9">
								<input type="text" placeholder="First Name" name="first_name" class="form-control">
								<span class="help-block hidden"></span>
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<!--div class="form-group has-error">
							<label class="control-label col-md-3">Last Name</label>
							<div class="col-md-9">
								<div class="select2-container select2me form-control" id="s2id_autogen1"><a tabindex="-1" class="select2-choice" onclick="return false;" href="javascript:void(0)">   <span class="select2-chosen">Abc</span><abbr class="select2-search-choice-close"></abbr>   <span class="select2-arrow"><b></b></span></a><input type="text" class="select2-focusser select2-offscreen" id="s2id_autogen2"><div class="select2-drop select2-display-none select2-with-searchbox">   <div class="select2-search">       <input type="text" class="select2-input" spellcheck="false" autocapitalize="off" autocorrect="off" autocomplete="off">   </div>   <ul class="select2-results">   </ul></div></div><select class="select2me form-control select2-offscreen" name="foo" tabindex="-1">
									<option value="1">Abc</option>
									<option value="1">Abc</option>
									<option value="1">This is a really long value that breaks the fluid design for a select2</option>
								</select>
								<span class="help-block">
									 This field has error.
								</span>
							</div>
						</div-->
						<div class="form-group">
							<label class="control-label col-md-3">Last Name</label>
							<div class="col-md-9">
								<input type="text" placeholder="Last Name" name="last_name" class="form-control">
								<span class="help-block hidden"></span>
								
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Gender</label>
							<div class="col-md-9">
								<select class="form-control">
									<option value="">Male</option>
									<option value="">Female</option>
								</select>
								<span class="help-block">
									 Select your gender.
								</span>
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Date of Birth</label>
							<div class="col-md-9">
								<div class="input-group input-medium date date-picker" data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
									<input class="form-control" type="text" readonly="">
									<span class="input-group-btn">
									<button class="btn default" type="button">
									<i class="fa fa-calendar"></i>
									</button>
									</span>
									</div>
									<span class="help-block"> Select date </span>

							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Phone</label>
							<div class="col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-phone"></i>
									</span>
									<input class="form-control" type="text" value="" placeholder="Phone" name="phone">
								</div>
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Mobile</label>
							<div class="col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-mobile"></i>
									</span>
									<input class="form-control" type="text" value="" placeholder="Mobile" name="mobile_phone">
								</div>
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">Division</label>
							<div class="col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-book"></i>
									</span>
									<input class="form-control" type="text" value="" placeholder="Division" name="division">
								</div>
							</div>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-md-3">About</label>
							<div class="col-md-9">
								<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-road"></i>
									</span>
									<input class="form-control" type="text" value="" placeholder="About" name="about">
								</div>
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
			</div>
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-offset-3 col-md-9">
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