<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Zahar Pecherin
 */
class Listings extends CI_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('User', 'Listing', 'Category'));
		$this->load->library('email');
		$this->load->library('form_validation');
	}

	public function viewListing($alias)
	{
		$data['listing'] = $this->Listing->getListingByAlias($alias);
		$data['user'] = $this->User->getUserById($data['listing']->user);
		if(empty($data['listing'])) redirect(404);
		$data['category'] = $this->Category->getCategoryById($data['listing']->category)->name;
		$this->load->view('view_listing', $data);
	}
	
	public function editListing($id)
	{
		if(!UserHelper::loggedIn()) redirect(404);
		if(UserHelper::logedUserInfo()->role != '1') {
			if(!$this->Listing->isMyListing($id)) redirect(404);
		}
		$this->form_validation	->set_rules('name', 'Название объявления', 'trim|required|max_length[100]|xss_clean')
								->set_rules('text', 'Текст сообщения', 'trim|required|xss_clean')
								->set_rules('tel', 'Телефон', 'trim|required|xss_clean')
								->set_rules('category', 'Категория', 'trim')
								->set_rules('country', 'Страна', 'trim')
								->set_message('max_length', '%s не должно быть не более %s символов')
								->set_message('required', 'Поле не должно быть пустым')
								;
		if ($this->form_validation->run() == FALSE) {
			if(UserHelper::logedUserInfo()->role != '1') {
				$data['listing'] = $this->Listing->addFilterByUser()->getListingById($id);
			} else {
				$data['listing'] = $this->Listing->getListingById($id);
			}
			$this->load->view('edit_listing', $data);
		} else {
			if(UserHelper::logedUserInfo()->role != '1') {
				if(!$this->Listing->isMyListing($id)) redirect(404);
			}
			$name = $this->input->post('name');
			if($this->input->post('image1')) {
				//moving poster from the temporary folder
				@rename('images/tmp/' . $this->input->post('image1'), 'images/listing/' . $this->input->post('image1'));
			}
			if($this->input->post('image2')) {
				//moving poster from the temporary folder
				@rename('images/tmp/' . $this->input->post('image2'), 'images/listing/' . $this->input->post('image2'));
			}			
			$this->Listing->updateListing(
							$id,
							$name, 
							$this->input->post('text'), 
							$this->input->post('category'),
							$this->input->post('tel'),
							$this->input->post('country'),
							$this->input->post('image1'),
							$this->input->post('image2')
					);
			$message = 'Ваше объявление №' . $id . ' было успешно отредактировано.';
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <admin@polymer-torg.com>\r\n";
			mail(	UserHelper::logedUserInfo()->email, 
					"Редактирование объявления на polymer-torg.com", 
					$message,
					$headers
			);				
			if(UserHelper::logedUserInfo()->role != '1') {
				redirect('/listings/myListings', 'location');
			} else {
				redirect('/listings/allListings', 'location');
			}
		}
	}
	
	public function addPremiumListing()
	{
		if(!UserHelper::loggedIn() || UserHelper::logedUserInfo()->role != '1') redirect(404);
		$this->form_validation	->set_rules('number', 'Номер', 'trim|required|callback__list_check|xss_clean')
								->set_rules('time', 'Время размещения', 'trim')
								->set_message('required', 'Введите номер объявления')
								;
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_premium');
		} else {
			$this->Listing->addPremium(
							$this->input->post('number'),
							$this->input->post('time')
					);
			$listing = $this->Listing->getListingById($this->input->post('number'));
			$user = $this->User->getUserById($listing->user);
			$message = 'Ваше объявление №' . $this->input->post('number') . ' было успешно добавлено в ТОП.';
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <admin@polymer-torg.com>\r\n";
			mail(	$user->email, 
					"Добавление объявления на polymer-torg.com в ТОП", 
					$message,
					$headers
			);				
			redirect('/main', 'location');
		}
	}
	
	public function addListing()
	{
		if(!UserHelper::loggedIn()) redirect(404);
		$this->form_validation	->set_rules('name', 'Название объявления', 'trim|required|max_length[100]|xss_clean')
								->set_rules('text', 'Текст сообщения', 'trim|required|xss_clean')
								->set_rules('time', 'Время размещения', 'trim')
								->set_rules('tel', 'Телефон', 'trim|required|xss_clean')
								->set_rules('category', 'Категория', 'trim')
								->set_rules('country', 'Страна', 'trim')
								->set_message('max_length', '%s не должно быть не более %s символов')
								->set_message('required', 'Поле не должно быть пустым')
								;		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('add_listing');
		} else {
			$name = $this->input->post('name');
			if($this->input->post('image1')) {
				//moving poster from the temporary folder
				@rename('images/tmp/' . $this->input->post('image1'), 'images/listing/' . $this->input->post('image1'));
			}
			if($this->input->post('image2')) {
				//moving poster from the temporary folder
				@rename('images/tmp/' . $this->input->post('image2'), 'images/listing/' . $this->input->post('image2'));
			}			
			$this->Listing->addListing(
							$name, 
							$this->input->post('text'), 
							$this->input->post('time'),
							$this->input->post('category'),
							$this->input->post('tel'),
							$this->input->post('country'),
							$this->input->post('image1'),
							$this->input->post('image2')
					);
			$id = $this->db->insert_id();
			$alias = friendlyAlias($name) . '-' . $id;
			$this->Listing->updateAlias($id, $alias);
			$message = 'Ваше объявление №' . $id . ' было успешно добавлено на сайт.';
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <admin@polymer-torg.com>\r\n";
			mail(	UserHelper::logedUserInfo()->email, 
					"Добавление объявления на polymer-torg.com", 
					$message,
					$headers
			);			
			redirect('/main', 'location');
		}
	}
	
	public function upload()
	{
        $this->load->helper(array('html', 'image'));
        $this->load->library(array('Default_Lib_Image'));		
		//creating headers
		header('Vary: Accept');
		if (isset($_SERVER['HTTP_ACCEPT']) &&
			(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
		//save and resize image
		if($_FILES['files']['error'] == 1) {
			echo json_encode(
					array(
							'error' => 1
					)
			);
		} else {
			$image  = new ImageHelper();
			$res1    = $image->save($_FILES, 'file', array('resolution' => '800x600', 'fileSize' => '40000000'));
			if(empty($res1)) {
				echo json_encode(
						array(
								'error' => 1
						)
				);
				die;
			}
			$res2    = $image->save($_FILES, 'file', array('resolution' => '100x100', 'fileSize' => '40000000'));
			echo json_encode(
					array(
							'name1' => $res1[0],
							'name2' => $res2[0],
							'url2' => base_url() . 'images/tmp/'.$res2[0],
							'error' => 0
					)
			);			
		}
	}
	
	public function myListings()
	{
		$limit = 5;
		if(!UserHelper::loggedIn()) redirect(404);
		$this->load->model(array('Listing', 'Category'));
		$this->load->library('pagination');		
		$offset = $this->uri->segment(4, 0);
		$config['uri_segment']	= 4;
		$config['base_url']		= base_url() . 'listings/myListings/page/';
		$config['total_rows']	= $this->Listing->addFilterByUser()->countItemUser()->count;
		$data['listings']		= $this->Listing->addFilterByUser()->getListings($limit, $offset);
		$config['per_page']		= $limit; 
		$this->pagination->initialize($config);
		$this->load->view('my_listings', $data);
	}
	
	public function allListings()
	{
		$limit = 5;
		if(!UserHelper::loggedIn() || UserHelper::logedUserInfo()->role != '1') redirect(404);
		$this->load->model(array('Listing', 'Category'));
		$this->load->library('pagination');		
		$offset = $this->uri->segment(4, 0);
		$config['uri_segment']	= 4;
		$config['base_url']		= base_url() . 'listings/allListings/page/';
		$config['total_rows']	= $this->Listing->countItemUser()->count;
		$data['listings']		= $this->Listing->getListings($limit, $offset);
		$config['per_page']		= $limit;
		$this->pagination->initialize($config); 		
		$this->load->view('all_listings', $data);
	}
	
	public function ajaxChangeStatus()
	{
		if(!$this->input->post()) return false;
		$id = $this->input->post('id');
		$listing = $this->Listing->getListingById($id);
		$email = $this->User->getUserById($listing->user)->email;
		if($this->input->post('status') == '0') {
			$this->Listing->updateStatus($id, '0');
			$message = 'Ваше объявление ' . $listing->name . ' было успешно деактивировано.';
		} else {
			$this->Listing->updateStatus($id, '1');
			$message = 'Ваше объявление ' . $listing->name . ' было успешно активировано.';
		}
		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: <admin@polymer-torg.com>\r\n";
		mail(	$email, 
				"Изменение статуса объявления на polymer-torg.com", 
				$message,
				$headers
		);		
		$result = new JsonResponse();
		$result->html = 'Listing seccess changed';
		echo $result;
	}
	
	function _list_check($str)
	{
		if ($this->Listing->getListingExist($str)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_list_check', 'Объявление не найдено в базе данных.');			   
			return FALSE;
		}
	}	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */