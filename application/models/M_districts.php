<?php

class M_districts extends CI_Model
{

	protected $table = 'districts';
	protected $table_province = 'provinces';
	protected $table_regencies = 'regencies';

	public function get_data()
	{
		return $this->db
            ->select('districts.*','regencies.id AS regency_id', 'regencies.name AS regency_name', 'provinces.id AS province_id', 'provinces.name AS province_name')
            ->join('regencies', 'districts.regency_id = regencies.id', 'right')
            ->join('provinces', 'regencies.province_id = provinces.id', 'right')
            ->order_by('name', 'asc')
            ->get($this->table);
	}

	public function get_where($where)
	{
		return $this->db
            ->select('districts.*','regencies.id AS regency_id', 'regencies.name AS regency_name', 'provinces.id AS province_id', 'provinces.name AS province_name')
            ->join('regencies', 'districts.regency_id = regencies.id', 'right')
            ->join('provinces', 'regencies.province_id = provinces.id', 'right')
            ->where($where)
            ->order_by('districts.name', 'ASC')
            ->get($this->table);
	}

	public function input_data($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function row_data($where) {
		return $this->db
            ->select('districts.*','regencies.id AS regency_id', 'regencies.name AS regency_name', 'provinces.id AS province_id', 'provinces.name AS province_name')
            ->join('regencies', 'district.regency_id = regencies.id', 'right')
            ->join('provinces', 'regencies.province_id = provinces.id', 'right')
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
