<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_item extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('m_pages');
        $this->load->library('main');
        $this->main->check_admin();
    }

    public function type($type, $items)
    {
        $data = $this->main->data_main();
        $where = array(
            'type' => $type,
            'id_language' => $data['id_language']
        );

        $data['row'] = $this->m_pages->row_data($where);
        $data['type'] = $type;
        $data['items'] = $this->db->get($items)->result();

        $this->template->set('about', 'kt-menu__item--active');
        $this->template->set('breadcrumb', 'Management ' . $data['row']->title);
        $this->template->load_admin('pages_item/index', $data);
    }

    public function update($id = '')
    {
        $pages = $this->m_pages->row_data(array('id' => $id));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
//        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($pages->seo == 'yes') {
            $this->form_validation->set_rules('meta_title', 'Meta title', 'required');
            $this->form_validation->set_rules('meta_description', 'Meta Description', 'required');
            $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'required');
        }
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE) {
            $response = array(
                'status' => 'error',
                'message' => 'The form is not correct',
                'errors' => array(
                    'title' => form_error('title'),
                    'description' => form_error('description'),
                )
            );

            if ($pages->seo == 'yes') {
                $response['errors'] = array_merge($response['errors'], array(
                    'meta_title' => form_error('meta_title'),
                    'meta_description' => form_error('meta_description'),
                    'meta_keywords' => form_error('meta_keywords')
                ));
            }

            echo json_encode($response);
        } else {
            $data_main = $this->main->data_main();

            $data = $this->input->post(NULL, TRUE);
            $data['data_1'] = json_encode($data['data_1']);
            $data['slug'] = $this->main->slug($data['title_menu']);

            if (empty($data['status_seo'])) {
                $data['status_seo'] = 'no';
            }

            if (empty($data['data_1_status'])) {
                $data['data_1_status'] = 'no';
            }


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
//					$row_data = $this->m_blog->row_data($where);
//					$this->main->delete_file($row_data->thumbnail);

                    $data['thumbnail'] = $response['filename'];
                }
            }

            if ($_FILES['file']['name']) {
                $response = $this->main->upload_file_thumbnail('file', $this->input->post('title'));
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
//					$row_data = $this->m_blog->row_data($where);
//					$this->main->delete_file($row_data->thumbnail);

                    $data['file'] = $response['filename'];
                }
            }


            if ($id == '') {
                $data['id_language'] = $data_main['id_language'];
//                $data['seo'] = 'no';

                $this->m_pages->input_data($data);
            } else {
                $where = array(
                    'id' => $id
                );
                $this->m_pages->update_data($where, $data);
            }

            echo json_encode(array(
                'status' => 'success',
                'message' => 'success input data'
            ));
        }

    }
}
