<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Script extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Script_model', 'scriptmod');
	}

	public function index()
	{
		$query = $this->scriptmod->get_files();
		
		$n = 0;
		foreach ($query->result_array() as $key => $value) {
			
			$file = explode("_", $value['file_name']);
			$reg = substr($file[1], 2)."<br>";

			$update = $this->scriptmod->set_outgo_img_regional($value['id'],$reg);

			if($update) {
				$n++;
			}

		}


		$data['updates'] = $n;
		$this->load->view('script',$data);
	}

}

/* End of file Script.php */
/* Location: ./application/controllers/Script.php */