<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_alamat extends CI_Model
{
	function read_provinsi_by_id($id)
	{
		$this->db->where('province_id',$id);
		return $this->db->get('sr_provinsi');
	}
	
	function read_kota_by_id($id)
	{
		$this->db->where('city_id',$id);
		return $this->db->get('sr_kota');
	}
	
	function read_kecamatan_by_id($id)
	{
		$this->db->where('subdistrict_id',$id);
		return $this->db->get('sr_kecamatan');
	}
	
	function read_provinsi()
	{
		$this->db->order_by('province','ASC');
		$query = $this->db->get('sr_provinsi');
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Provinsi -';
				$result[$row['province_id']] = ucwords(strtolower($row['province']));
			}
			return $result;
		}
	}

	function read_kota($id)
	{
		$this->db->where('province_id',$id);
		$this->db->order_by('city_name','ASC');
		$query = $this->db->get('sr_kota');
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Kota -';
				$result[$row['city_id']] = ucwords(strtolower($row['city_name']));
			}
			return $result;
		} else {
			$result[''] = '- Pilih Kota -';
			return $result;
		}
	}

	function read_kecamatan($id)
	{
		$this->db->where('city_id',$id);
		$this->db->order_by('subdistrict_name','ASC');
		$query = $this->db->get('sr_kecamatan');
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Kecamatan -';
				$result[$row['subdistrict_id']] = ucwords(strtolower($row['subdistrict_name']));
			}
			return $result;
		} else {
			$result[''] = '- Pilih Kecamatan -';
			return $result;
		}
	}
}