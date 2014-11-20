<?php if ($this->session->flashdata('flashdata')): ?>
<div class="alert alert-danger">
	<button class="close" data-close="alert"></button>
	<span>		
		<div class="flashdata"><?php echo $this->session->flashdata("flashdata"); ?></div>
	</span>
</div>		
<?php endif; ?>
<?php if ($this->session->flashdata('message')): ?>
<div class="alert alert-danger">
	<button class="close" data-close="alert"></button>
	<span>		
		<div class="message"><?php echo $this->session->flashdata("message"); ?></div>
	</span>
</div>	
<?php endif; ?>
<?php if($this->auth_message): ?>
<div class="alert alert-danger">
	<button class="close" data-close="alert"></button>
	<span>		
		<div class="authmessage"><?php echo $this->auth_message; ?></div>
	</span>
</div>		
<?php endif; ?>