<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Zahar Pecherin
 */
class Main extends CI_Controller {

	public function getMessage()
	{
		$file_array = file( "database.txt" );
		$subject = 'Новый специализированный справочно-информационный портал по полимерам. Бесплатное размещение объявлений!';
		$message = '<a href="http://polymer-torg.com">POLYMER-TORG.COM</a> специализированный справочно-информационный портал, поставивший перед собой цель помочь Вам оперативно обмениваться информацией по товарами и услугам в сфере переработки полимеров.</br>
			Наш интернет ресурс объединяет участников рынка полимеров, со всей России и стран Постсоветского пространства.<br> 
			Это тысячи участников из Российской Федерации, сотни участников из стран ближнего зарубежья.<br>
			Наша площадка бесплатно предоставляет Вам возможность по размещению информации от поставщиков и покупателей сырья<br>
			полимеров, готовой продукции и т.д.<br>
			http://polymer-torg.com';
		emailSendMass($file_array, $message, $subject);
		die('Успех ёпта!');
	}


	public function index()
	{
		$limit = 10;
		$this->load->model(array('Listing', 'Category'));
		$type = $this->uri->segment(3, 'all');
		$type = $type == 'page' ? 'all' : $type;
		if($type != 'all') {
			$offset = $this->uri->segment(5, 0);
			$config['uri_segment'] = 5;
			$config['total_rows'] = $this->Listing->countItem($type)->count;
			$config['base_url'] = base_url() . 'main/index/' . $type . '/page/';
			$data['listings'] = $this->Listing->addFilterByCategory($type)->getAllListings($limit, $offset);
			$data['category'] = $this->uri->segment(3, 'all');
		} else {
			$offset = $this->uri->segment(4, 0);
			$config['uri_segment'] = 4;
			$config['base_url'] = base_url() . 'main/index/page/';
			$config['total_rows'] = $this->Listing->countItem()->count;
			$data['listings'] = $this->Listing->getAllListings($limit, $offset);
		}
		$this->load->library('pagination');
		$config['per_page'] = $limit; 
		$this->pagination->initialize($config); 		
		$this->load->view('main', $data);
	}

	public function search()
	{
		$this->load->model(array('Listing', 'Category'));
		$word = $this->input->get('q');
		$data['word'] = $word;
		$data['foto'] = $this->input->get('foto');
		$data['category'] = $this->input->get('category');
		$foto = $this->input->get('foto') ? '&foto=' . $this->input->get('foto'): '';
		$category = $this->input->get('category') ? '&category=' . $this->input->get('category') : '';
		$limit = 10;
		$this->load->model(array('Listing', 'Category'));
		$offset = $this->uri->segment(5, 0);
		$config['uri_segment'] = 5;
		$config['base_url'] = base_url() . 'main/search/?=q' . $word . $category . $foto . '/page/';
		$cat = $this->input->get('category');
		if($this->input->get('foto')) {
			if(!empty($cat)) {
				$config['total_rows'] = $this->Listing->countItem($this->input->get('category'))->count;
				$data['listings'] = $this->Listing->addFilterBySearch($word)->getAllListingsByCategoryByFoto($limit, $offset, $this->input->get('category'));
			} else {
				$data['listings'] = $this->Listing->addFilterBySearch($word)->getAllListingsByFoto($limit, $offset);
				$config['total_rows'] = $this->Listing->countItem()->count;
			}
		} else {
			if(!empty($cat)) {
				$config['total_rows'] = $this->Listing->countItem($this->input->get('category'))->count;
				$data['listings'] = $this->Listing->addFilterBySearch($word)->getAllListingsByCategory($limit, $offset, $this->input->get('category'));
			} else {
				$data['listings'] = $this->Listing->addFilterBySearch($word)->getAllListings($limit, $offset);
				$config['total_rows'] = $this->Listing->countItem()->count;
			}
		}
		$this->load->library('pagination');
		$config['per_page'] = $limit; 
		$this->pagination->initialize($config); 		
		$this->load->view('main', $data);
	}
	
	public function contacts()
	{
		$this->load->view('contacts');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */