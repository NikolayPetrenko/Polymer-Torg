<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
<div id="container">
	<div class="success big">
		<?php echo !empty($success) ? $success : ''?>
	</div>
	<div class="error big">
		<?php echo !empty($error) ? $error : ''?>
	</div>
	<p><?php echo !empty($link) ? $link : ''?></p>
</div>	
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>