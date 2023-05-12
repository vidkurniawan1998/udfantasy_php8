<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_about');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['about'] = $this->m_about->get_data()->result();
		$this->template->set('about', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management About');
		$this->template->load_admin('about/index', $data);
	}
	public function update() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
		$this->form_validation->set_error_delimiters('','');

		if($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status'=>'error',
				'message'=>'The form is not correct',
				'errors'=>array(
					'title'=>form_error('title'),
					'meta_title'=>form_error('meta_title'),
					'meta_description'=>form_error('meta_description'),
					'meta_keywords'=>form_error('meta_keywords'),
				)
			));
		} else {

				$id =$this->input->post('id');
				$title =$this->input->post('title');
				$description = $this->input->post('description');
				$description2 = $this->input->post('description2');
				if (empty($description2)){
					$description2 = $description;
				}
				$meta_title = $this->input->post('meta_title');
				$meta_description = $this->input->post('meta_description');
				$meta_keywords = $this->input->post('meta_keywords');
				$this->load->model('m_about');
				$data = array(
					'id' => $id,
					'title' => $title,
					'description'  =>$description2,
					'meta_title'  =>$meta_title,
					'meta_description'  =>$meta_description,
					'meta_keywords'  =>$meta_keywords,
				);
				$where = array(
					'id' => $id
				);

				$this->m_about->update_data($where,$data,'about');
				echo json_encode(array(
					'status'=>'success',
					'message'=>'success updating data'
				));
			}

	}
}
