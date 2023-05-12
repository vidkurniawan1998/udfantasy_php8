<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_content extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('m_promotion');
		$this->load->model('m_promotion_item');
		$this->load->library('main');
		$this->main->check_admin();
	}

	public function index($db_items)
	{
		$data = $this->main->data_main();
		$data['promotion'] = $this
            ->db
            ->where('promotion.id_language', $data['id_language'])
            ->order_by('promotion.id', 'DESC')
            ->get('promotion')
            ->result();
		$data['items'] = $this->db->where(array('use'=>'yes', 'id_language'=>$data['id_language']))->get($db_items)->result();
		$data['db_items'] = $db_items;
		foreach ($data['promotion'] as $item) {
            $data['promotion_item'][$item->id] = $this->db->where('id_promotion',$item->id)->get('promotion_item')->result();
            $data['total_items'][$item->id] = count($data['promotion_item'][$item->id]);
        }
		$this->template->set('promotion', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Promotion');
		$this->template->load_admin('promotion_content/index', $data);
	}

	public function createprocess($db_items)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
		$this->form_validation->set_rules('items[]', 'Items', 'required');

		$this->load->model('m_promotion');
        $this->load->model('m_promotion_item');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
					'description' => form_error('description'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
					'items[]' => form_error('items[]'),
				)
			));
		} else {

//			$data = $this->input->post(NULL);

			$data['id_language'] = $this->input->post('id_language');
			$data['title'] = $this->input->post('title');
			$data['thumbnail_alt'] = $this->input->post('thumbnail_alt');
			$data['description'] = $this->input->post('description');
			$data['use'] = $this->input->post('use');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['meta_keywords'] = $this->input->post('meta_keywords');
			$item_array = $this->input->post('items');

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'thumbnail' => $response['message']
						)
					));
					exit;
				} else {
					$data['thumbnail'] = $response['filename'];
				}
			}

			$data['created_at'] = date('Y-m-d H:i:s');
			$data['slug'] = $this->main->slug($this->main->normalizeChars($data['title']));

			$this->m_promotion->input_data($data);
			$id_promotion = $this->db->select('id')->order_by('id','desc')->get('promotion')->row();

			foreach ($item_array as $item){
			    $item_data = $this->db->where('id',$item)->get($db_items)->row();

			    /**
                 * Input Data Item
                 */
			    $data_item['id_promotion'] = $id_promotion->id;
			    $data_item['id_item'] = $item;
			    $data_item['name_item'] = $item_data->title;
			    $data_item['price_item'] = $item_data->price;

			    $this->m_promotion_item->input_data($data_item);
            }

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data',
			));
		}
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$where_item = array('id_promotion' => $id);
		$row = $this->m_promotion->row_data($where);
		$this->main->delete_file($row->thumbnail);
		$this->m_promotion->delete_data($where);
		$this->m_promotion_item->delete_data($where_item);
	}

	public function update($db_items)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'title' => form_error('title'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$id = $this->input->post('id');
//			$data = $this->input->post(NULL);

			$data['title'] = $this->input->post('title');
			$data['thumbnail_alt'] = $this->input->post('thumbnail_alt');
			$data['description'] = $this->input->post('description');
			$data['use'] = $this->input->post('use');
			$data['meta_title'] = $this->input->post('meta_title');
			$data['meta_description'] = $this->input->post('meta_description');
			$data['meta_keywords'] = $this->input->post('meta_keywords');
			$item_array = $this->input->post('items');

            $data['slug'] = $this->main->slug($this->main->normalizeChars($data['title']));
			$where = array(
				'id' => $id
			);

			if ($_FILES['thumbnail']['name']) {
				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
				if (!$response['status']) {
					echo json_encode(array(
						'status' => 'error',
						'message' => 'The form is not correct',
						'errors' => array(
							'thumbnail' => $response['message']
						)
					));
					exit;
				} else {
//					$row_data = $this->m_promotion->row_data($where);
//					$this->main->delete_file($row_data->thumbnail);

					$data['thumbnail'] = $response['filename'];
				}
			}


			$this->m_promotion->update_data($where, $data);

            /**
             * Delete dan insert item
             */

            $where_item = array('id_promotion' => $id);
            $this->m_promotion_item->delete_data($where_item);

            foreach ($item_array as $item) {
                $where_item = array('id_promotion' => $id);
                $item_data = $this->db->where('id',$item)->get($db_items)->row();

                /**
                 * Update Data Item
                 */
                $data_item['id_promotion'] = $id;
                $data_item['id_item'] = $item;
                $data_item['name_item'] = $item_data->title;
                $data_item['price_item'] = $item_data->price;

                $this->m_promotion_item->input_data($data_item);

            }

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}
}
