<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
<div id="container">
	<h1>Добавление объявления</h1>
	<?php echo form_open('listings/addListing', array('class' => 'add_listing', 'id' => 'add-listing', 'name' => 'add_listing'));?>
			<label>Введите название объявления(не более 100 символов):*</label>
			<br /> 
			<?php    
				$data = array( 
					'name' => 'name', 
					'size' => '40', 
					'value' => set_value('name'),
					'id' => 'name'
				); 
				echo form_input($data);    
				echo form_error('name', '<div class="error">', '</div>'); 
			?>
		<br /><br />
		<label>Выберите раздел:*</label>
		<br />
		<?php $options = array(
				'1' => 'Полиэтилен (ПНД, ПВД)',
				'2' => 'Полипропилен',
				'3' => 'Отходы ПП, ПНД, ПВХ',
				'4'	=> 'Прочие полимеры',
				'5' => 'Услуги на рынке полимеров',
				'6' => 'Экструдеры, грануляторы, дробилки',
				'7' => 'Сварочное оборудование для полимеров',
				'8' => 'Прочее оборудование для полимеров'
		);?>
		<?php echo form_dropdown('category', $options, set_value('category'));?>
		<br /><br />
			<label>Текст объявления:*</label>
			<br />
			<?php 
				$data1 = array( 
					'name' => 'text', 
					'id' => 'text',
					'value' => set_value('text')
				); 
				echo form_textarea($data1);        
				echo form_error('text', '<div class="error">', '</div>'); 
			?><br /><br />
				<div class="span4">
					<div id="logo">
						<?php if($this->input->post('image2')) :?>
							<img src="<?php echo base_url()?>images/tmp/<?php echo $this->input->post('image2')?>">
							<input type="hidden" name="image2" value="<?php echo $this->input->post('image2');?>">
							<input type="hidden" name="image1" value="<?php echo $this->input->post('image2');?>">
						<?php endif;?>	
					</div>
					<label class="control-label" for="logo">Фотография(не более 2Mb):</label>
					<br />
					<input id="root" type="file" name="files" multiple>
				</div>			
			<br/>
		<label>Срок действия:*</label>
		<br />
		<?php $options1 = array(
				60*60*24*7	 => '7 дней',
				60*60*24*14	 => '14 дней',
				60*60*24*30	 => '30 дней',
				60*60*24*182 => 'пол года',
				60*60*24*365 => 'год',
		);?>
		<?php echo form_dropdown('time', $options1, set_value('time'));?>
		Выберите срок актуальности вашего предложения.
		<br /><br />
		<h2>Контактные данные</h2>
		<br />
		<label>Телефон/Факс (с кодом):*</label>
		<br /> 
		<?php    
			$data2 = array( 
				'name' => 'tel', 
				'size' => '40', 
				'value' => set_value('tel'),
				'id' => 'tel'
			); 
			echo form_input($data2);    
			echo form_error('tel', '<div class="error">', '</div>'); 
		?>
		<br /><br />		
		<label>Страна/Город:</label>
		<br /> 
		<?php    
			$data2 = array( 
				'name' => 'country', 
				'size' => '40', 
				'value' => set_value('country'),
				'id' => 'country'
			); 
			echo form_input($data2);    
			echo form_error('country', '<div class="error">', '</div>'); 
		?>
		<br /><br />		
		<?php echo form_submit('ok', 'Добавить объявление');?>
		<br />
    <?php echo form_close();?>
</div>	
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>