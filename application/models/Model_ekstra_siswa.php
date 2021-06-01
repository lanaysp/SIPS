<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Model_ekstra_siswa extends CI_Model
{
    protected $table = 'sr_ekstra_siswa';
	protected $id = 'idekstra_siswa';
	protected $order = 'DESC';

	var $column = array('idekstra_siswa','sr_kelas.k_tingkat','s_nama','e_nama','es_nilai','es_deskripsi','idekstra_siswa');

	function _get_datatables_query()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_ekstra_siswa.idtahun_pelajaran','left');
        $this->db->join('sr_ekstra','sr_ekstra.idekstra = sr_ekstra_siswa.idekstra','left');
        $this->db->join('sr_users','sr_users.idusers = sr_ekstra_siswa.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_ekstra_siswa.idsiswa','left');
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
    
    var $column_admin = array('idekstra_siswa','sr_kelas.k_tingkat','s_nama','e_nama','es_nilai','es_deskripsi','users.first_name','sr_siswa.idsiswa');

	function _get_datatables_query_admin()
	{
        $this->db->join('sr_tahun_pelajaran','sr_tahun_pelajaran.idtahun_pelajaran = sr_ekstra_siswa.idtahun_pelajaran','left');
        $this->db->join('sr_users','sr_users.idusers = sr_ekstra_siswa.idusers','left');
        $this->db->join('users','users.id = sr_users.idusers','left');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_ekstra_siswa.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
        $this->db->join('sr_ekstra','sr_ekstra.idekstra = sr_ekstra_siswa.idekstra','left');
		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_admin as $item){
			if ($_POST['search']['value']){
				if ($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_admin) - 1 == $i){
					$this->db->group_end();
				}
			}
			$column_admin[$i] = $item;
			$i++;
		}

		if (isset($_POST['order'])){
			$this->db->order_by($column_admin[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
        $this->db->where('sr_ekstra_siswa.idtahun_pelajaran',$tahun);
		$this->db->where('sr_users.idusers',$id);
		$query = $this->db->get();
		return $query->result();
    }
    
    public function get_datatables_admin($tahun,$idusers)
	{
		$this->_get_datatables_query_admin();
		if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'],$_POST['start']);
        $this->db->where('sr_ekstra_siswa.idtahun_pelajaran',$tahun);
        $this->db->where('sr_ekstra_siswa.idusers',$idusers);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($tahun,$id)
	{
		$this->_get_datatables_query();
        $this->db->where('sr_ekstra_siswa.idtahun_pelajaran',$tahun);
		$this->db->where('sr_users.idusers',$id);
		$query = $this->db->get();
		return $query->num_rows();
    }
    
    public function count_filtered_admin($tahun,$idusers)
	{
		$this->_get_datatables_query_admin();
        $this->db->where('sr_ekstra_siswa.idtahun_pelajaran',$tahun);
        $this->db->where('sr_ekstra_siswa.idusers',$idusers);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($tahun,$id)
	{
		$this->db->from($this->table);
        $this->db->where('idtahun_pelajaran',$tahun);
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_ekstra_siswa.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		$this->db->where('sr_kelas.idkelas',$id);
		return $this->db->count_all_results();
    }

    public function count_all_admin($tahun,$idusers)
	{
		$this->db->from($this->table);
        $this->db->where('sr_ekstra_siswa.idtahun_pelajaran',$tahun);
        $this->db->where('sr_ekstra_siswa.idusers',$idusers);
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_ekstra_siswa.idsiswa','left');
        $this->db->join('sr_kelas','sr_kelas.idkelas = sr_siswa.idkelas','left');
		return $this->db->count_all_results();
    }
    
    public function read_data_by_id($id)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_ekstra_siswa.idsiswa','left');
        $this->db->join('sr_ekstra','sr_ekstra.idekstra = sr_ekstra_siswa.idekstra','left');
        $this->db->where($this->id,$id);
        return $this->db->get($this->table)->row_array();
	}

	public function read_data_by_siswa($id,$tahun,$idusers)
    {
		$this->db->select('*','edit as mode');
        $this->db->join('sr_siswa','sr_siswa.idsiswa = sr_ekstra_siswa.idsiswa','left');
        $this->db->join('sr_ekstra','sr_ekstra.idekstra = sr_ekstra_siswa.idekstra','left');
        $this->db->where('sr_ekstra_siswa.idsiswa',$id);
        $this->db->where('sr_ekstra_siswa.idtahun_pelajaran',$tahun);
        $this->db->where('sr_ekstra_siswa.idusers',$idusers);
		$check = $this->db->get($this->table);
		if($check->num_rows()>0){
            return $check->result();
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