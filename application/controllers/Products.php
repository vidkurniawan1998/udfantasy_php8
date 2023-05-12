<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('main');
        $this->load->library('cart');
    }

    public function index($category = NULL, $sub_category = NULL)
    {
        $data = $this->main->data_front();

        $keyword = $this->input->get('search');
        $array_keyword = array();
        $array_or_keyword = array();
        $max_price = $this->input->get('max_price');
        $sort = $this->input->get('sort') ? $this->input->get('sort') : NULL;

        if (!empty($category) && !empty($sub_category)) {
            $select_query = 'products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug';
            $where_category = array(
                'products.use' => 'yes',
                'products_category.slug' => $category,
                'products_sub_category.slug' => $sub_category
            );
            $type_category = 'both';
        } else if (!empty($category) || !empty($sub_category)) {
            $what_category = $sub_category ? 'sub_category' : 'category';
            $unselect_category = $sub_category ? 'category' : 'sub_category';
            $fill_category = $sub_category ? $sub_category : $category;
            $select_query = 'products.*, products_' . $what_category . '.slug as ' . $what_category . '_slug, products_' . $unselect_category . '.slug as ' . $unselect_category . '_slug';
            $where_category = array(
                'products.use' => 'yes',
                'products_' . $what_category . '.slug' => $fill_category
            );
            $type_category = 'one_of';
        } else {
            $select_query = 'products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug';
            $where_category = array(
                'products.use' => 'yes'
            );
            $type_category = 'none';
        }

        if (!empty($keyword) && $type_category === 'both') {
            $type_sorter = 'all_sort';
        } else if (empty($keyword) && $type_category === 'both') {
            $type_sorter = 'key_no_cat_both_yes';
        } else if (!empty($keyword) && $type_category === 'one_of') {
            $type_sorter = 'key_yes_cat_one_of';
        } else if (empty($keyword) && $type_category === 'one_of') {
            $type_sorter = 'key_no_cat_one_of';
        } else if (!empty($keyword) && $type_category === 'none') {
            $type_sorter = 'key_yes_cat_none';
        } else if (empty($keyword) && $type_category === 'none') {
            $type_sorter = 'key_no_cat_none';
        }

        switch ($sort) {
            case 'latest':
                $order_column = 'products.created_at';
                $order_desc_asc = 'DESC';
                break;

            case 'bestseller':
                $order_column = 'products.best_seller';
                $order_desc_asc = 'DESC';
                break;

            case 'average-rating':
                $order_column = 'products.average_rating';
                $order_desc_asc = 'DESC';
                break;

            case 'price-low-high':
                $order_column = 'products.price';
                $order_desc_asc = 'ASC';
                break;

            case 'price-high-low':
                $order_column = 'products.price';
                $order_desc_asc = 'DESC';
                break;

            default:
                $order_column = 'products.created_at';
                $order_desc_asc = 'DESC';
        }

        if (empty($max_price)) {
            switch ($type_sorter) {
                case 'key_yes_cat_both_yes':
                    $array_keyword = array('products.title' => $keyword);
                    $array_or_keyword = array('products.description' => $keyword, 'products.title_eng' => $keyword);

                    $max_price = $this->db
                        ->select($select_query)
                        ->select_max('products.price')
                        ->join('products_category', 'products_category.id = products.id_products_category')
                        ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category')
                        ->where($where_category)
                        ->like($array_keyword)
                        ->or_like($array_or_keyword)
                        ->order_by($order_column, $order_desc_asc)
                        ->get('products')
                        ->row()->price;
                    break;
                case 'key_no_cat_both_yes':
                    $array_keyword = array('products.title' => $keyword);
                    $array_or_keyword = array('products.description' => $keyword, 'products.title_eng' => $keyword);

                    $max_price = $this->db
                        ->select($select_query)
                        ->select_max('products.price')
                        ->join('products_category', 'products_category.id = products.id_products_category')
                        ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                        ->where($where_category)
                        ->order_by($order_column, $order_desc_asc)
                        ->get('products')
                        ->row()->price;
                    break;
                case 'key_yes_cat_one_of':
                    $array_keyword = array('products.title' => $keyword);
                    $array_or_keyword = array('products.description' => $keyword, 'products.title_eng' => $keyword);

                    $max_price = $this->db
                        ->select($select_query)
                        ->select_max('products.price')
                        ->join('products_' . $what_category, 'products_' . $what_category . '.id = products.id_products_' . $what_category)
                        ->join('products_' . $unselect_category, ' products_' . $unselect_category . '.id = products.id_products_' . $unselect_category)
                        ->where($where_category)
                        ->like($array_keyword)
                        ->or_like($array_or_keyword)
                        ->order_by($order_column, $order_desc_asc)
                        ->get('products')
                        ->row()->price;
                    break;
                case 'key_no_cat_one_of':
                    $max_price = $this->db
                        ->select($select_query)
                        ->select_max('products.price')
                        ->join('products_' . $what_category, 'products_' . $what_category . '.id = products.id_products_' . $what_category)
                        ->join('products_' . $unselect_category, ' products_' . $unselect_category . '.id = products.id_products_' . $unselect_category)
                        ->where($where_category)
                        ->order_by($order_column, $order_desc_asc)
                        ->get('products')
                        ->row()->price;
                    break;
                case 'key_yes_cat_none':
                    $array_keyword = array('products.title' => $keyword);
                    $array_or_keyword = array('products.description' => $keyword, 'products.title_eng' => $keyword);

                    $max_price = $this->db
                        ->select($select_query)
                        ->select_max('products.price')
                        ->join('products_category', 'products_category.id = products.id_products_category')
                        ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                        ->where($where_category)
                        ->like($array_keyword)
                        ->or_like($array_or_keyword)
                        ->order_by($order_column, $order_desc_asc)
                        ->get('products')
                        ->row()->price;
                    break;
                default:
                    $max_price = $this->db
                        ->select($select_query)
                        ->select_max('products.price')
                        ->join('products_category', 'products_category.id = products.id_products_category')
                        ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                        ->where($where_category)
                        ->order_by($order_column, $order_desc_asc)
                        ->get('products')
                        ->row()->price;
                    break;
            }
        }

        $max_price = $max_price ? $max_price : 0;
        $lowest_price_range = $this->input->get('lowest_price_range') ? $this->input->get('lowest_price_range') : 0;
        $highest_price_range = $this->input->get('highest_price_range') ? $this->input->get('highest_price_range') : $max_price;

        $uri_2 = $this->uri->segment(2);
        $offset = $this->uri->segment(3);

        $data['page'] = $this->db->where(array('type' => 'shop', 'id_language' => $data['id_language']))->get('pages')->row();
        $params = $_SERVER['QUERY_STRING'];
        $this->session->set_userdata('uri_shop', current_url() . '?' . $params);

        switch ($type_sorter) {
            case 'key_yes_cat_both_yes':
                $jumlah_data = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->like($array_keyword)
                    ->or_like($array_or_keyword)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products')
                    ->num_rows();

                $data['products_list'] = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->like($array_keyword)
                    ->or_like($array_or_keyword)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products', 12, $offset)
                    ->result();
                break;
            case 'key_no_cat_both_yes':
                $jumlah_data = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products')
                    ->num_rows();

                $data['products_list'] = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products', 12, $offset)
                    ->result();
                break;
            case 'key_yes_cat_one_of':
                $jumlah_data = $this->db
                    ->select($select_query)
                    ->join('products_' . $what_category, 'products_' . $what_category . '.id = products.id_products_' . $what_category)
                    ->join('products_' . $unselect_category, ' products_' . $unselect_category . '.id = products.id_products_' . $unselect_category)
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->like($array_keyword)
                    ->or_like($array_or_keyword)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products')
                    ->num_rows();

                $data['products_list'] = $this->db
                    ->select($select_query)
                    ->join('products_' . $what_category, 'products_' . $what_category . '.id = products.id_products_' . $what_category)
                    ->join('products_' . $unselect_category, ' products_' . $unselect_category . '.id = products.id_products_' . $unselect_category)
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->like($array_keyword)
                    ->or_like($array_or_keyword)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products', 12, $offset)
                    ->result();
                break;
            case 'key_no_cat_one_of':
                $jumlah_data = $this->db
                    ->select($select_query)
                    ->join('products_' . $what_category, 'products_' . $what_category . '.id = products.id_products_' . $what_category)
                    ->join('products_' . $unselect_category, ' products_' . $unselect_category . '.id = products.id_products_' . $unselect_category)
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products')
                    ->num_rows();

                $data['products_list'] = $this->db
                    ->select($select_query)
                    ->join('products_' . $what_category, 'products_' . $what_category . '.id = products.id_products_' . $what_category)
                    ->join('products_' . $unselect_category, ' products_' . $unselect_category . '.id = products.id_products_' . $unselect_category)
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products', 12, $offset)
                    ->result();
                break;
            case 'key_yes_cat_none':
                $jumlah_data = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->like($array_keyword)
                    ->or_like($array_or_keyword)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products')
                    ->num_rows();

                $data['products_list'] = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->like($array_keyword)
                    ->or_like($array_or_keyword)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products', 12, $offset)
                    ->result();
                break;
            default:
                $jumlah_data = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products')
                    ->num_rows();

                $data['products_list'] = $this->db
                    ->select($select_query)
                    ->join('products_category', 'products.id_products_category = products_category.id')
                    ->join('products_sub_category', 'products.id_products_sub_category = products_sub_category.id', 'left')
                    ->where($where_category)
                    ->where('price >= ' . $lowest_price_range)
                    ->where('price <= ' . $highest_price_range)
                    ->order_by($order_column, $order_desc_asc)
                    ->get('products', 12, $offset)
                    ->result();
                break;
        }

        $this->load->library('pagination');

        if (!empty($category) && !empty($sub_category)) {
            $config['base_url'] = site_url('produk/' . $category . '/' . $sub_category . '/');
        } else if (!empty($category)) {
            $config['base_url'] = site_url('produk/' . $category . '/');
        } else {
            $config['base_url'] = site_url('produk/');
        }
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = 12;

        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = '<i class="linearicons-arrow-right" style="line-height: unset;"></i>';
        $config['prev_link'] = '<i class="linearicons-arrow-left" style="line-height: unset;"></i>';
        $config['full_tag_open'] = '<ul class="pagination mt-3 justify-content-center pagination_style3">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</li></span>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</li></span>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</li></span>';
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        foreach ($data['products_list'] as $product) {
            $data['products_image'][$product->id] = $this->db->where('id_products', $product->id)->get('products_image')->row();
        }

        $data['max_price'] = $max_price;
        $data['category_type'] = $what_category;

        $data['products_categories'] = $this->db->where(array('use' => 'yes'))->order_by('id', 'ASC')->get('products_category')->result();
        $data['searched_keyword'] = $keyword;

        $data['selected_category'] = $category;

        $data['lowest_price_range'] = $lowest_price_range;
        $data['highest_price_range'] = $highest_price_range;
        $data['uri_shop'] = $this->session->userdata('uri_shop');

        if (!empty($sort)) {
            $data['sort'] = $sort;
        } else {
            $data['sort'] = NULL;
        }

        $this->template->front('products', $data);
    }

    public function detail($slug)
    {
        $data = $this->main->data_front();

        $data['page'] = $this->db->where(array('type' => 'shop', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['captcha'] = $this->main->captcha();
        $data['products_detail'] = $this->db
            ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_category', 'products_category.id = products.id_products_category')
            ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
            ->where(
                array(
                    'products.use' => 'yes',
                    'products.slug' => $slug
                )
            )
            ->order_by('products.id', 'ASC')
            ->get('products')
            ->row();
        $data['products_images'] = $this->db->where('id_products', $data['products_detail']->id)->order_by('id', 'ASC')->get('products_image')->result();
        $data['products_category'] = $this->db->where('id', $data['products_detail']->id_products_category)->get('products_category')->row();
        $data['products_random'] = $this->db
            ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_category', 'products_category.id = products.id_products_category')
            ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
            ->where(
                array(
                    'products.use' => 'yes',
                    'products.slug !=' => $slug,
                    'products.id_products_category' => $data['products_detail']->id_products_category
                )
            )
            ->order_by('rand()')
            ->limit(8)
            ->get('products')
            ->result();
        foreach ($data['products_random'] as $random) {
            $data['products_random_images'][$random->id] = $this->db->where('id_products', $random->id)->get('products_image')->row();
        }
        $data['products_permalink'] = $this->main->permalink(array('products', $data['page']->title));
        $data['highest_price_category'] = $this->db->where(array('use' => 'yes', 'id_products_category' => $data['products_category']->id))->order_by('price', 'DESC')->get('products')->row();
        $data['products_review'] = $this->db->where('id_products', $data['products_detail']->id)->get('products_review')->result();

        if (!empty($data['home'])) {
            $data['home'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
        }
        $this->template->front('products_detail', $data);
    }

    public function uri_get($get)
    {
        $base_url = site_url();
        $base_query_pos = strpos($base_url, '?');

        // Unset the control, method, old-school routing options
        unset($get['c'], $get['m'], $get[TRUE]);

        $base_url = substr($base_url, 0, $base_query_pos);
        return $base_url;
    }

    public function review($slug_product)
    {
        error_reporting(0);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name User', 'required');
        $this->form_validation->set_rules('rating', 'Rating', 'required');
        $this->form_validation->set_rules('email', 'Email User', 'required');
        $this->form_validation->set_rules('message', 'Message User', 'required');
        $this->form_validation->set_rules('captcha', 'Security Code', 'required|callback_captcha_check');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'The form is not correct',
                'errors' => array(
                    'name' => form_error('name'),
                    'rating' => form_error('rating'),
                    'email' => form_error('email'),
                    'message' => form_error('message'),
                    'captcha' => form_error('captcha'),
                )
            ));
        } else {
            $this->load->model('m_products_review');
            $this->load->model('m_products');

            $data = $this->input->post(NULL);
            unset($data['captcha']);

            $product = $this->db->where('slug', $slug_product)->get('products')->row();
            $category_title = $this->db->select('products_category.title')->where('id', $product->id_products_category)->get('products_category')->row();
            $data['id_products'] = $product->id;

            $this->m_products_review->input_data($data);

            $update_data['count_rating'] = $product->count_rating + 1;
            $update_data['total_rating'] = $product->total_rating + $data['rating'];
            $update_data['average_rating'] = ($product->total_rating + $data['rating']) / $update_data['count_rating'];
            $where_update = array(
                'id' => $data['id_products']
            );

            $this->m_products->update_data($where_update, $update_data);

            echo json_encode(array(
                'status' => 'success',
                'reloadPage' => 'reload',
                'message' => 'success input data',
            ));
        }
    }

    public function captcha_check($str)
    {
        if ($str == $this->session->userdata('captcha_mwz')) {
            return TRUE;
        } else {
            $this->form_validation->set_message('captcha_check', 'security code was wrong, please fill again truly');
            return FALSE;
        }
    }
}
