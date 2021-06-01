<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_delete extends CI_Model
{
    public function check_data($data,$table)
    {
        $this->db->where($data);
        $check = $this->db->get($table);
        if ($check->num_rows()>0){
            return true;
        } else {
            return false;
        }
    }

    public function check_data_like($id,$pid,$table)
    {
        $this->db->like($id,$pid,'both');
        $check = $this->db->get($table);
        if ($check->num_rows()>0){
            return true;
        } else {
            return false;
        }
    }

    public function delete_data($data,$table)
    {
        $this->db->where($data);
        $this->db->delete($table);
    }

    public function delete_data_like($id,$pid,$table)
    {
        $this->db->like($id,$pid,'both');
        $this->db->delete($table);
    }
}