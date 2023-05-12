<?php
class M_holidaycheckout extends CI_Model
{
    protected $table = 'holiday_checkout';

    public function get_data()
    {
        return $this->db->get($this->table);
    }

    public function input_data($table, $data)
    {
        $originalDate_start  = $data['date_start'];
        $originalDate_finish = $data['date_finish'];
        $new_date_start      = date('Y-m-d', strtotime($originalDate_start));
        $new_date_finish     = date('Y-m-d', strtotime($originalDate_finish)); 
        $get_data = array(
            'date_start'     => $new_date_start,
            'date_finish'    => $new_date_finish
        );
        $this->db->insert($table, $get_data);

        //backup data lama input_data tanggal pakai input type date
        // $get_data = array(
        //     'date_start'     => $data['date_start'],
        //     'date_finish'    => $data['date_finish']
        // );
        // $this->db->insert($table, $get_data);
    }

    public function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
    }
    
    public function update_data($where,$data,$table)
    {
        $this->db->where($where);
        $originalDate_start  = $data['date_start'];
        $originalDate_finish = $data['date_finish'];
        $new_date_start      = date('Y-m-d', strtotime($originalDate_start));
        $new_date_finish     = date('Y-m-d', strtotime($originalDate_finish)); 
        $get_data = array(
            'date_start'     => $new_date_start,
            'date_finish'    => $new_date_finish
        );
        $this->db->update($table,$get_data);

        //backup data lama input_data tanggal pakai input type date
        // $this->db->where($where);
        // $this->db->update($table,$data);
    }
}
?>