<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Script_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_files()
	{
		$query = $this->db->query('SELECT id, file_name FROM outgo_img');
		return $query;
	}

	public function set_outgo_img_regional($id, $regional_id)
	{
		$this->db->where('id', $id);
		return $this->db->update('outgo_img', array("regional_id" => $regional_id));
	}

}

/* End of file Script_model.php */
/* Location: ./application/models/Script_model.php */