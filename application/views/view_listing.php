<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
		<div id="container">
				<div class="ad">
					<h3><?php echo html_escape($listing->name)?></h3>
					<span class="ad_date">Дата добавления: <?php echo date("d-m-Yг H:i", $listing->date)?></span>
					<h3>Добавил: <?php echo !empty($user->fio) ? $user->fio : $user->name?></h3>
					<h3>Категория: <?php echo $category?></h3>
					<?php if(!empty($listing->image_litle)) :?>
						<p><a class="iframe" href="#image"><img src="<?php echo base_url() . 'images/listing/' . $listing->image_litle?>"></a></p>
						<p style="color:blue"><a class="iframe" href="#image">(нажмите для увеличения)</a></p>
						<br />
					<?php endif;?>
					<p class="big-text"><?php echo html_escape($listing->text);?></p>
					<h3>Телефон: <?php echo $listing->tel?></h3>
					<?php if(!empty($listing->country)) :?>
						<h3>Страна/Город: <?php echo $listing->country?></h3>
					<?php endif;?>
				</div>
				<div style="display:none" id="image">
					<img src="<?php echo base_url() . 'images/listing/' . $listing->image?>">
				</div>
		</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>