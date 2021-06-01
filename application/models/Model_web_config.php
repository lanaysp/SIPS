<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_web_config extends CI_Model
{
    protected $table = 'sr_web_config';
	protected $id = 'idweb_config';
	protected $order = 'DESC';

	public function read_data_check_rapor()
	{
		$this->db->where('config_name','check_rapor');
		$check = $this->db->get($this->table);
		if($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	public function read_data_naik_kelas()
	{
		$this->db->where('config_name','naik_kelas');
		$check = $this->db->get($this->table);
		if($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	public function read_data_new_version()
	{
		$this->db->where('config_name','new_version');
		$check = $this->db->get($this->table);
		if($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	public function read_data_reset_password()
	{
		$this->db->where('config_name','reset_password');
		$check = $this->db->get($this->table);
		if($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	public function read_data_no_validate_delete()
	{
		$this->db->where('config_name','no_validate_delete');
		$check = $this->db->get($this->table);
		if($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}

	public function update_data($name,$value)
	{
		$this->db->where('config_name',$name);
		return $this->db->update($this->table,$value);
	}	
	
}