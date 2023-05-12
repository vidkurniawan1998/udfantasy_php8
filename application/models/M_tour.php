<?php

class M_tour extends CI_Model
{

	private $table = 'tour';

	public function get_data()
	{
		return $this->db->get($this->table);
	}

	public function get_where($where)
	{
		return $this->db->where($where)->get($this->table);
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
