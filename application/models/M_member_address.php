<?php

class M_member_address extends CI_Model
{

	protected $table = 'member_address';
	protected $table_district = 'districts';
	protected $table_province = 'provinces';
	protected $table_member = 'member';
	protected $table_delivery_coverage = 'delivery_coverage';

	public function get_data()
	{
		return $this->db->get($this->table);
	}

	public function get_where($where)
    {
        return $this->db->where($where)->get($this->table);
    }

    public function get_join_where($where)
    {
        return $this->db
            ->select('member_address.*, districts.name as district_name, provinces.name as province_name, member.name')
            ->join('provinces', $this->table.'.id_province = '.$this->table_province.'.id')
            ->join('districts', $this->table.'.id_district = '.$this->table_district.'.id')
            ->join('member', $this->table.'.id_member = '.$this->table_member.'.id')
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
		return $this->db->delete($this->table);
	}

	function update_data($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->table, $data);
	}

	function num_rows($where) {
		$this->db->where($where)->get($this->table)->num_rows();
	}

	public function delivery_price($where)
    {
        return $this->db
            ->select('delivery_coverage.price')
            ->join($this->table_delivery_coverage, $this->table_delivery_coverage.'.id_district = '.$this->table.'.id_district')
            ->where($where)
            ->get($this->table)
            ->row()
            ->price;
    }
}
