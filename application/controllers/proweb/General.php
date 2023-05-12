<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->library('main');
		$this->main->check_admin();
	}

	function language_change($id) {
		$this->session->set_userdata(array(
			'id_language'=>$id
		));
	}


}
