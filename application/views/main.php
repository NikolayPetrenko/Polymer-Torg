<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
		<div id="container">
			<?php $this->load->view('includes/search');?>
			<div id="title">
				<h1>Полимер-торг</h1>
				<div>
					Ежедневно обновляемые предложения по поставке полимеров, оборудования переработки полимеров, полиэтилена, полиэтиленовых труб, запорной арматуры.
					Здесь 1000 потенциальных клиентов каждый день.
				</div>
			</div>
			<?php if(empty($category)) :?>
				<h4>Новые поступления</h4>
			<?php else:?>
				<h4><?php echo $this->Category->getCategoryById($category)->name?>:</h4>
			<?php endif;?>	
			<?php if(!empty($listings)) :?>
				<?php echo $this->pagination->create_links();?>
				<?php foreach($listings as $listing) :?>
					<div class="ad <?php echo $listing->position != 0 ? 'premium' : ''?>">
						<?php if($listing->position != 0) :?>
							<div class="top"><img src="<?php echo base_url()?>images/top.png"/></div>
						<?php endif;?>
						<div class="number">Номер объявления: <?php echo $listing->id?></div>
						<span class="ad_date">Дата добавления: <?php echo date("d-m-Yг H:i", $listing->date)?></span>
						<h3><a href="<?php echo base_url()?>listings/viewListing/<?php echo $listing->alias?>"><?php echo html_escape($listing->name)?></a></h3>
						<?php if(!empty($listing->image_litle)) :?>
							<p><a href="<?php echo base_url()?>listings/viewListing/<?php echo $listing->alias?>"><img src="<?php echo base_url() . 'images/listing/' . $listing->image_litle?>"></a></p>
						<?php endif;?>
							<?php $text_tmp = mb_substr($listing->text, 0, 150, 'UTF-8');?>
						<p><?php echo html_escape($text_tmp);?><?php echo strlen($listing->text) > '150' ? '...' : ''?></p>
						<p><a href="<?php echo base_url()?>listings/viewListing/<?php echo $listing->alias?>">Подробнее</a></p>
					</div>
				<?php endforeach;?>
				<?php echo $this->pagination->create_links();?>
			<?php else:?>
				<p>Нет объявлений</p>
			<?php endif;?>
		</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>