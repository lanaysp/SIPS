<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_catatan extends CI_Model
{
    protected $table = 'sr_catatan';
	protected $id = 'idcatatan';
	protected $order = 'DESC';

	var $column = array('idcatatan','k_tingkat','s_nama','catatan','idcatatan');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_catatan.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_catatan.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_catatan.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
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

	public function get_datatables($tahun,$id)
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_catatan.idtahun_pelajaran',$tahun);
		$this->db->where('sr_users.idusers',$id);
		$query = $this->db->get();
		return $query->result();
    }
    

	public function count_filtered($tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_catatan.idtahun_pelajaran',$tahun);
		$this->db->where('sr_users.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }

	public function count_all($tahun,$id)
	{
		$this->db->from($this->table);
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_catatan.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->where('sr_kelas.idkelas',$id);
		return $this->db->count_all_results();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_catatan.idsiswa','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}

	public function read_data_by_siswa($id,$tahun,$idusers)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_catatan.idsiswa','left');
        $this->db->where('sr_catatan.idsiswa',$id);
        $this->db->where('sr_catatan.idtahun_pelajaran',$tahun);
        $this->db->where('sr_catatan.idusers',$idusers);
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
	
}