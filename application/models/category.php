<?php
/**
 * @author Zahar Pecherin
 */
class Category extends CI_Model {
	
	protected $_table = 'categories';
	
	public function getCategoryById($id)
	{
		$res = $this->db->select()
						->from($this->_table)
						->where('id', $id)
						->get()
						->row()
						;
		return $res;
	}
}