<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_tahunpelajaran extends CI_Model
{
    protected $table = 'sr_tahun_pelajaran';
	protected $id = 'idtahun_pelajaran';
	protected $order = 'DESC';
	private $_batchImport;

	var $column = array('idtahun_pelajaran','tp_tahun','idtahun_pelajaran');

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
    
    public function read_data_by_id($id)
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

    public function list_tahun()
    {
        $this->db->order_by('tp_tahun','ASC');
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0){
			foreach ($query->result_array() as $row){
				$result[''] = '- Tahun Pelajaran -';
				$explode = explode('-',$row['tp_tahun']);
				$tahun = $explode[0];
				$semester = $explode[1];
				$result[$row['idtahun_pelajaran']] = ucwords($tahun).' (Semester '.$semester.')';
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
        $this->db->where($this->id,$id);
        $this->db->delete($this->table);
    }

	public function setBatchImport($batchImport) {
        $this->_batchImport = $batchImport;
    }
	
    public function importData() {
        $data = $this->_batchImport;
        $this->db->insert_batch($this->table, $data);
    }
}