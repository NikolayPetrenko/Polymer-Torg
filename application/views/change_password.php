<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
		<div id="container">
			<div id="title">
				<h1>Сменить пароль</h1>
			</div>
			<div>
				<?php $attributes = array('class' => 'form-change', 'id' => 'change');?>
				<?php echo form_open('users/changePassword', $attributes);?>
					<label>Старый пароль:</label>
					<br />
					<?php 
						$data1 = array( 
						'name' => 'old_password', 
						'size' => '12',
						'id' => 'old_password'
						); 
						echo form_password($data1);        
						echo form_error('old_password', '<div class="error">', '</div>'); 
					?>
					<br /><br />				
					<label>Новый пароль:</label>
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
					<label>Повторите новый пароль:</label>
					<br />
					<?php 
						$data2 = array( 
						'name' => 'passconf', 
						'size' => '12', 
						); 
						echo form_password($data2);        
						echo form_error('passconf', '<div class="error">', '</div>'); 
					?>
					<br/>
					<?php echo form_submit('ok', 'Сменить пароль');?>
				<?php echo form_close();?>
			</div>
		</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>