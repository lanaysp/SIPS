<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_profile extends CI_Model
{
	protected $table = 'sr_profile';
	protected $id = 'idprofile';
	
	public function read_data()
	{
		$this->db->select('*');
		$check = $this->db->get($this->table)->num_rows();
		if($check>0){
			$this->db->join('sr_provinsi','sr_provinsi.province_id = sr_profile.idprovinsi','left');
			$this->db->join('sr_kota','sr_kota.city_id = sr_profile.idkota','left');
			$this->db->join('sr_kecamatan','sr_kecamatan.subdistrict_id = sr_profile.idkecamatan','left');
			$this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_profile.idtahun_pelajaran','left');
			$this->db->order_by($this->table.'.'.$this->id,'ASC');
			return $this->db->get($this->table)->row();
		} else {
			return false;
		}
	}
	
	public function update_data($data,$id)
	{
		$this->db->update($this->table,$data);
		$this->db->where($this->id,$id);
		return true;
	}
}