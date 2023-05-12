<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('main');
        $this->load->library('cart');
    }

    public function index()
    {
        $data = $this->main->data_front();

        $data['page'] = $this->db->where(array('type' => 'home', 'id_language' => $data['id_language']))->get('pages')->row();
        $data['sliders'] = $this->db->where(array('use' => 'yes', 'id_language' => $data['id_language']))->order_by('id', 'ASC')->get('slider')->result();
        $data['banners'] = $this->db->where(array('use' => 'yes', 'id_language' => $data['id_language']))->order_by('id', 'ASC')->get('banner')->result();
        $sesi_home = $this->db
            ->where_in('type', array(
                'home_sesi_1',
                'home_sesi_2',
                'home_products_by_category'
            ))
            ->where('id_language', $data['id_language'])
            ->get('pages')
            ->result();

        $data['products_list_best'] = $this->db
            ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_category', 'products_category.id = products.id_products_category')
            ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
            ->where(array(
                'products.id_language' => $data['id_language'],
                'products.use' => 'yes',
                'products.best_seller' => 'yes'
            ))
            ->order_by('products.id_products_category', 'ASC')
            ->get('products', 16)
            ->result();

        foreach ($data['products_list_best'] as $product) {
            if ($product->best_seller == 'yes' || !array_key_exists($product->id_products_category, $data['best_selling_category'])) {
                $best_selling_category = $this->db->where('id', $product->id_products_category)->get('products_category')->row();
                $data['best_selling_category'][$product->id_products_category] = $best_selling_category;
            }
            $data['products_image_best'][$product->id] = $this->db->where(array('id_products' => $product->id))->get('products_image')->row();
        }

        $data['products_list_new'] = $this->db
            ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_category', 'products_category.id = products.id_products_category')
            ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
            ->where(array(
                'products.id_language' => $data['id_language'],
                'products.use' => 'yes',
                'products.is_new' => 'yes'
            ))
            ->order_by('products.id_products_category', 'ASC')
            ->get('products', 15)
            ->result();

        foreach ($data['products_list_new'] as $product) {
            $data['products_image_new'][$product->id] = $this->db->where(array('id_products' => $product->id))->get('products_image')->row();
        }

        foreach ($sesi_home as $row) {
            $data[$row->type] = $row;
        }

        $data['category_products_by_category'] = array();
        foreach (json_decode($data['home_products_by_category']->data_1) as $products_by_category) {
            foreach ($products_by_category as $id_category) {
                $data['list_products_by_category'][$id_category] = $this->db
                    ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
                    ->join('products_category', 'products_category.id = products.id_products_category')
                    ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                    ->where(array(
                        'products.use' => 'yes',
                        'products.id_language' => $data['id_language'],
                        'products.id_products_category' => $id_category
                    ))
                    ->order_by('rand()')
                    ->get('products', 6)
                    ->result();
                $data_category = $this->db->where(array('id' => $id_category))->get('products_category')->result();
                array_push($data['category_products_by_category'], $data_category);
            }
        }
        json_encode($data['category_products_by_category']);

        foreach ($data['category_products_by_category'] as $data_category) {
            foreach ($data_category as $category) {
                foreach ($data['list_products_by_category'][$category->id] as $list_product) {
                    $data['list_products_image_by_category'][$list_product->id] = $this->db
                        ->where(array(
                            'id_products' => $list_product->id
                        ))
                        ->get('products_image', 6)
                        ->row();
                }
            }
        }

        $this->template->front('home', $data);
    }
}
