<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_kkm extends CI_Model
{
    protected $table = 'sr_kkm';
	protected $id = 'idkkm';
	protected $order = 'DESC';

	var $column = array('idkkm','k_tingkat','mp_nama','k_kkm','k_kkm');

	function _get_datatables_query()
	{
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_kkm.idkelas','left');
        $this->db->join('sr_mata_pelajaran','sr_mata_pelajaran.idmata_pelajaran = sr_kkm.idmata_pelajaran','left');
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
    
    public function read_data_by_id($id)
    {
        $this->db->select('*','edit as mode');
		$this->db->join('sr_kelas','sr_kelas.idkelas = sr_kkm.idkelas','left');
        $this->db->join('sr_mata_pelajaran','sr_mata_pelajaran.idmata_pelajaran = sr_kkm.idmata_pelajaran','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}

	public function read_data_by_kelas($data)
    {
        $this->db->where($data);
        return $this->db->get($this->table)->result();
	}
	
	public function read_data_by_mapel($id)
    {
        $this->db->select('*');
        $this->db->where('idmata_pelajaran',$id);
        $check = $this->db->get($this->table);
        if($check->num_rows()>0){
            return $check->row();
        } else {
            return false;
        }
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
	
	public function list_kkm()
    {
		$this->db->order_by('idkkm','ASC');
		$this->db->join('sr_kelas','sr_kelas.idkelas = sr_kkm.idkelas','left');
        $this->db->join('sr_mata_pelajaran','sr_mata_pelajaran.idmata_pelajaran = sr_kkm.idmata_pelajaran','left');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Pilih KKM Mata Pelajaran -';
				$result[$row['idkkm']] = ucwords('Kelas '.$row['k_romawi'].' ('.$row['k_keterangan'].') - ('.$row['mp_kode'].') '.$row['mp_nama'].' - KKM = '.$row['k_kkm']);
			}
			return $result;
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
		$this->db->where('idkkm',$id);
		$this->db->delete('sr_interval_predikat');

        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
    }
}