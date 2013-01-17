<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
<div id="container">
	<div id="registration_form">
		<?php $attributes = array('class' => 'form-signup', 'id' => 'signup');?>
		<p>Пожалуйста, введите имя на сайте, email, пароль.</p>
		<p>Имя на сайте должно быть не менее 4 и не более 12 символов.</p> 
		<p>Пароль не должен быть короче 6 символов.</p>
		<br><br>
		<?php echo form_open('login/signup', $attributes);?>
			<label>Имя на сайте:</label>
			<br />
			<?php 
				$data = array( 
				'name' => 'name', 
				'size' => '12', 
				'value' => set_value('name'),
				); 
				echo form_input($data);            
				echo form_error('name', '<div class="error">', '</div>'); 
			?>
			<br /><br />
			<label>Email:</label>
			<br />
			<?php 
				$data = array( 
				'name' => 'email', 
				'size' => '12', 
				'value' => set_value('email'),
				); 
				echo form_input($data);            
				echo form_error('email', '<div class="error">', '</div>'); 
			?>

			<br /><br />
			<label>Пароль:</label>
			<br />
			<?php 
				$data1 = array( 
				'name' => 'password', 
				'size' => '12',
				'id' => 'password'
				); 
				echo form_password($data1);        
				echo form_error('password', '<div class="error">', '</div>'); 
			?>
			<br /><br />
			<label>Повторите пароль:</label>
			<br />
			<?php 
				$data2 = array( 
				'name' => 'passconf', 
				'size' => '12', 
				); 
				echo form_password($data2);        
				echo form_error('passconf', '<div class="error">', '</div>'); 
			?>
			<br /><br />
			<label>ФИО:</label>
			<br />
			<?php 
				$data3 = array( 
				'name' => 'fio', 
				'size' => '12',
				'value' => set_value('fio'),         
				); 
				echo form_input($data3);        
				echo form_error('fio', '<div class="error">', '</div>'); 
			?>
			<br /><br />
			<label>Контактный телефон:</label>
			<br />
			<?php 
				$data4 = array( 
				'name' => 'tel', 
				'size' => '12',
				'value' => set_value('tel'),         
				); 
				echo form_input($data4);        
				echo form_error('tel', '<div class="error">', '</div>'); 
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
			<?php echo form_submit('ok', 'Регистрация');?>
		<?php echo form_close();?>
	</div>	
</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>