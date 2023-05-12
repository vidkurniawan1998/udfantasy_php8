<?php

class M_products_category extends CI_Model
{

	protected $table = 'products_category';

	public function get_data($id_language)
	{
		$data = $this->db
            ->where($this->table.'.id_language', $id_language)
            ->get($this->table);
	    return $data;
	}

	public function row_data($where)
	{
		return $this->db->where($where)->get($this->table)->row();
	}

	public function input_data($data_category)
	{
		$this->db->insert($this->table, $data_category);
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

	public function count_data($where)
	{
		return $this->db->where($where)->get($this->table)->count();
	}
}
