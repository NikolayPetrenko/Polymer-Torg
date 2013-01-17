<?php $this->load->view('includes/header');?>
<?php $this->load->view('includes/baners');?>
<?php $this->load->view('includes/menu-left');?>
		<div id="container">
			<div id="title">
				<h1>Пользователи</h1>
			</div>
			<?php if(!empty($users)) :?>
				<div class="ad">
					<table cellspacing="2" border="1" cellpadding="5" >
						<thead>
							<tr>
								<th>Имя</th>
								<th>Email</th>
								<th>ФИО</th>
								<th>Роль</th>
								<th>Статус</th>
								<th>Опции</th>
							</tr>
						</thead>
					<tbody>
					<?php foreach($users as $user) :?>
						<tr>
							<td><?php echo $user->name?></td>
							<td><?php echo $user->email?></td>
							<td><?php echo $user->fio?></td>
							<td><?php echo $user->role == '1' ? 'Админ' : 'Пользователь';?></td>
							<td><?php echo $user->status == '1' ? 'Активный' : 'Неактивный';?></td>
							<td>
								<?php if($user->role == '1') :?>
									<a href="#" class="noadmin" rel="user_<?php echo $user->id?>">Снять</a>
								<?php else :?>
									<a href="#" class="admin" rel="user_<?php echo $user->id?>">Назначить</a>
								<?php endif;?>
								- 
								<?php if($user->status == '1') :?>
									<a href="#" class="inactive_user" rel="user_<?php echo $user->id?>">Деактивировать</a>
								<?php else :?>
									<a href="#" class="active_user" rel="user_<?php echo $user->id?>">Активировать</a>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
		   		    </table>	
				</div>
				<?php echo $this->pagination->create_links();?>
			<?php else:?>
				<p>Нет пользователей</p>
			<?php endif;?>
		</div>
<?php $this->load->view('includes/menu-right');?>
<?php $this->load->view('includes/footer');?>