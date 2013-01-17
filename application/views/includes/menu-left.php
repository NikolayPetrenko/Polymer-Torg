		<div id="left">
			<?php if(UserHelper::loggedIn()) :?>
				<div class="dashboard-menu">
					<h5>Здравствуйте, <?php echo UserHelper::logedUserInfo()->name?>!</h5>
					<ul>
						<li><a href="<?php echo base_url()?>listings/addListing">Добавить объявление</a></li>
						<li><a href="<?php echo base_url()?>users/profile">Мои данные</a></li>
						<li><a href="<?php echo base_url()?>listings/myListings">Мои объявления</a></li>
					</ul>
					<?php if(UserHelper::logedUserInfo()->role == '1') :?>
						<h5>Админ панель</h5>
						<ul class="admin-panel">
							<li><a href="<?php echo base_url()?>users/allUsers">Пользователи</a></li>
							<li><a href="<?php echo base_url()?>listings/allListings">Все объявления</a></li>
							<li><a href="<?php echo base_url()?>listings/addPremiumListing">Добавить в ТОП</a></li>
						</ul>
					<?php endif;?>
				</div>
			<?php endif;?>
			<h2>МАТЕРИАЛЫ и СЫРЬЕ ДЛЯ ПРОИЗВОДСТВА</h2>
				<ul>
                    <li><a href="<?php echo base_url()?>main/index/1">Полиэтилен (ПНД, ПВД)</a></li>
                    <li><a href="<?php echo base_url()?>main/index/2">Полипропилен</a></li>
                    <li><a href="<?php echo base_url()?>main/index/3">Отходы ПП, ПНД, ПВХ</a></li>
                    <li><a href="<?php echo base_url()?>main/index/4">Прочие полимеры</a></li>
                    <li><a href="<?php echo base_url()?>main/index/5">Услуги на рынке полимеров</a></li>
               </ul>
			<h2>ОБОРУДОВАНИЕ ДЛЯ ПОЛИМЕРОВ</h2>
				<ul>
                    <li><a href="<?php echo base_url()?>main/index/6">Экструдеры, грануляторы, дробилки</a></li>
                    <li><a href="<?php echo base_url()?>main/index/7">Сварочное оборудование для полимеров</a></li>
                    <li><a href="<?php echo base_url()?>main/index/8">Прочее оборудование для полимеров</a></li>
                </ul>		
		</div>