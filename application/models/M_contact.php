<?php

class M_contact extends CI_Model {

    protected $table = 'contact';

	public function get_data() {
		return $this->db->get('contact');
	}
	public function input_data($data){
		$this->db->insert($this->table, $data);
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
