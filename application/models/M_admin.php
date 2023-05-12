<?php

class M_admin extends CI_Model {

	public function get_data() {
		return $this->db->get('admin');
	}
	public function input_data($data,$table){
		$this->db->insert($table,$data);
	}
	public function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

}
