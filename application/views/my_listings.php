<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
		<div id="container">
			<div id="title">
				<h1>Мои объявления</h1>
			</div>
			<?php if(!empty($listings)) :?>
				<div class="ad">
					<table cellspacing="2" border="1" cellpadding="5" >
						<thead>
							<tr>
								<th>Название</th>
								<th>Текст</th>
								<th>Номер</th>
								<th class="listing_date">Дата</th>
								<th>Опции</th>
							</tr>
						</thead>
					<tbody>
					<?php foreach($listings as $listing) :?>
						<tr>
							<td><?php echo $listing->name?></td>
							<?php ?>
							<?php $text_tmp = mb_substr($listing->text, 0, 150, 'UTF-8');?>
							<td><?php echo html_escape($text_tmp);?><?php echo strlen($listing->text) > '150' ? '...' : ''?></td>
							<td><?php echo $listing->id?></td>
							<td><?php echo date("d-m-Yг H:i", $listing->date)?></td>
							<td>
								<a href="<?php echo base_url()?>listings/editListing/<?php echo $listing->id?>">Редактировать</a> - <br>
								<?php if($listing->status == '1') :?>
									<a href="#" class="inactive-status" rel="listing_<?php echo $listing->id?>">Деактивировать</a>
								<?php else :?>
									<a href="#" class="active-status" rel="listing_<?php echo $listing->id?>">Активировать</a>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
		   		    </table>	
				</div>
				<?php echo $this->pagination->create_links();?>
			<?php else:?>
				<p>Нет объявлений</p>
			<?php endif;?>
		</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>