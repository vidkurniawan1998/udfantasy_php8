<?php

class M_delivery_coverage extends CI_Model
{

	protected $table = 'delivery_coverage';

	public function get_data()
	{
		return $this->db
            ->select('delivery_coverage.*, districts.name AS district_name')
            ->join('districts', 'delivery_coverage.id_district = districts.id', 'left')
            ->order_by('delivery_coverage.id')
            ->get($this->table);
	}

	public function input_data($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function row_data($where) {
		return $this->db
            ->select('delivery_coverage.*, districts.name AS district_name')
            ->join('districts', 'delivery_coverage.id_district = districts.id', 'left')
            ->where($where)->get($this->table)->row();
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

	function num_rows($where) {
		$this->db->where($where)->get($this->table)->num_rows();
	}
}
