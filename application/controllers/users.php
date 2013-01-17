<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Zahar Pecherin
 */
class Users extends CI_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('User');
		$this->load->library('email');
		$this->load->library('form_validation');
	}	

	public function changePassword()
	{
		if(!UserHelper::loggedIn()) redirect(404);
		$user = $this->User->getUserById(UserHelper::logedUserInfo()->id);
		$this->form_validation	->set_rules('old_password', 'Старый пароль', 'trim|required|callback__user_check')
								->set_rules('password', 'Новый пароль', 'trim|required|min_length[6]|matches[passconf]')
								->set_rules('passconf', 'Повторите пароль', 'trim|required')
								->set_message('min_length', 'Пароль не может быть короче 6-ти символов')
								->set_message('required', 'Поле не должно быть пустым')
								->set_message('matches', 'Пароли не совпадают')
								;
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('change_password');
		} else {
			$this->User->updatePassword(
						$user->id,
						$this->input->post('password')
					);
			redirect(site_url('users/profile'));
		}	
	}
	
	public function profile()
	{
		if(!UserHelper::loggedIn()) redirect(404);
		$user = $this->User->getUserById(UserHelper::logedUserInfo()->id);
		$this->form_validation	->set_rules('name', 'имя', 'trim|required|min_length[4]|max_length[12]|callback__is_unique_name[' . $user->id . ']|xss_clean')
								->set_rules('email', 'email', 'trim|required|valid_email|callback__is_unique_email[' . $user->id . ']|xss_clean')
								->set_rules('fio', 'Фамилия Имя Отчество', 'xss_clean')
								->set_rules('tel', 'Телефон', 'xss_clean')
								->set_message('required', 'Поле не должно быть пустым')
								->set_message('valid_email', 'Введите корректный емайл')
								->set_message('min_length', '%s не должно быть не менее %s символов')
								->set_message('max_length', '%s не должно быть не более %s символов')
								;
		if ($this->form_validation->run() == FALSE) {
			$data['user'] = $user;
			$this->load->view('profile', $data);
		} else {
			$this->User->updateProfile(
						$user->id,
						$this->input->post('name'),
						$this->input->post('email'),
						$this->input->post('fio'),
						$this->input->post('tel')
					);
			$data['user'] = $user;
			$data['message'] = 'Данные успешно изменены';
			$this->load->view('profile', $data);
		}	
	}

	function _is_unique_name($str, $id)
	{
		if (!$this->User->UniqueName($str, $id)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_is_unique_name', 'Такое имя уже зарегистрировано в системе');
			return FALSE;
		}
	}

	function _is_unique_email($str, $id)
	{
		if (!$this->User->UniqueEmail($str, $id)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_is_unique_email', 'Такой email уже зарегистрирован в системе');
			return FALSE;
		}
	}
	
	function _user_check($str)
	{
		if ($this->User->getUserExist(UserHelper::logedUserInfo()->email, md5(trim($str)))) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_user_check', 'Неправильный пароль! Проверте правильность введенных данных.');			   
			return FALSE;
		}
	}
	
	public function allUsers()
	{
		$limit = 5;
		if(!UserHelper::loggedIn() || UserHelper::logedUserInfo()->role != '1') redirect(404);
		$this->load->library('pagination');
		$offset = $this->uri->segment(4, 0);
		$config['uri_segment']	= 4;
		$config['base_url']		= base_url() . 'users/allUsers/page/';
		$config['total_rows']	= $this->User->countUsers()->count;
		$data['users']		= $this->User->getAllUsers($limit, $offset);
		$config['per_page']		= $limit;
		$this->pagination->initialize($config);
		$this->load->view('all_users', $data);
	}
	
	public function ajaxChangeStatus()
	{
		if(!$this->input->post()) return false;
		$id = $this->input->post('id');
		$user = $this->User->getUserById($id);
		if($this->input->post('status') == '0') {
			$this->User->updateStatus($id, '0');
			$message = 'Уважаемый ' . $user->name . ', Ваш аккаунт был удален с сайта polymer-torg.com';
		} else {
			$this->User->updateStatus($id, '1');
			$message = 'Уважаемый ' . $user->name . ', Ваш аккаунт был активирован на сайте polymer-torg.com';
		}
		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: <admin@polymer-torg.com>\r\n";
		mail(	$user->email, 
				"Аккаунт на polymer-torg.com", 
				$message,
				$headers
		);			
		$result = new JsonResponse();
		$result->html = 'User seccess changed';
		echo $result;
	}
	
	public function ajaxChangeRole()
	{
		if(!$this->input->post()) return false;
		$id = $this->input->post('id');
		$user = $this->User->getUserById($id);
		if($this->input->post('role') == '0') {
			$this->User->updateRole($id, '0');
			$message = 'Уважаемый ' . $user->name . ', Вы были сняты с роли администратора на сайте polymer-torg.com';
		} else {
			$this->User->updateRole($id, '1');
			$message = 'Уважаемый ' . $user->name . ', Вы были назначены на роль администратора на сайте polymer-torg.com';
		}
		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: <admin@polymer-torg.com>\r\n";
		mail(	$user->email, 
				"Аккаунт на polymer-torg.com", 
				$message,
				$headers
		);			
		$result = new JsonResponse();
		$result->html = 'User seccess changed';
		echo $result;
	}		
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */