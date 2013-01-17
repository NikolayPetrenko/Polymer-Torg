<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
		<div id="container">
			
			<div id="title">
				<h1>Мои данные</h1>
			</div>
			<?php echo !empty($message) ? '<h2>' . $message . '</h2>' : ''?>
			<div>
				<?php $attributes = array('class' => 'form-profile', 'id' => 'profile');?>
				<?php echo form_open('users/profile', $attributes);?>
					<p>Имя на сайте: <input id="nick_name" type="text" name="name" value="<?php echo set_value('name', $user->name)?>"></p>
					<?php echo form_error('name', '<div class="error">', '</div>'); ?>
					<br/>
					<p>Email: <input id="user_email" type="text" name="email" value="<?php echo set_value('email', $user->email)?>"></p>
					<?php echo form_error('email', '<div class="error">', '</div>'); ?>
					<br/>
					<p>ФИО: <input id="user_name" type="text" name="fio" value="<?php echo set_value('fio', $user->fio)?>"></p>
					<?php echo form_error('fio', '<div class="error">', '</div>'); ?>
					<br/>
					<p>Контактный телефон: <input id="user_phone" type="text" name="tel" value="<?php echo set_value('tel', $user->tel)?>"></p>
					<?php echo form_error('tel', '<div class="error">', '</div>'); ?>
					<br/>
					<?php echo form_submit('ok', 'Изменить данные');?>
				<?php echo form_close();?>
					<a href="<?php base_url()?>changePassword">Сменить пароль</a>
			</div>
		</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>