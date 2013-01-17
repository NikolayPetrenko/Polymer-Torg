<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Zahar Pecherin
 */
class Login extends CI_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('User');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->load->helper(array('string', 'captcha'));
	}

	public function ajaxCaptcha()
	{
		if(!$this->input->post()) return false;
		$this->session->unset_userdata('word');
		$word = random_string('nozero', 6);
		$vals = array(
			'word' => $word,
			'img_path' => './images/captcha/',
			'img_url' => base_url().'images/captcha/',
			'font_path' => base_url().'./system/fonts/volatile1brk.ttf',
			'img_width' => '120',
			'img_height' => '30',
			'id' => 'captcha',
		);
		$cap = create_captcha($vals);
		$this->session->set_userdata('word', $word);
		$result = new JsonResponse();
		$result->html = $cap['image'];
		echo $result;
	}

	/**
	 * This method implements user registration 
	 * sends you an email to email the code to 
	 * activate your account
	 */ 	
	public function signup()
	{
		if(UserHelper::loggedIn()) redirect(404);
		$this->form_validation	->set_rules('name', 'имя', 'trim|required|min_length[4]|max_length[12]|is_unique[users.name]|xss_clean')
								->set_rules('email', 'email', 'trim|required|valid_email|is_unique[users.email]|xss_clean')
								->set_rules('password', 'Пароль', 'trim|required|min_length[6]|matches[passconf]|md5')
								->set_rules('passconf', 'Повторите пароль', 'trim|required')
								->set_rules('fio', 'Фамилия Имя Отчество', 'xss_clean')
								->set_rules('tel', 'Телефон', 'xss_clean')
								->set_rules('captcha', 'код на картинке', 'required|callback__captcha_check')
								->set_message('required', 'Поле не должно быть пустым')
								->set_message('valid_email', 'Введите корректный емайл')
								->set_message('min_length', '%s не должно быть не менее %s символов')
								->set_message('max_length', '%s не должно быть не более %s символов')
								->set_message('is_unique', 'Такое %s уже зарегистрирован(о) на сайте')
								->set_message('matches', 'Пароли не совпадают')
								;
		if ($this->form_validation->run() == FALSE) {
			$word = random_string('nozero', 6);
			$vals = array(
				'word' => $word,
				'img_path' => './images/captcha/',
				'img_url' => base_url().'./images/captcha/',
				'font_path' => base_url().'./system/fonts/volatile1brk.ttf',
				'img_width' => '120',
				'img_height' => '30',
				'id' => 'captcha',
			);
			$cap = create_captcha($vals);
			$data['captcha'] = $cap['image'];
			$this->session->set_userdata('word', $word);
			$this->load->view('signup', $data);
		} else {
			$email = $this->input->post('email');
			$reg = md5($this->input->post('email') . mktime());
			$this->User->add_user(
									$this->input->post('name'), 
									$email, 
									$this->input->post('password'), 
									$this->input->post('fio'), 
									$this->input->post('tel'),
									$reg
						);
			$message = 'Чтобы активировать свой аккаунт пройдите по ссылке ' . base_url() . 'login/active/'. $reg .'<br> или скопируйте ее и вставте в браузер.';
			$data['link'] = '<a href="' . base_url() . 'login/index">Авторизация</a>';
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <reg@polymer-torg.com>\r\n";
			mail(	$email, 
					"Потверждение регистрации на polymer-torg.com", 
					$message,
					$headers
			);
			$data['success'] = 'Регистрация выполнена успешна, вам на email было отправлено письмо для активации аккаунта';
			$data['link'] = '<a href="' . base_url() . 'login/index">Авторизация</a>';
			$this->load->view('system_mes', $data);
		}
	}
    
	/**
	 * This method implements user authentication, 
	 * data checking, recording a session 
	 * for user information (id, nick)
	 */ 
	function index()
	{
		if(UserHelper::loggedIn()) redirect(404);
		$this->form_validation	->set_rules('email', 'Емайл', 'trim|required|callback__nick_check|callback__status_check|xss_clean')
								->set_rules('password', 'Пароль', 'trim|required|md5')
								->set_message('required', 'Поле не должно быть пустым')
								;		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login');
		} else {
			$email = $this->input->post('email');
			$user = $this->User->getUserByEmail($email);
			$userData['user'] = array(
								'id' => $user->id,
								'name' => $user->name,
								'email' => $email,
								'login' => true,
								'role'	=> $user->role
						);
			$this->session->set_userdata($userData);
			if ($this->input->post('remember') == 1){
				$userParams = array();
				$userParams['email']    = $email;
				$userParams['password'] = $this->input->post('password');
				setcookie('polimer_cookie',
							serialize($userParams), 
							strtotime("+10 days"), 
							'/', 
							null, 
							null, 
							1
						);
			} 
			redirect('/main', 'location');
		}
	}
	
	/**
	* This method enables a user account that has passed 
	* on the link to the letter sent to him by email at 
	* registration and verify the ID register
	* @param $id
	*/
	function active($id)
	{
		if(UserHelper::loggedIn()) redirect(404);
		if ($this->User->update_status($id) == 1) {
			$data['success'] = 'Ваш аккаунт успешно активирован, вы можете войти в систему.';
		} else {
			$data['error'] = 'Активация не удалась - аккаунт уже был активирован!';
		}
		$data['link'] = '<a href="' . base_url() . 'login/index">Авторизация</a>';
		$this->load->view('system_mes', $data);
	}

	public function forgotPassword()
	{
		if(UserHelper::loggedIn()) redirect(404);
		$this->form_validation	->set_rules('email', 'email', 'trim|required|valid_email|callback__email_check|xss_clean')
								->set_rules('captcha', 'код на картинке', 'required|callback__captcha_check')
								->set_message('required', 'Поле не должно быть пустым')
								->set_message('valid_email', 'Введите корректный емайл')
								;
		if ($this->form_validation->run() == FALSE) {
			$word = random_string('nozero', 6);
			$vals = array(
				'word' => $word,
				'img_path' => './images/captcha/',
				'img_url' => base_url().'./images/captcha/',
				'font_path' => base_url().'./system/fonts/volatile1brk.ttf',
				'img_width' => '120',
				'img_height' => '30',
				'id' => 'captcha',
			);
			$cap = create_captcha($vals);
			$data['captcha'] = $cap['image'];
			$this->session->set_userdata('word', $word);
			$this->load->view('forgot_password', $data);
		} else {
			$email = $this->input->post('email');
			$password = random_string('alnum', 6);
			$this->User->update_password(
									$email, 
									md5($password) 
						);
			$this->email->from($this->config->item('admin_email'), $this->config->item('admin_email'))
						->to($email)
						->subject('Восстановление пароля на сайте polimer-torg.com')
						->message('Ваш новый пароль: ' . $password)
						->send();

			redirect(site_url('main'));
		}		
	}

	function _email_check($str)
	{
		if ($this->User->getEmailExist($str)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_email_check', 'Такой email не зарегистрирован в системе');
			return FALSE;
		}
	}
	
	/**
	* This method validates the entered nickname and password
	* @param $str
	*/ 
	function _nick_check($str)
	{
		$password = $this->input->post('password');
		if ($this->User->getUserExist($str, md5(trim($password)))) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_nick_check', 'Неправильный email или пароль! Проверте правильность введенных данных.');			   
			return FALSE;
		}
	}

	/**
	* This method checks that the user has activated your account
	* @param $str
	*/ 
	function _status_check($str)
	{
		if ($this->User->getUserByActive($str)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_status_check', 'Ваш аккаунт не активирован!');			   
			return FALSE;
		}
	}
        
	function _captcha_check($str)
	{
		$captcha = $this->input->post('captcha');
		$word = $this->session->userdata('word');
		if ($captcha != $word) {
			$this->form_validation->set_message('_captcha_check', 'Неверный код!');
			return FALSE;
		} else {			   
				return TRUE;
		}
		$this->session->unset_userdata('word');
	}
	
	/**
	* This method logoff user, deletes user data from the session
	*/ 
	function logout()
	{
		setcookie("polimer_cookie", "", 1, "/");
		$this->session->unset_userdata('user');
		redirect(''); 
	}	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */