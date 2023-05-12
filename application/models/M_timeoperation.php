<?php
class M_timeoperation extends CI_Model
{
    protected $table = 'timeoperation';   
    
    public function get_data()
    {
        return $this->db->get($this->table);
    }

    public function input_data($data,$table)
    {
        $get_data = array(
            'hari'     => $data['hari'],
            'jam_buka' => $data['jam_buka'],
            'jam_tutup'=> $data['jam_tutup']
        );
        $this->db->insert($table, $get_data);
    }

    public function update_data($where,$data,$table)
    {
        $this->db->where($where);
        $this->db->update($table,$data);
    }

    public function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
}
?>