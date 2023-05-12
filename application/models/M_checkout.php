<?php

class M_checkout extends CI_Model
{

	protected $table = 'checkout';
	protected $table_member = 'member';
	protected $table_member_address = 'member_address';
	protected $table_city = 'districts';
	protected $table_province = 'provinces';

	public function get_data()
	{
		return $this->db->get($this->table);
	}

	public function get_where($where)
	{
		return $this->db->where($where)->get($this->table);
	}

	public function get_join_data()
    {
        return $this->db
            ->select($this->table.'.*, date_format(checkout.created_at, "%d-%m-%Y") as created_at_formatted, member.name, member.email, member.phone as member_phone, member_address.address, 
                    member_address.receiver_name,member_address.postcode, member_address.phone, districts.name as district_name, provinces.name as province_name')
                ->join('member', $this->table.'.id_member = '. $this->table_member.'.id')
                ->join('member_address', $this->table.'.id_member_address = '. $this->table_member_address.'.id')
                ->join('districts', $this->table_member_address.'.id_district = '. $this->table_city.'.id')
                ->join('provinces', $this->table_member_address.'.id_province = '. $this->table_province.'.id')
            ->order_by('created_at', 'DESC')
            ->get($this->table);
    }

    public function get_join_no_off_where($where)
    {
        return $this->db
            ->select($this->table.'.*, date_format(checkout.created_at, "%d-%m-%Y") as created_at_formatted, 
                    member.name, member.email, member.phone as member_phone, member_address.address, member_address.receiver_name,member_address.postcode, member_address.phone, 
                    districts.name as district_name, provinces.name as province_name')
                ->join('member', $this->table.'.id_member = '. $this->table_member.'.id')
                ->join('member_address', $this->table.'.id_member_address = '. $this->table_member_address.'.id')
                ->join('districts', $this->table_member_address.'.id_district = '. $this->table_city.'.id')
                ->join('provinces', $this->table_member_address.'.id_province = '. $this->table_province.'.id')
            ->where($where)
            ->get($this->table);
    }

	public function get_join_where($where, $offset = '')
    {
        return $this->db
            ->select($this->table.'.*, date_format(checkout.created_at, "%d-%m-%Y") as created_at_formatted, member.name, member.email, member.phone as member_phone, member_address.address, 
            member_address.receiver_name,member_address.postcode, member_address.phone, districts.name as district_name, provinces.name as province_name')
                ->join('member', $this->table.'.id_member = '. $this->table_member.'.id')
                ->join('member_address', $this->table.'.id_member_address = '. $this->table_member_address.'.id')
                ->join('districts', $this->table_member_address.'.id_district = '. $this->table_city.'.id')
                ->join('provinces', $this->table_member_address.'.id_province = '. $this->table_province.'.id')
            ->where($where)
            ->order_by('created_at', 'DESC')
            ->get($this->table, 10, $offset);
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

	public function get_today_order_num($curr_date)
    {
        return $this->db->where('DATE(created_at)', $curr_date)->get($this->table)->num_rows();
    }

    public function get_unpaid_checkout_date($where)
    {
        return $this->db->select('id, created_at')->where($where)->get($this->table)->result();
    }
}
