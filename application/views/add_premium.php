<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
<div id="container">
	<h1>Добавление объявления в ТОП</h1>
	<?php echo form_open('listings/addPremiumListing', array('class' => 'add_premium', 'id' => 'add-premium', 'name' => 'add_premium'));?>
			<p>Введите номер объявления, чтобы добавить его в ТОП</p>
			<br />
			<label>Номер объявления:</label>
			<br /> 
			<?php    
				$data = array( 
					'name' => 'number', 
					'size' => '15', 
					'value' => set_value('number'),
					'id' => 'number'
				); 
				echo form_input($data);    
				echo form_error('number', '<div class="error">', '</div>'); 
			?>
		<br /><br />	
		<label>Срок действия в топе:*</label>
		<br />
		<?php $options1 = array(
				60*60*24*7	 => '7 дней',
				60*60*24*14	 => '14 дней',
				60*60*24*30	 => '30 дней',
				60*60*24*182 => 'пол года',
				60*60*24*365 => 'год',
		);?>
		<?php echo form_dropdown('time', $options1, set_value('time'));?>
		Выберите срок в течении которого объявление будет находиться в ТОПе.
		<br /><br />
		<?php echo form_submit('ok', 'Добавить объявление в ТОП');?>
		<br />
    <?php echo form_close();?>
</div>	
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>