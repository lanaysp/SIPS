<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_mapel extends CI_Model
{
    protected $table = 'sr_mata_pelajaran';
	protected $id = 'idmata_pelajaran';
	protected $order = 'DESC';

	var $column = array('idmata_pelajaran','mp_kode','mp_nama','mp_kelompok','mp_urutan','idmata_pelajaran');

	function _get_datatables_query()
	{
		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column as $item){
			if ($_POST['search']['value']){
				if ($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column) - 1 == $i){
					$this->db->group_end();
				}
			}
			$column[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])){
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function count_all_dashboard()
	{
		return $this->db->get($this->table)->num_rows();
    }
	
	public function list_mapel()
    {
        $this->db->order_by('mp_kode','ASC');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Mata Pelajaran -';
				$result[$row['idmata_pelajaran']] = ucwords($row['mp_kode'].' - '.$row['mp_nama']);
			}
			return $result;
		}
	}
	
	public function read_data()
    {
        $this->db->select('*');
        $this->db->order_by('mp_nama','ASC');
        return $this->db->get($this->table)->result();
	}

	public function read_data_a()
    {
		$this->db->select('*');
		$this->db->where('mp_kelompok','A');
        $this->db->order_by('mp_urutan','ASC');
        return $this->db->get($this->table)->result();
	}

	public function read_data_b()
    {
		$this->db->select('*');
		$this->db->where('mp_kelompok','B');
        $this->db->order_by('mp_urutan','ASC');
        return $this->db->get($this->table)->result();
	}
    
    public function read_data_by_id($id)
    {
        $this->db->select('*','edit as mode');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}

	public function read_one_data_by_id($id)
    {
        $this->db->select('mp_nama');
        $this->db->where($this->id,$id);
		$check = $this->db->get($this->table);
		if ($check->num_rows()>0){
			return $check->row();
		} else {
			return false;
		}
	}
	
	public function read_mapel_by_guru_kelas($id)
    {
        $this->db->select('*','edit as mode');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}
	
	public function check_data($data)
    {
        $this->db->select('*');
        $this->db->where($data);
        $check = $this->db->get($this->table)->num_rows();
        if($check>0){
            return true;
        } else {
            return false;
        }
    }

    public function create_data($data)
    {
        $this->db->insert($this->table,$data);
    }

    public function update_data($data,$id)
    {
        $this->db->where($this->id,$id);
        $this->db->update($this->table,$data);
    }

    public function delete_data($id)
    {
        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
	}
	
	// ********* GURU ********* \\

	public function list_mapel_by_id($id)
    {
		$this->db->order_by('mp_kode','ASC');
		$this->db->join('sr_mata_pelajaran_guru','sr_mata_pelajaran_guru.idmata_pelajaran = sr_mata_pelajaran.idmata_pelajaran','');
		$this->db->where('sr_mata_pelajaran_guru.idusers',$id);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih Mata Pelajaran -';
				$result[$row['idmata_pelajaran']] = ucwords($row['mp_kode'].' - '.$row['mp_nama']);
			}
			return $result;
		}
    }

	// ********* GURU ********* //
}