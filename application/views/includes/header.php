<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="google-site-verification" content="osxEGQGLw0Xklvx0yzAAhuyx-NOaOX7en00SG8Utf4E" />
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 		
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="Keywords" content="Пластик, Пластмасса, Пластификатор, Полипропилен, Полистирол, Экструдер, Полиэтилентерефталат, Поливинилхлорид, каталог предприятий, Термопласт, Пресс-форма, переработка пластмасс, ПВД, ПВХ труба, Пенопласт, Каучук, Пенополиуретан, Первичка, ПЕХ, Пленка, ПНД, Поддоны, Полиамид, Поликарбонат, Полимер, Полиуретан, Полиэтилен, Профили, ПЭТ бутылки, Формование, Шланги, Шнек, Экструзия">
		<title>Доска объявлений </title>
		<link type="text/css" href="<?php echo base_url() . 'css/style.css'?>" rel="stylesheet">
		<link type="text/css" href="<?php echo base_url() . 'css/jquery.fancybox.css'?>" rel="stylesheet">
		<script>
			var siteUrl = '<?php echo base_url()?>';
		</script>
		<script type="text/javascript" src="<?php echo base_url() . 'js/jquery.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'js/jquery-ui.min.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'js/jvalidate.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'js/fancybox/jquery.easing.1.3.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'js/fancybox/jquery.fancybox-1.2.1.pack.js'?>"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/vendor/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.iframe-transport.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.fileupload.js"></script>	
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.fileupload-ui.js"></script>	
		<script type="text/javascript" src="<?php echo base_url()?>js/jquery.fileupload-fp.js"></script>	
<!--		<script type="text/javascript" src="<?php // echo base_url() . 'js/bootstrap.min.js'?>"></script>
		<script type="text/javascript" src="<?php // echo base_url() . 'js/bootstrap-modal.js'?>"></script>
		<script type="text/javascript" src="<?php // echo base_url() . 'js/bootstrap-transition.js'?>"></script>-->
		<script type="text/javascript" src="<?php echo base_url() . 'js/common.js'?>"></script>
	</head>
	<body>
		<div id="main_container">
		<div id="header">
			<div id="home"><a href="<?php echo base_url()?>">На главную</a></div>
			<div id="nav">
				<span id="contacts"><a href="<?php echo base_url() . 'main/contacts'?>">Реклама и контакты</a></span>
			<?php if(!UserHelper::loggedIn()) :?>
				<span id="login"><a href="<?php echo base_url() . 'login/index'?>">Вход</a></span>
				<span id="registration"><a href="<?php echo base_url() . 'login/signup'?>">Регистрация</a></span>
				<div id="login_form">
					<?php echo form_open('login/index', array('class' => 'form_login', 'id' => 'login-form-top', 'name' => 'login'));?>
						<div class="control1">
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
						</div>
						<div class="control1">
							<label>Пароль:</label>
							<br />
							<?php 
								$data1 = array( 
									'name' => 'password', 
									'size' => '12' 
								); 
								echo form_password($data1);        
								echo form_error('password', '<div class="error">', '</div>'); 
							?>
						</div>
						<input type="checkbox" name="remember" value="1">Запомнить
						<br />
							<?php echo form_submit('ok', 'Войти');?>
							<br /><br />
							<?php echo anchor('login/signup', 'Регистрация');?>
							<br />
							<span id="login"><a href="<?php echo base_url() . 'login/forgotPassword'?>">Забыли пароль?</a></span>							
					<?php echo form_close();?>
				</div>
			<?php else:?>
				<span id="logout"><a href="<?php echo base_url() . 'login/logout'?>">Выход</a></span>
				<span id="registration"><a href="<?php echo base_url() . 'users/profile'?>">Личный кабинет</a></span>
				<span id="list"><a href="<?php echo base_url()?>listings/addListing">Добавить объявление</a></span>
			<?php endif;?>
			</div>	
		</div>