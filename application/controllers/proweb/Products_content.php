<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products_content extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_products');
		$this->load->model('m_products_image');
		$this->load->library('main');

		$this->main->check_admin();
	}

	public function index()
	{
		$data = $this->main->data_main();
		$data['products'] = $this
			->db
			->select('products.*,
            products_category.title AS products_category_title, products_sub_category.title AS products_sub_category_title')
			->join('products_category', 'products_category.id = products.id_products_category', 'left')
			->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
			//            ->join('products_region', 'products_region.id = products.id_products_region','left')
			->where('products.id_language', $data['id_language'])
			->order_by('products.id', 'DESC')
			->get('products')
			->result();

		//		Multiple Image
		foreach ($data['products'] as $key => $product) {
			$data['products_image'][$product->id] = $this->db->where('products_image.id_products', $product->id)->get('products_image')->result();
		}

		$data['team'] = $this->db->order_by('title', 'ASC')->get('team')->result();
		$data['products_category'] = $this->db->where(array('id_language' => $data['id_language'], 'use' => 'yes'))->order_by('title', 'ASC')->get('products_category')->result();
		$data['products_sub_category'] = $this->db->order_by('title', 'ASC')->get('products_sub_category')->result();
		//		$data['products_region'] = $this->db->order_by('title', 'ASC')->get('products_region')->result();
		$this->template->set('products', 'kt-menu__item--active');
		$this->template->set('breadcrumb', 'Management Wine');
		$this->template->load_admin('products_content/index', $data);
	}

	public function updatestatus()
	{
		$id = $this->input->post('idproducts');
		$status = $this->input->post('status');
		// echo $status;
		$this->db->query('UPDATE `db_udfantasy`.`products` SET `use` = "' . $status . '" WHERE `id` = ' . $id . ' ');
	}

	public function createprocess()
	{
		$data_main = $this->main->data_main();

		$this->load->library('form_validation');
		//		$this->form_validation->set_rules('id_team', 'Team', 'required');
		$this->form_validation->set_rules('id_products_category', 'Wine Category', 'required');
		//		$this->form_validation->set_rules('id_products_sub_category', 'products Sub Category', 'required');
		//		$this->form_validation->set_rules('id_products_region', 'Wine Region', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		//		$this->form_validation->set_rules('sku', 'SKU', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');
		$this->form_validation->set_rules('best_seller', 'Best Seller', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');

		$this->load->model('m_products');

		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'id_products_category' => form_error('id_products_category'),
					//					'id_products_sub_category' => form_error('id_products_sub_category'),
					//					'id_products_region' => form_error('id_products_region'),
					'title' => form_error('title'),
					//					'sku' => form_error('sku'),
					'description' => form_error('description'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
					'price' => form_error('price'),
					'best_seller' => form_error('best_seller'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {

			$data = $this->input->post(NULL);

			//			Single image upload
			//			if ($_FILES['thumbnail']['name']) {
			////				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
			//				$response = $this->main->upload_file_thumbnail('thumbnail', $_FILES['thumbnail']['name']);
			//				if (!$response['status']) {
			//					echo json_encode(array(
			//						'status' => 'error',
			//						'message' => 'The form is not correct',
			//						'errors' => array(
			//							'thumbnail' => $response['message']
			//						)
			//					));
			//					exit;
			//				} else {
			//					$data['thumbnail'] = $response['filename'];
			//				}
			//			}

			if (array_key_exists('count_product_info', $data)) {
				unset($data['count_product_info']);
			}
			$data['data_info'] = json_encode($data['data_info']);

			$data['created_at'] = date('Y-m-d H:i:s');
			$data['slug'] = $this->main->slug($this->main->remove_special_characters($data['title']));

			$id_insert = $this->m_products->input_data($data);

			//			Insert multiple Image
			//			Multiple image upload
			if (count($_FILES['thumbnail']['name']) > 0 && !empty($id_insert)) {
				//                $data_image['thumbnail'] = array();
				foreach ($_FILES['thumbnail']['name'] as $key => $name) {
					if ($_FILES['thumbnail']['name'][$key]) {

						//                       make new variable
						$_FILES['image']['name'] = $_FILES['thumbnail']['name'][$key];
						$_FILES['image']['type'] = $_FILES['thumbnail']['type'][$key];
						$_FILES['image']['tmp_name'] = $_FILES['thumbnail']['tmp_name'][$key];
						$_FILES['image']['error'] = $_FILES['thumbnail']['error'][$key];
						$_FILES['image']['size'] = $_FILES['thumbnail']['size'][$key];

						if (!empty($data['thumbnail_alt'])) {
							$data_image['thumbnail_alt'] = $this->main->slug($this->main->remove_special_characters($data['thumbnail_alt'])) . '-' . $data_main['id_language'] . '-' . $key;
						} else {
							$data_image['thumbnail_alt'] = $this->main->slug($this->main->remove_special_characters($_FILES['image']['name'])) . '-' . $data_main['id_language'] . '-' . $key;
						}
						$response = $this->main->upload_file_custom('image', $data_image['thumbnail_alt'], 600, 600);
						if (!$response['status']) {
							echo json_encode(array(
								'status' => 'error',
								'message' => 'The form is not correct',
								'errors' => array(
									'thumbnail[' . $key . ']' => $response['message']
								)
							));
							exit;
						} else {
							//					$row_data = $this->m_blog->row_data($where);
							//					$this->main->delete_file($row_data->thumbnail);

							//                            array_push($data_image['thumbnail'],$response['filename']);
							$data_image['thumbnail'] = $response['filename'];
							$data_image['id_products'] = $id_insert;
							$this->m_products_image->input_data($data_image);
						}
					}
				}
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

		//		For single image
		//		$row = $this->m_products->row_data($where);
		//		$this->main->delete_file($row->thumbnail);

		//      For multiple image
		$where_image = array('id_products' => $id);
		$image = $this->m_products_image->result_data($where_image);
		foreach ($image as $image_name) {
			$this->main->delete_file($image_name->thumbnail);
		}
		$this->m_products_image->delete_data($where_image);

		$this->m_products->delete_data($where);
	}

	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_products_category', 'Wine Category', 'required');;
		//		$this->form_validation->set_rules('id_products_sub_category', 'products Sub Category', 'required');
		//		$this->form_validation->set_rules('id_products_region', 'Wine Region', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('thumbnail_alt', 'Thumbnail Alt', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');
		$this->form_validation->set_rules('meta_title', 'Meta title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
		$this->form_validation->set_error_delimiters('', '');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array(
				'status' => 'error',
				'message' => 'The form is not correct',
				'errors' => array(
					'id_products_category' => form_error('id_products_category'),
					//					'id_products_sub_category' => form_error('id_products_sub_category'),
					//					'id_products_region' => form_error('id_products_region'),
					'title' => form_error('title'),
					'description' => form_error('description'),
					'thumbnail_alt' => form_error('thumbnail_alt'),
					'price' => form_error('price'),
					'meta_title' => form_error('meta_title'),
					'meta_description' => form_error('meta_description'),
					'meta_keywords' => form_error('meta_keywords'),
				)
			));
		} else {
			$data_main = $this->main->data_main();

			$id = $this->input->post('id');
			$data = $this->input->post(NULL);
			$data['slug'] = $this->main->slug($this->main->remove_special_characters($data['title']));
			$where = array(
				'id' => $id
			);

			//			if ($_FILES['thumbnail']['name']) {
			//				$response = $this->main->upload_file_thumbnail('thumbnail', $this->input->post('title'));
			//				if (!$response['status']) {
			//					echo json_encode(array(
			//						'status' => 'error',
			//						'message' => 'The form is not correct',
			//						'errors' => array(
			//							'thumbnail' => $response['message']
			//						)
			//					));
			//					exit;
			//				} else {
			////					$row_data = $this->m_products->row_data($where);
			////					$this->main->delete_file($row_data->thumbnail);
			//
			//					$data['thumbnail'] = $response['filename'];
			//				}
			//			}

			if (array_key_exists('count_product_info', $data)) {
				unset($data['count_product_info']);
			}
			$data['data_info'] = json_encode($data['data_info']);

			if ($this->input->post('promotion_status') == 'yes') {
				$this->m_products->update_data($where, $data);
			} else {
				$data['promotion_status'] = 'no';
				$this->m_products->update_data($where, $data);
			}


			//			Insert multiple Image
			//			Multiple image upload
			if (count($_FILES['thumbnail']['name']) > 0 && !empty($id)) {
				//                $data_image['thumbnail'] = array();
				foreach ($_FILES['thumbnail']['name'] as $key => $name) {
					if ($_FILES['thumbnail']['name'][$key]) {

						//                       make new variable
						$_FILES['image']['name'] = $_FILES['thumbnail']['name'][$key];
						$_FILES['image']['type'] = $_FILES['thumbnail']['type'][$key];
						$_FILES['image']['tmp_name'] = $_FILES['thumbnail']['tmp_name'][$key];
						$_FILES['image']['error'] = $_FILES['thumbnail']['error'][$key];
						$_FILES['image']['size'] = $_FILES['thumbnail']['size'][$key];

						if (!empty($data['thumbnail_alt'])) {
							$data_image['thumbnail_alt'] = $this->main->slug($this->main->remove_special_characters($data['thumbnail_alt'])) . '-' . $data_main['id_language'] . '-' . $key;
						} else {
							$data_image['thumbnail_alt'] = $this->main->slug($this->main->remove_special_characters($_FILES['image']['name'])) . '-' . $data_main['id_language'] . '-' . $key;
						}
						$response = $this->main->upload_file_custom('image', $data_image['thumbnail_alt'], 600, 600);
						if (!$response['status']) {
							echo json_encode(array(
								'status' => 'error',
								'message' => 'The form is not correct',
								'errors' => array(
									'thumbnail[' . $key . ']' => $response['message']
								)
							));
							exit;
						} else {
							//					$row_data = $this->m_blog->row_data($where);
							//					$this->main->delete_file($row_data->thumbnail);

							//                            array_push($data_image['thumbnail'],$response['filename']);
							$data_image['thumbnail'] = $response['filename'];
							$data_image['id_products'] = $id;
							$this->m_products_image->input_data($data_image);
						}
					}
				}
			}

			echo json_encode(array(
				'status' => 'success',
				'message' => 'success input data'
			));
		}
	}

	function remove_multi_image($thumbnail)
	{
		$where = array('thumbnail' => $thumbnail);
		$this->main->delete_file($thumbnail);
		$this->m_products_image->delete_data($where);

		echo json_encode(array(
			'status' => 'success',
			'message' => 'success remove image'
		));
	}
}
