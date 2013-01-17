<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
<div id="container">
	<div id="registration_form">
		<?php $attributes = array('class' => 'form-forgot', 'id' => 'forgot');?>
		<p>Пожалуйста, введите свой email.</p>
		<p>Вам на почту будет выслан новый пароль.</p> 
		<br><br>
		<?php echo form_open('login/forgotPassword', $attributes);?>
			<label>Email:</label>
			<br />
			<?php 
				$data = array( 
					'name' => 'email', 
					'size' => '12', 
					'value' => set_value('email')
				); 
				echo form_input($data);            
				echo form_error('email', '<div class="error">', '</div>'); 
			?>
			<br /><br />
			<span id="capcha_image"><?php echo $captcha?></span><a href="" id="refresh"><img id="ref" src="<?php echo base_url() . 'images/refresh.png'?>"></a>
			<br />
			<label>Введите код с картинки:</label>
			<br />
			<?php 
				$data1 = array( 
				'name' => 'captcha', 
				'size' => '6', 
				); 
				echo form_input($data1);
				echo form_error('captcha', '<div class="error">', '</div>'); 
			?>
			<br />
			<?php echo form_submit('ok', 'Напомнить');?>
		<?php echo form_close();?>
	</div>	
</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>