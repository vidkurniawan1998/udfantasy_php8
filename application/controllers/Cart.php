<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->library('main');
        $this->load->library('cart');
    }

    public function index()
    {
        $data = $this->main->data_front();

        $data['page'] = $this->db->where(array('type' => 'cart', 'id_language' => $data['id_language']))->get('pages')->row();

        $this->template->front('cart', $data);
    }

    public function cart_destroy()
    {
        $this->cart->destroy();
    }

    public function cart_total_items()
    {
        echo $this->cart->total_items();
    }

    public function cart_count_items()
    {
        echo count($this->cart->contents());
    }

    public function cart_total_price()
    {
        echo $this->cart->total();
    }

    public function remove_row($rowid)
    {
        $this->cart->remove($rowid);
        echo $this->cart_total_price();
    }

    public function remove_all_row()
    {
        $this->cart_destroy();
        echo $this->cart_total_price();
    }

    public function addto_cart($id, $qty)
    {
        $info_products = $this->db
            ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_category', 'products_category.id = products.id_products_category')
            ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
            ->where('products.id',$id)
            ->get('products')
            ->row();
        if ($info_products->promotion_status == 'yes') {
            $info_products->price = $info_products->promotion_price;
        }
        $info_products->thumbnail =
            $this->db->where('id_products', $info_products->id)->get('products_image')->row()->thumbnail;
        $is_new = 'yes';
        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == $id){
                $is_new = 'no';
                break;
            }
        }

        $data = array(
            'id'                => $id,
            'qty'               => $qty,
            'price'             => $info_products->price,
            'subtotal'          => $qty * $info_products->price,
            'name'              => $this->main->remove_special_characters($info_products->title),
            'thumbnail'         => $info_products->thumbnail,
            'thumbnail_alt'     => $info_products->thumbnail_alt,
            'category_slug'     => $info_products->category_slug,
            'sub_category_slug' => $info_products->sub_category_slug,
            'slug'              => $info_products->slug
        );

        $response = $this->cart->insert($data);
        $rowid = $response;
        if (empty($response))
        {
            $response = 'false';
        } else {
            $response = 'true';
        }

        foreach ($this->cart->contents() as $item){
            if ($item['id'] == $id){
                $qty = $item['qty'];
            }
        }

        $response =  array(
            'response' => $response,
            'item' => $info_products,
            'qty' => $qty,
            'rowid' => $rowid,
            'total_items' => count($this->cart->contents()),
            'total_price' => $this->cart->total(),
            'is_new' => $is_new
        );
        echo json_encode($response);
    }

    public function cart_update(){
        $id_array = $this->input->post('id');
        $qty_array = $this->input->post('qty');

        foreach ($id_array as $key => $id){
            $info_products = $this->db
                ->select('products.*, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
                ->join('products_category', 'products_category.id = products.id_products_category')
                ->join('products_sub_category', 'products_sub_category.id = products.id_products_sub_category', 'left')
                ->where('products.id',$id)
                ->get('products')
                ->row();
            if ($info_products->promotion_status == 'yes') {
                $info_products->price = $info_products->promotion_price;
            }
            $info_products->thumbnail =
                $this->db->where('id_products', $info_products->id)->get('products_image')->row()->thumbnail;

            $data[$key] = array(
                'id'            => $id,
                'qty'           => $qty_array[$key],
                'price'         => $info_products->price,
                'subtotal'      => $qty_array[$key] * $info_products->price,
                'name'          => $this->main->remove_special_characters($info_products->title),
                'thumbnail'     => $info_products->thumbnail,
                'thumbnail_alt' => $info_products->thumbnail_alt,
                'category_slug' => $info_products->category_slug,
                'sub_category_slug' => $info_products->sub_category_slug,
                'slug'          => $info_products->slug
            );
        }

        $this->cart_destroy();

        $response = $this->cart->insert($data);

        if (count($id_array) > 0) {
            if (empty($response)) {
                $response = 'failed';
            } else {
                $response = 'success';
            }
        } else {
            $response = 'success';
        }

        $response =  array(
            'status' => $response,
            'message' => 'Cart updated!'
        );
        echo json_encode($response);
    }

    public function get_item($id){
        $info_products = $this->db
            ->select('products.*, products_category.title as category_title, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_category', 'products.id_products_category = products_category.id')
            ->join('products_sub_category', 'products.id_products_sub_category = products_sub_category.id', 'left')
            ->where('products.id',$id)->get('products')->row();
        $info_products->thumbnail = $this->db->where('id_products', $id)->get('products_image')->row()->thumbnail;

        if (empty($info_products))
        {
            $response = 'false';
        } else {
            $response = 'true';
        }

        $response =  array(
            'response' => $response,
            'item' => $info_products,
        );
        echo json_encode($response);
    }
}