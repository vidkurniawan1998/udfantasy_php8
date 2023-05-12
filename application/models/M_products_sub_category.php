<?php

class M_products_sub_category extends CI_Model
{

	protected $table = 'products_sub_category';

	public function get_data($id)
	{
		return $this->db->where('id_parent_category',$id)->get($this->table);
	}

	public function get_parent_data($id)
    {
        return $this->db->where('id',$id)->get('products_category')->row();
    }

	public function row_data($where)
	{
		return $this->db->where($where)->get($this->table)->row();
	}

	public function count_data($where)
	{
		return $this->db->where($where)->get($this->table)->num_rows();
	}

	public function input_data($data)
	{
		$this->db->insert($this->table, $data);
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
