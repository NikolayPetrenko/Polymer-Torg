<?php
/**
 * @author Zahar Pecherin
 */
class User extends CI_Model {
	
	protected $_table = 'users';
	
	public function getUserByEmail($email)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('email', $email)
						->get()
						->row()
						;
		return $res;
	}
	
	public function UniqueName($name, $id)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('name', $name)
						->where('id !=', $id)
						->get()
						->row()
						;
		return $res;
	}
	
	public function UniqueEmail($email, $id)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('email', $email)
						->where('id !=', $id)
						->get()
						->row()
						;
		return $res;
	}
	
	public function getUserById($id)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('id', $id)
						->get()
						->row()
						;
		return $res;
	}
	
	public function getUserByActive($email)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('email', $email)
						->where('status', 1)
						->get()
						->row()
						;
		return $res;
	}
	
	public function getUserExist($email, $password)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('email', $email)
						->where('password', $password)
						->get()
						->row()
						;
		return $res;
	}
	
	public function getEmailExist($email)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('email', $email)
						->get()
						->row()
						;
		return $res;
	}
	
	public function add_user($name, $email, $password, $fio, $tel, $reg)
    {
	    $data = array(
						'name' => $name, 
						'email' => $email, 
						'password' => $password, 
						'reg' => $reg, 
						'status' => 0, 
						'date' => time(), 
						'fio' => $fio, 
						'tel' => $tel
				);
	
		$this->db	->set($data)
					->insert($this->_table); 
		return;
	}    	
    
	public function update_status($id)
	{
		$data = array(
						'reg' => $id, 
						'status' => 0
				);
		$this->db	->set('status', 1)
					->where($data)
					->update($this->_table);
		return $this->db
					->affected_rows();
	}
	
	public function update_password($email, $password)
	{
		$data = array(
						'email' => $email
		);
		$this->db	->set('password', $password)
					->where($data)
					->update($this->_table);
		return $this->db
					->affected_rows();		
	}
	
	public function updateProfile($id, $name, $email, $fio, $tel)
	{
		$data = array(
			'name' => $name,
			'fio' => $fio,
			'email' => $email,
			'tel' => $tel
		);

		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db
					->affected_rows();		
	}	
	
	public function updatePassword($id, $password)
	{
		$data = array(
			'password' => md5($password)
		);

		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db
					->affected_rows();		
	}
	
	public function getAllUsers($limit, $offset)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('id !=', UserHelper::logedUserInfo()->id)
						->limit($limit, $offset)
						->get()
						->result()
						;
		return $res;
	}
	
	public function countUsers()
	{
		$res = $this->db->select('COUNT(*) AS count')
						->from($this->_table)
						->get()
						->row()
						;
		return $res;
	}
    
	public function updateStatus($id, $status)
	{
		$data = array(
			'status' => $status
		);

		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();	
	}
    
	public function updateRole($id, $role)
	{
		$data = array(
			'role' => $role
		);

		$this->db->where('id', $id);
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();	
	}	
}