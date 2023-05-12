<?php

class M_checkout_item extends CI_Model
{

	protected $table = 'checkout_item';

	public function get_data()
	{
		return $this->db->get($this->table);
	}

	public function get_where($where)
	{
		return $this->db
            ->select('checkout_item.*, products_image.thumbnail, products.slug, products.thumbnail_alt, products_category.slug as category_slug, products_sub_category.slug as sub_category_slug')
            ->join('products_image', 'products_image.id_products = checkout_item.id_product')
            ->join('products', 'products.id = checkout_item.id_product')
            ->join('products_category', 'products.id_products_category = products_category.id')
            ->join('products_sub_category', 'products.id_products_sub_category = products_sub_category.id', 'left')
            ->where($where)
            ->get($this->table);
	}

	public function input_data($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function row_data($where) {
		return $this->db->where($where)->get($this->table)->row();
	}

	public function delete_data($where)
	{
		$this->db->where($where);
		$this->db->delete($this->table);
	}

	function update_data($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->table, $data);
	}
}
