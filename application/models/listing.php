<?php
/**
 * @author Zahar Pecherin
 */
class Listing extends CI_Model {
	
	protected $_table = 'listings';
	
	public function getListingByAlias($alias)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('alias', $alias)
						->where('time >', time())	
						->where('status', '1')
						->get()
						->row()
						;
		return $res;
	}
	
	public function getListingById($id)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('id', $id)
						->where('time >', time())
						->get()
						->row()
						;
		return $res;
	}
	
	public function countItemUser()
	{
		$res = $this->db->select('COUNT(*) AS count')
						->from($this->_table)
						->where('time >', time())
						->get()
						->row()
						;
		return $res;
	}
	
	public function countItem($category = false)
	{
		$res = $this->db->select('COUNT(*) AS count')
						->from($this->_table)
						->where('time >', time())
						->where('status', '1')
						;
		if(!empty($category)) {
			$res = $this->db
						->where('category', $category)
						;					
		}
		$res = $this->db->get()
						->row()
						;
		return $res;
	}
	
	public function addFilterBySearch($word)
	{
		$this->db
				->like('name', $word)
//				->or_like('text', $word)
				;
		return $this;
	}
	
	public function addFilterByFoto()
	{
		$this->db->where('image !=', 0);
		return $this;
	}
	
	public function addFilterByUser()
	{
		$this->db->where('user', UserHelper::logedUserInfo()->id);
		return $this;
	}
	
	public function addFilterByCategory($type)
	{
		$this->db->where('category', $type);
		return $this;
	}

	public function getListings($limit, $offset)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('time >', time())
						->limit($limit, $offset)
						->get()
						->result()
						;
		return $res;
	}
	
	public function getAllListings($limit, $offset)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('time >', time())
						->where('status', '1')
						->order_by('position', 'desc')
						->order_by('date', 'desc')
						->limit($limit, $offset)
						->get()
						->result()
						;
		return $res;
	}
	
	public function getAllListingsByCategoryByFoto($limit, $offset, $type)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('time >', time())
						->where('status', '1')
						->where('category', $type)
						->where('image !=', 0)
						->order_by('position', 'desc')
						->order_by('date', 'desc')
						->limit($limit, $offset)
						->get()
						->result()
						;
		return $res;
	}
	
	public function getAllListingsByFoto($limit, $offset)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('time >', time())
						->where('status', '1')
						->where('image !=', 0)
						->order_by('position', 'desc')
						->order_by('date', 'desc')
						->limit($limit, $offset)
						->get()
						->result()
						;
		return $res;
	}
	
	public function getAllListingsByCategory($limit, $offset, $type)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('time >', time())
						->where('status', '1')
						->where('category', $type)
						->order_by('position', 'desc')
						->order_by('date', 'desc')
						->limit($limit, $offset)
						->get()
						->result()
						;
		return $res;
	}
	
	public function getExistAlias($name)
	{
		$res = $this->db->select('COUNT(name) AS count')
						->from($this->_table)
						->where('time >', time())
						->where('name', $name)
						->get()
						->row()
						;
		if($res->count > 0) {
			return $res->count;
		} else {
			return false;
		}
	}

	public function addListing($name, $text, $time, $category, $tel, $country, $image1, $image2)
    {
	    $data = array(
						'name'			=> $name,
						'text'			=> $text,
						'time'			=> time() + $time,
						'category'		=> $category,
						'country'		=> $country,
						'tel'			=> $tel,
						'user'			=> UserHelper::logedUserInfo()->id,
						'date'			=> time(),
						'image'			=> $image1,
						'image_litle'	=> $image2,
						'status'		=> '1'
				);
	
		$this->db	->set($data)
					->insert($this->_table); 
		return;
	}    	

	public function updateAlias($id, $alias)
	{
		$data = array(
			'alias' => $alias
		);
		
		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db
					->affected_rows();		
	}
	
	public function updateStatus($id, $status)
	{
		$data = array(
			'status' => $status
		);
		
		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db
					->affected_rows();
	}

	public function getListingExist($id)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('id', $id)
						->get()
						->row()
						;
		return $res;
	}
	
	public function addPremium($id, $time)
	{
		$data = array(
			'position' => '1',
			'date'	   => time(),
			'time'	   => time() + $time
		);
		$this->db->where('id', $id);
		$this->db->update($this->_table, $data);
		return $this->db
					->affected_rows();
	}

	public function updateListing($id, $name, $text, $category, $tel, $country, $image, $image_litle)
	{
		$data = array(
			'name'			=> $name,
			'text'			=> $text,
			'category'		=> $category,
			'tel'			=> $tel,
			'country'		=> $country,
			'image'			=> $image,
			'image_litle'	=> $image_litle
		);

		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db
					->affected_rows();
	}
	
	public function isMyListing($id)
	{
		$res = $this->db->select('COUNT(*) AS count')
						->from($this->_table)
						->where('id', $id)
						->where('user', UserHelper::logedUserInfo()->id)
						->get()
						->row()
						;
		if($res->count > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}