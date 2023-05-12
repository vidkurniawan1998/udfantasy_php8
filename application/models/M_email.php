<?php

class M_email extends CI_Model
{

	protected $table = 'email';

	public function get_data()
	{
		return $this->db->get($this->table);
	}

	public function input_data($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function delete_data($where)
	{
		$this->db->where($where)->delete($this->table);
	}

	function update_data($where, $data)
	{
		$this->db->where($where)->update($this->table, $data);
	}
}
