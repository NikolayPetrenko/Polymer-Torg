<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
<div id="container">
	<p>Введите свой email и пароль</p>
	<br /> 
	<?php echo form_open('login/index', array('class' => 'form_login', 'id' => 'login-form', 'name' => 'login'));?>
			<label>Email:</label>
			<br /> 
			<?php    
				$data = array( 
					'name' => 'email', 
					'size' => '12', 
					'value' => set_value('email'),
					'id' => 'email'
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
			?><br />
		<input type="checkbox" name="remember" value="1">Запомнить
		<br />
			<?php echo form_submit('ok', 'Войти');?>
			<br /><br />
			<?php echo anchor('login/signup', 'Регистрация');?>
			<br />
			<span id="login"><a href="<?php echo base_url() . 'login/forgotPassword'?>">Забыли пароль?</a></span>
    <?php echo form_close();?>
</div>	
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>